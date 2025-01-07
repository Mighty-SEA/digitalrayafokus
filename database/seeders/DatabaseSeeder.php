<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'Hibban Habiburrahman',
                'email' => 'hibban@mail.com',
                'password' => Hash::make('12345678'), // Hash password
            ]);

            User::factory()->create(
                [
                    'name' => 'Demo User',
                    'email' => 'Demo@demo.com',
                    'password' => Hash::make('demo'), // Hash password
                ]);

        // Run the Customer and Invoices seeders
        $this->call([
            CustomerSeeder::class,
            InvoicesSeeder::class,
        ]);
    }
}
