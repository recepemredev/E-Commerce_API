<?php

namespace App\Traits;
use App\Models\Product;

trait ProductStockCheck
{
    // Check product stock
    public function checkProductStock($productId, $quantity){
        $product = Product::whereId($productId)->first();
        if($product->stock >= $quantity){
            return true;
        }else{
            return false;
        }
    }
}
