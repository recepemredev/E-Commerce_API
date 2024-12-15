<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',      
        'total_amount', 
        'status',       
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
