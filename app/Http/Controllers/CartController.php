<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ProductStockCheck;

class CartController extends Controller
{
    use ProductStockCheck;

    public function getCart(){
        try {
            $user = auth('api')->id();
            $cart = Cart::where('user_id', $user)->first();
            if ($cart){
                $cartItems = CartItems::where('cart_id',$cart->id)->get();
                $totalAmount = $cartItems->sum('price');
                $totalProduct = $cartItems->sum('quantity');
                return response()->json([
                    'message' => 'Cart products',
                    'Total Number Product' => $totalProduct,
                    'Total Amount' => $totalAmount,
                    'Cards of Product' => $cartItems,
                ], 200);
            }else{
                return response()->json([
                    'message' => 'No products found your cart',
                ], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function createCart(Request $request){
        $productInfo = $request->validate([
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1'
        ]);
        $outOfStockProducts = [];
        $addedProducts = [];
        try {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth('api')->id()],
            );
            foreach ($productInfo['products'] as $product) {
                $checkStock =  $this->checkProductStock($product['product_id'],$product['quantity']);
                $cartItem = CartItems::where('cart_id', $cart->id)
                                    ->where('product_id', $product['product_id'])
                                    ->first();
                if($checkStock){
                    $productPrice = Product::find($product['product_id'])->price;
                    if ($cartItem){
                        $cartItem->quantity += $product['quantity'];
                        $cartItem->price +=  $productPrice * $product['quantity'];
                        $cartItem->save();
                    }else {
                        // First product price save
                        if($product['quantity'] > 1) {
                            $productPrice *= $product['quantity'];
                        }
                        $cartItem = new CartItems();
                        $cartItem->cart_id = $cart->id;
                        $cartItem->product_id = $product['product_id'];
                        $cartItem->quantity = $product['quantity'];
                        $cartItem->price = $productPrice;
                        $cartItem->save();
                    }
                    $addedProducts[] = [
                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity']
                    ];
                }else{
                    $outOfStockProducts[] = [
                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity']
                    ];
                }
            }
            return response()->json([
                'message' => 'Product add status',
                'Added Products Id' => $addedProducts,
                'Out of Stock Products Id' => $outOfStockProducts
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function updateCart(Request $request){
        $productQuantity = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cartItemId = $request->id;
        $outOfStockProducts = [];
        $addedProducts = [];
        try {
            $cart = Cart::where('user_id',auth('api')->id())->first();
            $cartItem = CartItems::where('id', $cartItemId)->where('cart_id',$cart->id)->first();
            if($cartItem){
                $checkStock =  $this->checkProductStock($cartItem->product_id,$productQuantity['quantity']);
                if($checkStock){
                    $productPrice = Product::find($cartItem->product_id)->price;
                    $cartItem->quantity = $productQuantity['quantity'];
                    $cartItem->price =  $productPrice * $productQuantity['quantity'];
                    $cartItem->save();
                    $addedProducts[] = [
                        'product_id' => $cartItem->product_id,
                        'quantity' => $productQuantity['quantity']
                    ];
                }else{
                    $outOfStockProducts[] = [
                        'product_id' => $cartItem->product_id,
                        'quantity' => $productQuantity['quantity']
                    ];
                }
                return response()->json([
                    'message' => 'Product update status',
                    'Updated Products Id' => $addedProducts,
                    'Out of Stock Products Id' => $outOfStockProducts
                ], 201);
            }else{
                return response()->json([
                    'message' => 'No products found your cart',
                ], 404);
            }  
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function deleteCart(Request $request){
        $cartId = $request->validate([
            'id' => 'numeric'
        ]);
        try {
            $user = auth('api')->id();
            $cart = Cart::where('user_id', $user)->first();
            $cartItems = CartItems::whereId($request->id)->where('cart_id',$cart->id)->first();
            if ($cart && $cartItems){
                $deleteProduct = Product::whereId($cartItems->product_id)->first();
                $cartItems->delete();
                return response()->json([
                    'message' => 'Product successfully delete on cart',
                    'Deleted Cart Product' => [
                        $cartItems
                    ],
                ], 201);
            }else{
                return response()->json([
                    'message' => 'No products found your cart',
                ], 404);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
}
