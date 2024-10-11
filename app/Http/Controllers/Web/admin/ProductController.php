<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Designer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ProductController extends Controller
{

    protected $client;
    protected $token;

    public function __construct()
    {
        $this->client = new Client();

        $response = $this->client->post('https://api.sirv.com/v2/token', [
            'json' => [
                'clientId' => env('SIRV_CLIENT_ID'),
                'clientSecret' => env('SIRV_CLIENT_SECRET'),
            ],
        ]);

        $this->token = json_decode($response->getBody()->getContents())->token;
    }

    public function show($id){
        $product= Product::where('id',$id)->with('designer','categories','images','subcategories')->first();
        return view('admin.products.show',compact('product'));

    }

    public function index(Request $request){
        $query = Product::with('designer', 'categories', 'images', 'subcategories');


        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('style_number', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->has('designer') && $request->designer != '') {
            $query->whereHas('designer', function($q) use ($request) {
                $q->where('f_name', 'LIKE', '%' . $request->designer . '%');
            });
        }


        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }


        if ($request->has('min_price') && $request->min_price != '' && $request->has('max_price') && $request->max_price != '') {
            $query->whereBetween('price', [(float)$request->min_price, (float)$request->max_price]);
        }


        if ($request->has('tags') && is_array($request->tags)) {
            $query->whereJsonContains('tags', $request->tags);
        }

        if ($request->has('sort')){

            $query->orderBy('id',$request->sort);
        }

        $per_page=$request->has('per_page') ? $request->per_page : 10;
        $products = $query->paginate($per_page);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(){
        try {
            $designers = Designer::all();
            $categories = Category::with('subcategories')->get();
            $collection = Collection::all();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('admin.products.index')->with('error', 'Error loading designers, categories, or collection.');
        }

        return view('admin.products.create',compact('designers','categories','collection'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'name_ar'=>'required|string|max:255',
            'style_number' => 'required|string|unique:products,style_number|max:255',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_status' => 'nullable|boolean',
            'designer_id'=>"",
            'quantity'=>'required|numeric'
        ]);

        try {

        if ($validator->fails()) {

            return redirect()->route('admin.products.create')->with('error', $validator->errors());
        }

        $designer = Designer::find($request->designer_id);

        if (!$designer) {

            return redirect()->route('admin.products.create')->with('error', 'Designer not found.');
        }

        $product = Product::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'style_number' => $request->style_number,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sizes' => $request->sizes ? json_encode($request->sizes) : null,
            'colors' => $request->colors ? json_encode($request->colors) : null,
            'discount_percentage' => $request->discount_percentage,
            'discount_status' => $request->discount_status ? true : false,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'designer_id' => $designer->id,
            'quantity' => $request->quantity
        ]);

        // $imagesData = [];
        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $image) {
        //         $imageName = "product_" . Carbon::now()->format('YmdHis') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        //         $imagePath = $image->storeAs('public/upload/files/image/', $imageName);

        //         $imagesData[] = [
        //             'image_path' => $imagePath,
        //         ];
        //     }
        // }

        // $product->images()->createMany($imagesData);

        $imagesData = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a unique hashed image name
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/product/' . $hashed_image;

                // Get image content
                $imageContent = file_get_contents($image->getPathname());

                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);


                // Store the URL of the uploaded image in $imagesData
                $imagesData[] = [
                    'image_path' => 'https://hooray-lb.sirv.com/fee/product/' . $hashed_image,
                ];
            }
        }

        // Assuming $product is the model that has a relationship with images, store all uploaded image URLs
        $product->images()->createMany($imagesData);


        if ($request->colors) {
            $colors = [];
            foreach ($request->colors as $color) {
                $colors[] = $color;
            }
            $product->colors = $colors;
        }

        if ($request->sizes) {
            $sizes = [];
            foreach ($request->sizes as $size) {
                $sizes[] = $size;
            }
            $product->sizes = $sizes;
        }

        if ($request->tags) {
            $tags = [];
            foreach ($request->tags as $tag) {
                $tags[] = $tag;
            }
            $product->tags = $tags;
        }

        $categories = $request->input('categories');
        if ($categories) {
            foreach ($categories as $categoryName) {
                $category = Category::firstOrCreate(['id' => $categoryName]);
                $product->categories()->attach($category->id);
            }
        }
        $subcategories = $request->input('subcategories');
        if ($subcategories) {
            foreach ($subcategories as $subcategoryID) {
                $subcategory = Subcategory::firstOrCreate(['id' => $subcategoryID]);
                $product->subcategories()->attach($subcategory->id);
            }
        }
        $collections = $request->input('collections');
        if ($collections) {
            $product->collections()->detach();
            foreach ($collections as $collectionID) {
                $collection = Collection::firstOrCreate(['id' => $collectionID]);
                $product->collections()->attach($collection->id);
            }
        }
        $product->content_en = $request->content_en;
        $product->content_ar = $request->content_ar;

        $product->save();

        return redirect()->route('admin.products.index')->with('message', 'Product created successfully!');

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return redirect()->route('admin.products.create')->with('error', $e);
    }
    }

    public function edit($id)
    {
        $product = Product::with('designer', 'categories', 'images', 'subcategories')->find($id);
        $designers = Designer::all();
        $categories = Category::with('subcategories')->get();
        $collection = Collection::all();


        $subcategories = $categories->flatMap(function ($category) {
            return $category->subcategories;
        });

        return view('admin.products.edit', compact('product', 'designers', 'categories', 'collection', 'subcategories'));
    }


    public function getSubcategoriesByCategories(Request $request)
    {
        $categoryIds = explode(',', $request->query('category_ids'));
        $subcategories = Subcategory::whereIn('category_id', $categoryIds)->get(['id', 'name']);
        return response()->json(['subcategories' => $subcategories]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);




        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'style_number' => 'required|string|max:255|unique:products,style_number,'.$id,
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_status' => 'nullable|boolean',
            'quantity' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $product->name = $request->name;
        $product->style_number = $request->style_number;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->discount_percentage = $request->discount_percentage;
        $product->discount_status = $request->discount_status ? true : false;
        $product->quantity = $request->quantity;
        $product->content_en = $request->content_en;
        $product->content_ar = $request->content_ar;
        if ($request->colors) {
            $colors = [];
            foreach ($request->colors as $color) {
                $colors[] = $color;
            }
            $product->colors = $colors;
        }

        if ($request->sizes) {
            $sizes = [];
            foreach ($request->sizes as $size) {
                $sizes[] = $size;
            }
            $product->sizes = $sizes;
        }
        if ($request->tags) {
            $tags = [];
            foreach ($request->tags as $tag) {
                $tags[] = $tag;
            }
            $product->tags = $tags;
        }
        $product->description = $request->description;


        $categories = $request->input('categories');
        if ($categories) {
            $product->categories()->detach();
            foreach ($categories as $categoryName) {
                $category = Category::firstOrCreate(['name' => $categoryName]);
                $product->categories()->attach($category->id);
            }
        }

        $subcategories = $request->input('subcategories');
        if ($subcategories) {

            foreach ($subcategories as $subcategoryId) {
                $subcategory = Subcategory::find($subcategoryId);
                $product->subcategories()->attach($subcategory->id);
            }
        }



        $collections = $request->input('collections');
        if ($collections) {
            $product->collections()->detach();
            foreach ($collections as $collectionID) {
                $collection = Collection::firstOrCreate(['id' => $collectionID]);
                $product->collections()->attach($collection->id);
            }
        }

        $imagesData = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a unique hashed image name
                $hashed_image = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $filename = '/fee/product/' . $hashed_image;

                // Get image content
                $imageContent = file_get_contents($image->getPathname());

                // Upload the image via Guzzle
                $response = $this->client->request('POST', "https://api.sirv.com/v2/files/upload?filename=" . urlencode($filename), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => $imageContent,
                ]);

                // Store the URL of the uploaded image in $imagesData
                $imagesData[] = [
                    'image_path' => 'https://hooray-lb.sirv.com/fee/product/' . $hashed_image,
                ];
            }
        }

        // Assuming the product has a relationship with images
        $product->images()->createMany($imagesData);


        $product->save();

        return redirect()->route('admin.products.index')->with('message', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('message', 'Product deleted successfully!');
    }

    public function remove_image($id){
        $image=ProductImage::findOrFail($id);
        $image->delete();
        return redirect()->back()->with('message', 'Image deleted successfully!');
    }
}
