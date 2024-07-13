<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Designer;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $product->save();
            return response()->json([
                'message' => 'Product created successfully.',
                'product' => $product,
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
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            $product->name = $request->name;
            $product->style_number = $request->style_number;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price;
            $product->sizes = $request->sizes ? json_encode($request->sizes) : null;
            $product->colors = $request->colors ? json_encode($request->colors) : null;
            $product->description = $request->description;


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
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
