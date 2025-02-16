<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
      
        $products = Product::all();
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        } 
        return ProductResource::collection($products); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | min:3 |  string',
            'description' => 'required | max:255 | min:3 |  string',
            'price' => 'required ',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $product = Product::create($request->all());
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }


    public function show($id)
    {
        $product = Product::find($id);
        if  (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return Response()->json([
            'message' => 'Product retrieved successfully',
            'product' => $product
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | min:3 |  string',
            'description' => 'required | max:255 | min:3 |  string',
            'price' => 'required ',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $product = Product::find($id);
        if  (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update($request->all());
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if  (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
