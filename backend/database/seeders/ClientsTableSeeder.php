<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Client; // Make sure to import the Clients model

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'name' => 'Chan Nich',
            'age' => 23,
            'phone_number' => '123-456-7890',
        ]);

        Client::create([
            'name' => 'Koemsran',
            'age' => 24,
            'phone_number' => '987-654-3210',
        ]);
        // Add more clients as needed
    }
}