<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('invoices')->insert([
                'customer_id' => $faker->numberBetween(1, 100), // Sesuaikan dengan range id customer
                'invoice_date' => $faker->date(),
                'due_date' => $faker->optional()->date(),
                'email_reciver' => $faker->safeEmail(),
                'is_dollar' => $faker->boolean(),
                'current_dollar' => $faker->optional()->randomNumber(2), // Nilai random dolar jika is_dollar true
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };

        foreach (range(1, 150) as $index) {
            DB::table('items')->insert([
                'invoice_id' => $faker->numberBetween(1, 50), // Sesuaikan dengan range id invoice
                'name' => $faker->word(),
                'description' => $faker->sentence(),
                'quantity' => $faker->numberBetween(1, 100),
                'price_rupiah' => $faker->numberBetween(10000, 1000000),
                'price_dollar' => $faker->optional()->numberBetween(10, 1000),
                'amount_rupiah' => $faker->numberBetween(10000, 1000000),
                'amount_dollar' => $faker->optional()->numberBetween(10, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        

    }
}
