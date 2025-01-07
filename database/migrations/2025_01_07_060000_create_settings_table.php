<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        $settings = [
            'company_name' => 'Pt.Digital Raya Fokus',
            'company_email' => 'idigitalrayafokus@gmail.com',
            'company_phone' => '+62 896-9605-9684',
            'company_address' => 'Kapten Sarwono No.32, Banjaran Wetan, Kec. Banjaran, Kabupaten Bandung, Jawa Barat 40377 Indonesia',
            'company_logo' => 'https://febri.minty.my.id/asset/logo.png',
            'current_dollar' => '15000',
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
