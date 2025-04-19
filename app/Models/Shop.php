<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_address',
        'shop_details',
        'shop_lat',
        'shop_long'
    ];
}
