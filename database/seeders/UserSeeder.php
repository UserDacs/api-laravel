<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // Never store plain passwords
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '1234567890',
            'address_street' => '123 Main St',
            'address_city' => 'New York',
            'address_state' => 'NY',
            'address_zip_code' => '10001',
            'image_path' => null,
            'mobile_auth' => 'authenticated',
            'user_type' => 'provider',
        ]);
    }
}
