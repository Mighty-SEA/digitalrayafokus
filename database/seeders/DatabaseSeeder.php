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
        // User::factory(10)->create();

        // Hapus factory dan buat user admin secara langsung
        User::create([
            'name' => 'Admin',
            'email' => 'admin@digrafo.com',
            'password' => Hash::make('password123'), // Gunakan Hash::make untuk konsistensi
            'is_admin' => true,
        ]);

        // Tambahan user lain jika diperlukan
        User::create([
            'name' => 'Hibban Habiburrahman',
            'email' => 'hibban@mail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Demo User',
            'email' => 'demo@demo.com',
            'password' => Hash::make('demo'),
            'is_admin' => true,
        ]);

        // Run the Customer and Invoices seeders
        // $this->call([
        //     CustomerSeeder::class,
        //     InvoicesSeeder::class,
        // ]);
    }
}
