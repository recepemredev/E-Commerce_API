<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItems;
use Illuminate\Http\Request;
use App\Traits\ProductStockCheck;

class OrderController extends Controller
{
    use ProductStockCheck;

    public function getOrder(Request $request){
        try {
            if(isset($request->id)){ 
                $data = Order::whereId($request->id)->where('user_id',auth('api')->id())->first(); 
            }else{ 
                $data = Order::where('user_id',auth('api')->id())->get();
            }
            if($data){
                return response()->json([
                    'message' => "Your orders",
                    'Order details' => $data,
                ], 201);
            }else{
                return response()->json([
                    'message' => "Your order not found",
                ], 404);
            }
        }catch (\Execption $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
        
    }

    public function createOrder(Request $request){
        $cartId = $request->validate([
            'cart_id' => 'required|min:1',
        ]);
        try {
            $cartItem = CartItems::whereId($cartId["cart_id"])->first();
            if($cartItem){
                $product = $cartItem->product;
                $checkStock =  $this->checkProductStock($product->id, $cartItem->quantity);
                if($checkStock){
                    $product->stock -= $cartItem->quantity;
                    $order = new Order();
                    $order->user_id = auth('api')->id();
                    $order->total_amount = $cartItem->price;
                    $order->status = "Pending";
                    $cartItem->delete();
                    $order->save();
                    $product->save();
                    return response()->json([
                        'message' => "Your order successfully created",
                        'Order details' => $order,
                    ], 201);
                }else{
                    return response()->json([
                        'message' => "The product in your cart is out of stock",
                        'Cart details' => $cartItem,
                    ], 409);
                }
            }else{
                return response()->json([
                    'message' => 'No item found your cart',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }
}
