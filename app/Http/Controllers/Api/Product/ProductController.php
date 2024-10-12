<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Designer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
        public function create(Request $request)
        {
            try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'style_number' => 'required|string|unique:products,style_number|max:255',
                    'price' => 'required|numeric|min:0',
                    'sale_price' => 'nullable|numeric|min:0',
                    'sizes' => 'nullable|array',
                    'colors' => 'nullable|array',
                    'description' => 'nullable|string',
                    'discount_percentage' => 'nullable|numeric|min:0|max:100',
                    'discount_status' => 'nullable|boolean',
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                $designer = Designer::find(Auth::id());

                if (!$designer) {
                    return response()->json(['message' => 'Designer not found.'], 404);
                }

                $product = Product::create([
                    'name' => $request->name,
                    'style_number' => $request->style_number,
                    'price' => $request->price,
                    'sale_price' => $request->sale_price,
                    'sizes' => $request->sizes ? json_encode($request->sizes) : null,
                    'colors' => $request->colors ? json_encode($request->colors) : null,
                    'discount_percentage' => $request->discount_percentage,
                    'discount_status' => $request->discount_status ? true : false,
                    'description' => $request->description,
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
                        $category = Category::firstOrCreate(['name' => $categoryName]);
                        $product->categories()->attach($category->id);
                    }
                }
                $subcategories = $request->input('subcategories');
                if ($subcategories) {
                    foreach ($subcategories as $subcategoryData) {
                        $categoryName = $subcategoryData['category'];
                        $subcategoryName = $subcategoryData['name'];

                        $category = Category::firstOrCreate(['name' => $categoryName]);
                        $subcategory = Subcategory::firstOrCreate(['name' => $subcategoryName, 'category_id' => $category->id]);

                        $product->subcategories()->attach($subcategory->id);
                    }
                }
                $product->save();
                return response()->json([
                    'message' => 'Product created successfully.',
                    'product' => $product->load('categories', 'subcategories', 'images'),
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }


        public function update(Request $request, $productId)
        {
            try {
                $product = Product::findOrFail($productId);


                if ($product->designer_id !== Auth::id()) {
                    return response()->json(['message' => 'Unauthorized. You do not have permission to update this product.'], 403);
                }

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'style_number' => 'required|string|max:255|unique:products,style_number,'.$productId,
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
                    $product->subcategory()->detach();
                    foreach ($subcategories as $subcategoryData) {
                        $categoryName = $subcategoryData['category'];
                        $subcategoryName = $subcategoryData['name'];

                        $category = Category::firstOrCreate(['name' => $categoryName]);
                        $subcategory = Subcategory::firstOrCreate(['name' => $subcategoryName, 'category_id' => $category->id]);

                        $product->subcategories()->attach($subcategory->id);
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

                return response()->json([
                    'message' => 'Product updated successfully.',
                    'product' => $product->load('categories', 'subcategories', 'images'),
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
        public function new_user(Request $request)
        {
            try {
                $perPage = $request->per_page ? $request->per_page : 10;

                $query = Product::with('images', 'designer', 'categories');


                if ($request->has('categories')) {
                    $query->whereHas('categories', function ($q) use ($request) {
                        $q->whereIn('categories.id', $request->categories);
                    });
                }

                if ($request->has('collections')) {
                    $query->whereHas('collections', function ($q) use ($request) {
                        $q->whereIn('collections.id', $request->collections);
                    });
                }


                if ($request->has('price_min') && $request->has('price_max')) {
                    $query->whereBetween('price', [$request->price_min, $request->price_max]);
                }


                if ($request->has('brands')) {
                    $query->whereHas('designer', function ($q) use ($request) {
                        $q->whereIn('designers.id', $request->brands);
                    });
                }


                if ($request->has('tags')) {

                    $query->whereJsonContains('tags', $request->tags);
                }

                if($request->has('order_by')){

                    $query->orderBy('id', $request->order_by);
                }

                if ($request->has('sort_by')) {
                    switch ($request->sort_by) {
                        case 'date_desc':
                            $query->orderBy('created_at', 'desc');
                            break;
                        case 'date_asc':
                            $query->orderBy('created_at', 'asc');
                            break;
                        case 'price_desc':
                            $query->orderBy('price', 'desc');
                            break;
                        case 'price_asc':
                            $query->orderBy('price', 'asc');
                            break;
                        default:
                            $query->orderBy('id', 'asc'); // Default sorting by ID
                            break;
                    }
                }


                $products = $query->paginate($perPage);

                $response = [
                    'status' => 'success',
                    'data' => $products,
                    'total' => $request->price_min
                ];

                if (Auth::user()) {
                    $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                    $response['wishlist'] = $wishlistProductIds;
                }

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function index(Request $request)
        {
            try {
                $perPage = $request->per_page ? $request->per_page : 10;

                $query = Product::with('images', 'designer', 'categories', 'collections');


                if ($request->has('categories')) {
                    $query->whereHas('categories', function ($q) use ($request) {
                        $q->whereIn('categories.id', $request->categories);
                    });
                }


                if ($request->has('price_min') && $request->has('price_max')) {
                    $query->whereBetween('price', [$request->price_min, $request->price_max]);
                }


                if ($request->has('brands')) {
                    $query->whereHas('designer', function ($q) use ($request) {
                        $q->whereIn('designers.id', $request->brands);
                    });
                }


                if ($request->has('tags')) {

                    $query->whereJsonContains('tags', $request->tags);
                }

                if($request->has('order_by')){

                    $query->orderBy('id', $request->order_by);
                }

                if ($request->has('sort_by')) {
                    switch ($request->sort_by) {
                        case 'date_desc':
                            $query->orderBy('created_at', 'desc');
                            break;
                        case 'date_asc':
                            $query->orderBy('created_at', 'asc');
                            break;
                        case 'price_desc':
                            $query->orderBy('price', 'desc');
                            break;
                        case 'price_asc':
                            $query->orderBy('price', 'asc');
                            break;
                        default:
                            $query->orderBy('id', 'asc'); // Default sorting by ID
                            break;
                    }
                }


                $products = $query->paginate($perPage);

                $response = [
                    'status' => 'success',
                    'data' => $products,
                ];

                if (Auth::user()) {
                    $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                    $cartProductIds = Auth::user()->cart ? Auth::user()->cart->products()->pluck('product_id')->toArray() : [];
                    $response['wishlist'] = $wishlistProductIds;
                    $response['cart'] = $cartProductIds;
                }

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function getDesignerProducts(Request $request)
        {
            try {
                $perPage = $request->per_page ? $request->per_page : 10;
                $designerId = Auth::id();

                $query = Product::with('images', 'designer','categories')
                    ->where('designer_id', $designerId);


            if ($request->has('categories')) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->whereIn('categories.id', $request->categories);
                });
            }
            if ($request->has('collections')) {
                $query->whereHas('collections', function ($q) use ($request) {
                    $q->whereIn('collections.id', $request->collections);
                });
            }


            if ($request->has('price_min') && $request->has('price_max')) {
                $query->whereBetween('price', [$request->price_min, $request->price_max]);
            }


            if ($request->has('brands')) {
                $query->whereHas('designer', function ($q) use ($request) {
                    $q->whereIn('designers.id', $request->brands);
                });
            }


            if ($request->has('tags')) {

                $query->whereJsonContains('tags', $request->tags);
            }

            if($request->has('order_by')){

                $query->orderBy('id', $request->order_by);
            }

            if ($request->has('sort_by')) {
                switch ($request->sort_by) {
                    case 'date_desc':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'date_asc':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;
                    default:
                        $query->orderBy('id', 'asc'); // Default sorting by ID
                        break;
                }
            }


            $products = $query->paginate($perPage);

            $response = [
                'status' => 'success',
                'data' => $products,
            ];

            if (Auth::user()) {
                $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                $cartProductIds = Auth::user()->cart ? Auth::user()->cart->products()->pluck('product_id')->toArray() : [];
                $response['wishlist'] = $wishlistProductIds;
                $response['cart'] = $cartProductIds;
            }

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
        }

        public function getDesignerProductsForUsers_new(Request $request)
        {
            try {
                $perPage = $request->per_page ? $request->per_page : 10;
                $designerId = $request->designer_id;

                $designer=Designer::where('id',$designerId)->first();

                $query = Product::with('images', 'designer', 'categories')
                    ->where('designer_id', $designerId);

                if ($request->has('categories')) {
                    $query->whereHas('categories', function ($q) use ($request) {
                        $q->whereIn('categories.id', $request->categories);
                    });
                }
                if ($request->has('collections')) {
                    $query->whereHas('collections', function ($q) use ($request) {
                        $q->whereIn('collections.id', $request->collections);
                    });
                }

                if ($request->has('price_min') && $request->has('price_max')) {
                    $query->whereBetween('price', [$request->price_min, $request->price_max]);
                }

                if ($request->has('brands')) {
                    $query->whereHas('designer', function ($q) use ($request) {
                        $q->whereIn('designers.id', $request->brands);
                    });
                }

                if ($request->has('tags')) {
                    $query->whereJsonContains('tags', $request->tags);
                }

                if ($request->has('order_by')) {
                    $query->orderBy('id', $request->order_by);
                }

                if ($request->has('sort_by')) {
                    switch ($request->sort_by) {
                        case 'date_desc':
                            $query->orderBy('created_at', 'desc');
                            break;
                        case 'date_asc':
                            $query->orderBy('created_at', 'asc');
                            break;
                        case 'price_desc':
                            $query->orderBy('price', 'desc');
                            break;
                        case 'price_asc':
                            $query->orderBy('price', 'asc');
                            break;
                        default:
                            $query->orderBy('id', 'asc'); // Default sorting by ID
                            break;
                    }
                }

                $products = $query->paginate($perPage);

                $response = [
                    'status' => 'success',
                    'data' => $products,
                    'designer'=>$designer
                ];

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }


        public function getDesignerProductsForUsers(Request $request)
        {
            try {
                $designerId = $request->designer_id;

                $designer=Designer::where('id',$designerId)->first();

                if(!$designer){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'designer not found',
                    ],404);
                }
                $perPage = $request->per_page ? $request->per_page : 10;

                $query = Product::with('images', 'designer', 'categories')
                    ->where('designer_id', $designerId);

                if ($request->has('categories')) {
                    $query->whereHas('categories', function ($q) use ($request) {
                        $q->whereIn('categories.id', $request->categories);
                    });
                }
                if ($request->has('collections')) {
                    $query->whereHas('collections', function ($q) use ($request) {
                        $q->whereIn('collections.id', $request->collections);
                    });
                }

                if ($request->has('price_min') && $request->has('price_max')) {
                    $query->whereBetween('price', [$request->price_min, $request->price_max]);
                }

                if ($request->has('brands')) {
                    $query->whereHas('designer', function ($q) use ($request) {
                        $q->whereIn('designers.id', $request->brands);
                    });
                }

                if ($request->has('tags')) {
                    $query->whereJsonContains('tags', $request->tags);
                }

                if ($request->has('order_by')) {
                    $query->orderBy('id', $request->order_by);
                }

                if ($request->has('sort_by')) {
                    switch ($request->sort_by) {
                        case 'date_desc':
                            $query->orderBy('created_at', 'desc');
                            break;
                        case 'date_asc':
                            $query->orderBy('created_at', 'asc');
                            break;
                        case 'price_desc':
                            $query->orderBy('price', 'desc');
                            break;
                        case 'price_asc':
                            $query->orderBy('price', 'asc');
                            break;
                        default:
                            $query->orderBy('id', 'asc'); // Default sorting by ID
                            break;
                    }
                }

                $products = $query->paginate($perPage);
                $response = [
                    'status' => 'success',
                    'data' => $products,
                    'designer'=>$designer
                ];

                if (Auth::user()) {
                    $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                    $cartProductIds = Auth::user()->cart ? Auth::user()->cart->products()->pluck('product_id')->toArray() : [];
                    $response['wishlist'] = $wishlistProductIds;
                    $response['cart'] = $cartProductIds;
                }

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }


        public function delete($productId)
        {
            try {
                $product = Product::findOrFail($productId);

                if ($product->designer_id !== Auth::id()) {
                    return response()->json(['message' => 'Unauthorized. You do not have permission to delete this product.'], 403);
                }


                foreach ($product->images as $image) {
                    Storage::delete($image->image_path);
                }

                $product->images()->delete();


                $product->delete();

                return response()->json(['message' => 'Product deleted successfully.'], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }


        public function getProductById_new($productId)
        {
            try {
                $product = Product::with('images', 'designer', 'categories')->findOrFail($productId);
                $response = [
                    'status' => 'success',
                    'data' => $product,
                ];


                if (Auth::user()) {
                    $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                    $cartProductIds = Auth::user()->cart ? Auth::user()->cart->products()->pluck('product_id')->toArray() : [];
                    $response['wishlist'] = $wishlistProductIds;
                    $response['cart'] = $cartProductIds;
                }

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function getProductById($productId)
        {
            try {
                $product = Product::with('images', 'designer', 'categories')->findOrFail($productId);
                $response = [
                    'status' => 'success',
                    'data' => $product,
                ];

                if (Auth::user()) {
                    $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                    $cartProductIds = Auth::user()->cart ? Auth::user()->cart->products()->pluck('product_id')->toArray() : [];
                    $response['wishlist'] = $wishlistProductIds;
                    $response['cart'] = $cartProductIds;
                }

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function updateDiscount(Request $request, $productId)
        {
            try {
                $product = Product::findOrFail($productId);

                if ($product->designer_id !== Auth::id()) {
                    return response()->json(['message' => 'Unauthorized. You do not have permission to update this product.'], 403);
                }

                $validator = Validator::make($request->all(), [
                    'discount_percentage' => 'nullable|numeric|min:0|max:100',
                    'discount_status' => 'nullable|boolean',
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                if ($request->has('discount_percentage')) {
                    $product->discount_percentage = $request->discount_percentage;
                }

                if ($request->has('discount_status')) {
                    $product->discount_status = $request->discount_status;
                }

                $product->save();

                return response()->json([
                    'message' => 'Product discount updated successfully.',
                    'product' => $product,
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function collections(Request $request)
        {
            try {

                $perPage = $request->per_page ? $request->per_page : 10;


                $collections = Collection::with('products')->paginate($perPage);




                    $response = [
                        'status' => 'success',
                        'data' => $collections,
                    ];


            if (Auth::user()) {
                $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                $response['wishlist'] = $wishlistProductIds;
            }

            return response()->json($response, 200);
            } catch (\Exception $e) {

                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function collections_new(Request $request)
        {
            try {
                $perPage = $request->per_page ? $request->per_page : 10;

                $collections = Collection::withCount('products')->paginate($perPage);

                $response = [
                    'status' => 'success',
                    'data' => $collections,
                ];

                if (Auth::user()) {
                    $wishlistProductIds = Auth::user()->wishlist ? Auth::user()->wishlist->products()->pluck('product_id')->toArray() : [];
                    $response['wishlist'] = $wishlistProductIds;
                }

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

}
