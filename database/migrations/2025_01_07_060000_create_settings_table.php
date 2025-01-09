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
            'company_logo' => 'asset/logo.png',
            'current_dollar' => '15000',
            'company_moto' => 'Menjadi pionir dalam menyediakan solusi teknologi yang inovatif dan memberikan kontribusi positif dalam mengubah lanskap bisnis melalui teknologi informasi.',
            'company_vision' => '1. Memberikan solusi teknologi yang terkini dan inovatif untuk mendukung kebutuhan bisnis pelanggan.
2. Menjadi mitra yang dapat diandalkan dan memberikan layanan berkualitas tinggi serta dukungan teknis yang handal.
3. Terus melakukan inovasi dan peningkatan dalam menyediakan solusi teknologi yang relevan dengan perkembangan industri.
4. Membangun hubungan yang saling menguntungkan dengan pelanggan, mitra, dan pihak terkait lainnya.',
            'company_description' => 'Pt.Digital Raya Fokus is a company dedicated to providing innovative digital solutions to businesses across Indonesia.',
            'company_social_media' => json_encode([
                'facebook' => 'https://facebook.com/digitalrayafokus',
                'twitter' => 'https://twitter.com/digitalrayafokus',
                'instagram' => 'https://instagram.com/digitalrayafokus',
            ]),

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
