<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '09123456789',
            'address' => 'Admin Office, BGC Manila',
            'bio' => 'Platform Administrator',
        ]);

        // Multiple Artist users
        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria.artist@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'artist',
            'phone' => '09188888888',
            'address' => 'Artist Studio, Quezon City',
            'bio' => 'Oil painter specializing in landscapes and portraits. 15+ years experience.',
        ]);

        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan.digital@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'artist',
            'phone' => '09177777777',
            'address' => 'Digital Studio, Makati',
            'bio' => 'Digital artist and 3D modeler. Award-winning digital illustrator.',
        ]);

        User::create([
            'name' => 'Sofia Reyes',
            'email' => 'sofia.photo@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'artist',
            'phone' => '09166666666',
            'address' => 'Photography Studio, Cebu',
            'bio' => 'Fine art photographer. Captures beauty in nature and urban landscapes.',
        ]);

        User::create([
            'name' => 'Marco Fernandez',
            'email' => 'marco.sculpture@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'artist',
            'phone' => '09155555555',
            'address' => 'Sculpture Workshop, Davao',
            'bio' => 'Professional sculptor working with bronze and wood. Gallery represented.',
        ]);

        // Multiple Buyer/Client users
        User::create([
            'name' => 'Client Demo User',
            'email' => 'client@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'phone' => '09144444444',
            'address' => 'BGC, Taguig',
            'bio' => 'Art collector and enthusiast with passion for contemporary art.',
        ]);

        User::create([
            'name' => 'Patricia Aguilar',
            'email' => 'patricia.buyer@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'phone' => '09133333333',
            'address' => 'Ortigas, Pasig',
            'bio' => 'Interior designer looking for original artworks for clients.',
        ]);

        User::create([
            'name' => 'Robert Chen',
            'email' => 'robert.collector@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'phone' => '09122222222',
            'address' => 'Fort Bonifacio, Taguig',
            'bio' => 'Serious art collector focusing on emerging Filipino artists.',
        ]);

        User::create([
            'name' => 'Emma Thompson',
            'email' => 'emma.art@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
            'phone' => '09111111111',
            'address' => 'Makati, Manila',
            'bio' => 'Gallery owner scouting for new artists and unique pieces.',
        ]);
    }
}
