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

class ProductController extends Controller
{


    public function show($id){
        $product= Product::where('id',$id)->with('designer','categories','images','subcategories')->first();
        return view('admin.products.show',compact('product'));

    }
    public function index(){
        $products = Product::with('designer','categories','images','subcategories')->paginate(10);
        return view('admin.products.index',compact('products'));
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
            'designer_id'=>""
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
        ]);

        $imagesData = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = "product_" . Carbon::now()->format('YmdHis') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/upload/files/image/', $imageName);

                $imagesData[] = [
                    'image_path' => $imagePath,
                ];
            }
        }

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


        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');

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


        if ($request->hasFile('images')) {

            $product->images()->delete();


            $imagesData = [];
            foreach ($request->file('images') as $image) {
                $imageName = "product_" . Carbon::now()->format('YmdHis') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/upload/files/image/', $imageName);

                $imagesData[] = [
                    'image_path' => $imagePath,
                ];
            }
            $product->images()->createMany($imagesData);
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
