<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                    return response()->json(
                        [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ]
               , 422);
                }

            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            if ($request->hasFile('image')) {

                if ($category->image) {
                    Storage::delete(str_replace('/storage', 'public', $category->image));
                }

                $ProfileName = "FEE";
                $imageFile = $request->file('image');
                $imageUniqueName = uniqid();
                $imageExtension = $imageFile->getClientOriginalExtension();
                $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
                $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
                $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

                $category->image = $imageUrl;
            }

            $category->save();

            return response()->json([
                'message' => 'Category created successfully.',
                'category' => $category,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function index_new(Request $request)
    {
        try {

            $perPage = $request->per_page ? $request->per_page : 10;


            $categories = Category::with(['subcategories'])->paginate($perPage);



            $response = [
                'status' => 'success',
                'data' => $categories,
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


            $categories = Category::with(['subcategories'])->paginate($perPage);



            $response = [
                'status' => 'success',
                'data' => $categories,
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

    public function createSubcategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:subcategories,name',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                'status' => 'error',
                'message' => $validator->errors(),
            ]
           , 422);
            }

            $subcategory = Subcategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            if ($request->hasFile('image')) {

                if ($subcategory->image) {
                    Storage::delete(str_replace('/storage', 'public', $subcategory->image));
                }

                $ProfileName = "FEE";
                $imageFile = $request->file('image');
                $imageUniqueName = uniqid();
                $imageExtension = $imageFile->getClientOriginalExtension();
                $imageFilename = $ProfileName . Carbon::now()->format('Ymd') . '_' . $imageUniqueName . '.' . $imageExtension;
                $imagePath = $imageFile->storeAs('public/upload/files/image/', $imageFilename);
                $imageUrl = Storage::url('upload/files/image/' . $imageFilename);

                $subcategory->image = $imageUrl;
            }

            $subcategory->save();

            return response()->json([
                'message' => 'Subcategory created successfully.',
                'subcategory' => $subcategory,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getSubcategories($categoryId)
    {
        try {
            $subcategories = Subcategory::where('category_id', $categoryId)->with('category.products.images')->get();
            return response()->json([
                'status' => 'success',
                'data' => $subcategories,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
