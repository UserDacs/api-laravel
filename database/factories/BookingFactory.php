<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition() {
        return [
            'tracking_number' => strtoupper($this->faker->unique()->bothify('TRK-####-####')),
            'booking_date' => $this->faker->date(),
            'booking_details' => $this->faker->sentence(),
            'booking_location' => $this->faker->city(),
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'online']),
            'total_price' => $this->faker->randomFloat(2, 50, 500),
            'service_id' => Service::factory(),
            'user_id' => User::factory(),
            'owner_id' => User::factory(),
        ];
    }
}