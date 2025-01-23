<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'PT. Digital Raya Fokus',
            'company_description' => 'PT Digital Raya Fokus adalah perusahaan teknologi informasi yang berfokus pada penyediaan solusi digital komprehensif untuk mendukung transformasi bisnis.',
            'company_profile' => 'PT Digital Raya Fokus adalah perusahaan teknologi informasi yang berfokus pada penyediaan solusi digital komprehensif untuk mendukung transformasi bisnis. Kami berkomitmen untuk memberikan layanan berkualitas tinggi dan solusi inovatif yang membantu klien kami mencapai keunggulan kompetitif di era digital.',
            'company_visi' => 'Menjadi pionir dalam menyediakan solusi teknologi yang inovatif dan memberikan kontribusi positif dalam mengubah lanskap bisnis melalui teknologi informasi.',
            'company_misi' => 'Memberikan solusi teknologi yang terkini dan inovatif untuk mendukung kebutuhan bisnis pelanggan.
            Menjadi mitra yang dapat diandalkan dan memberikan layanan berkualitas tinggi.
            Terus melakukan inovasi dan peningkatan dalam menyediakan solusi teknologi.
            Membangun hubungan yang saling menguntungkan dengan pelanggan dan mitra.',
            'company_address' => 'Kapten Sarwono No.32 Banjaran Wetan, Kabupaten Bandung',
            'company_email' => 'digitalrayafokus@gmail.com',
            'company_phone' => '(021) 1234-5678',
            'company_tagline' => 'Transformasi Digital untuk Masa Depan',
            'company_keywords' => 'teknologi informasi, solusi digital, transformasi bisnis, IT solution, digital transformation',
            'tc1' => 'Transformasi Digital untuk Masa Depan',
            'dc1' => 'Solusi teknologi inovatif untuk mengakselerasi pertumbuhan bisnis Anda',
            'tc2' => 'Solusi Digital Terpercaya',
            'dc2' => 'Memberikan layanan teknologi informasi terbaik untuk mendukung kesuksesan bisnis Anda',
            'pt1' => 'Beranda',
            'pt2' => 'Profil',
            'pt3' => 'Portofolio',
            'pt4' => 'Layanan',
            'pt5' => 'Contact',
            'payment_bank' => 'BRI',
            'payment_account' => '398329283298',
            'payment_name' => 'Wahyu',
        ];

        foreach ($settings as $key => $value) {
            Settings::set($key, $value);
        }
    }
} 