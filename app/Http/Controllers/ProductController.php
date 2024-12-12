<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct(Request $request){
        if(isset($request->id)){ 
            $data = Product::whereId($request->id)->first(); 
        }else{ 
            $data = Product::get(); 
        }
        
        return response()->json([
            'message' => 'Products listed',
            'products' => [
                $data
            ],
        ], 200);
    }

    // Admin Only
    public function createProduct(Request $request){
        $productInfo = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        try {
            $product = new Product();
            $product->name = $productInfo['name'];
            $product->price = $productInfo['price'];
            $product->stock = $productInfo['stock'];
            $product->save();

            return response()->json([
                'message' => 'Product successfully created',
                'Product' => [
                    $product
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    // Admin Only
    public function updateProduct(Request $request){
        $productInfo = $request->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
        ]);
        try {
            $product = Product::whereId($request->id)->first();
            if($product){
                foreach ($productInfo as $key => $value) {
                    $product->$key = $value; 
                }
                $product->save();
                return response()->json([
                    'message' => 'Product successfully updated',
                    'Product' => [
                        $product
                    ],
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Product not found',
                    'product_id' => $request->id,
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
    
    // Admin Only
    public function deleteProduct(Request $request, $id){
        $productId = $request->validate([
            'id' => 'numeric'
        ]);
        try {
            $product = Product::whereId($request->id)->first();
            if($product){
                $product->delete(); 
                return response()->json([
                    'message' => 'Product successfully delete',
                    'Product' => [
                        $product
                    ],
                ], 201);
            }else{
                return response()->json([
                    'message' => 'Product not found',
                    'product_id' => $request->id,
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
}
