<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InvoicesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan lokalisasi Indonesia
        
        // Buat 10 customer terlebih dahulu
        for ($i = 1; $i <= 10; $i++) {
            DB::table('customers')->insert([
                'nama' => $faker->company(),
                'email' => $faker->companyEmail(),
                'phone' => $faker->phoneNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Buat 20 invoice
        for ($i = 1; $i <= 20; $i++) {
            $invoiceDate = $faker->dateTimeBetween('-3 months', 'now');
            $dueDate = clone $invoiceDate;
            $dueDate->modify('+7 days');
            
            $isDollar = $faker->boolean(30); // 30% kemungkinan menggunakan USD
            $currentDollar = $isDollar ? $faker->numberBetween(15000, 16000) : null;

            $invoiceId = DB::table('invoices')->insertGetId([
                'customer_id' => $faker->numberBetween(1, 10),
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'email_reciver' => $faker->email(),
                'current_dollar' => $currentDollar,
                'status' => $faker->randomElement(['pending', 'paid', 'cancelled']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Buat 1-5 item untuk setiap invoice
            $numItems = $faker->numberBetween(1, 5);
            for ($j = 1; $j <= $numItems; $j++) {
                $quantity = $faker->numberBetween(1, 10);
                $isDollarItem = $isDollar && $faker->boolean(80); // 80% kemungkinan menggunakan USD jika invoice USD
                
                $priceRupiah = $faker->numberBetween(100000, 5000000);
                $priceDollar = $isDollarItem ? round($priceRupiah / $currentDollar, 2) : null;
                
                DB::table('items')->insert([
                    'invoice_id' => $invoiceId,
                    'name' => $faker->words(3, true),
                    'description' => $faker->sentence(),
                    'is_dollar' => $isDollarItem,
                    'quantity' => $quantity,
                    'price_rupiah' => $priceRupiah,
                    'price_dollar' => $priceDollar,
                    'amount_rupiah' => $priceRupiah * $quantity,
                    'amount_dollar' => $priceDollar ? $priceDollar * $quantity : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
