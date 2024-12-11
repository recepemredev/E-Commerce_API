<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logs extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'user_id',
        'request',
        'request_type',
        'request_time',
        'response',
        'response_status',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
