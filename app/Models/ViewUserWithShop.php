<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewUserWithShop extends Model
{
    use HasFactory;

    protected $table = 'view_users_with_shops';
    public $timestamps = false;
}
