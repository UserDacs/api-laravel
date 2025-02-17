<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'comment',
        'parent_id',
    ];


    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'service_id', 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }
    
}
