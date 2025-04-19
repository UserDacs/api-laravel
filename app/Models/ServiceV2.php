<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceV2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'technician_id',
        'category_id',
        'service_name',
        'price',
        'description',
        'status',
        'image_path',
    ];

}
