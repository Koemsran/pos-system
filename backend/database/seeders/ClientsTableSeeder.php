<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Client; // Make sure to import the Clients model

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'name' => 'John Doe',
            'age' => 30,
            'phone_number' => '123-456-7890',
        ]);

        Client::create([
            'name' => 'Jane Smith',
            'age' => 25,
            'phone_number' => '987-654-3210',
        ]);
        // Add more clients as needed
    }
}