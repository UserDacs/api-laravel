<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'booking_date',
        'booking_details',
        'booking_location',
        'payment_method',
        'total_price',
        'service_id',
        'user_id',
        'owner_id'
    ];


     // Relations
    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function cancel() {
        return $this->hasOne(Cancel::class);
    }
}
