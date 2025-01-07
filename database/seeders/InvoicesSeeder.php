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
        
        // Create 50 invoices
        for ($i = 1; $i <= 50; $i++) {
            $invoiceId = DB::table('invoices')->insertGetId([
                'customer_id' => $faker->numberBetween(1, 100),
                'invoice_date' => $faker->date(),
                'due_date' => $faker->optional()->date(),
                'email_reciver' => $faker->safeEmail(),
                'is_dollar' => $faker->boolean(),
                'current_dollar' => $faker->optional()->randomNumber(2),
                'status' => $faker->randomElement(['pending', 'paid', 'cancelled']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create 1-5 items for each invoice
            $numItems = $faker->numberBetween(1, 5);
            for ($j = 1; $j <= $numItems; $j++) {
                $quantity = $faker->numberBetween(1, 100);
                $priceRupiah = $faker->numberBetween(10000, 1000000);
                $priceDollar = $faker->numberBetween(10, 1000);
                
                DB::table('items')->insert([
                    'invoice_id' => $invoiceId,
                    'name' => $faker->word(),
                    'description' => $faker->sentence(),
                    'quantity' => $quantity,
                    'price_rupiah' => $priceRupiah,
                    'price_dollar' => $priceDollar,
                    'amount_rupiah' => $priceRupiah * $quantity,
                    'amount_dollar' => $priceDollar * $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
