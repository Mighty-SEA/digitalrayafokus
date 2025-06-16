<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotFaq;

class ChatbotFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa saja layanan yang ditawarkan oleh PT Digital Raya Fokus?',
                'answer' => 'PT Digital Raya Fokus menawarkan berbagai layanan IT meliputi pengembangan aplikasi web, aplikasi mobile, sistem informasi terintegrasi, konsultasi IT, dan infrastruktur teknologi.',
                'keywords' => 'layanan,jasa,produk,ditawarkan,apa saja',
                'category' => 'layanan',
                'priority' => 10,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa biaya untuk pengembangan website?',
                'answer' => 'Biaya pengembangan website bervariasi tergantung kompleksitas proyek, fitur yang dibutuhkan, dan skala aplikasi. Silakan hubungi tim sales kami untuk mendapatkan penawaran yang sesuai dengan kebutuhan Anda.',
                'keywords' => 'biaya,harga,tarif,website,web',
                'category' => 'harga',
                'priority' => 8,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara menghubungi PT Digital Raya Fokus?',
                'answer' => 'Anda dapat menghubungi kami melalui telepon di +62 812-3456-7890, email ke info@digitalrayafokus.com, atau mengunjungi kantor kami di Jl. Kapten Sarwono No.32, Banjaran Wetan, Kec. Banjaran.',
                'keywords' => 'kontak,hubungi,telepon,email,alamat',
                'category' => 'kontak',
                'priority' => 9,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa lama waktu pengembangan aplikasi?',
                'answer' => 'Waktu pengembangan aplikasi bervariasi tergantung kompleksitas proyek. Untuk website sederhana dapat selesai dalam 2-4 minggu, sedangkan aplikasi yang lebih kompleks membutuhkan waktu 2-6 bulan. Kami akan memberikan estimasi yang lebih akurat setelah diskusi kebutuhan.',
                'keywords' => 'waktu,durasi,lama,pengembangan',
                'category' => 'teknis',
                'priority' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Apa teknologi yang digunakan untuk pengembangan?',
                'answer' => 'Kami menggunakan berbagai teknologi modern seperti Laravel, React, Vue.js, Flutter, Python, dan teknologi cloud seperti AWS dan Google Cloud Platform. Pemilihan teknologi disesuaikan dengan kebutuhan spesifik proyek Anda.',
                'keywords' => 'teknologi,stack,framework,bahasa,programming',
                'category' => 'teknis',
                'priority' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah PT Digital Raya Fokus menyediakan layanan pemeliharaan?',
                'answer' => 'Ya, kami menyediakan layanan pemeliharaan dan dukungan berkelanjutan untuk semua aplikasi yang kami kembangkan. Kami menawarkan paket pemeliharaan bulanan atau tahunan sesuai kebutuhan Anda.',
                'keywords' => 'pemeliharaan,maintenance,support,dukungan',
                'category' => 'layanan',
                'priority' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Dimana lokasi kantor PT Digital Raya Fokus?',
                'answer' => 'Kantor kami berlokasi di Jl. Kapten Sarwono No.32, Banjaran Wetan, Kec. Banjaran, Kabupaten Bandung, Jawa Barat 40377.',
                'keywords' => 'lokasi,alamat,kantor,dimana',
                'category' => 'kontak',
                'priority' => 8,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah PT Digital Raya Fokus menerima magang atau internship?',
                'answer' => 'Ya, kami menerima program magang untuk mahasiswa dan fresh graduate di berbagai bidang seperti pengembangan web, mobile, UI/UX, dan digital marketing. Silakan kirim CV Anda ke karir@digitalrayafokus.com.',
                'keywords' => 'magang,internship,kerja,karir,pekerjaan',
                'category' => 'umum',
                'priority' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada portofolio proyek yang sudah dikerjakan?',
                'answer' => 'Ya, Anda dapat melihat portofolio proyek kami di halaman Portofolio pada website ini. Kami telah mengerjakan berbagai proyek untuk klien dari berbagai industri seperti pendidikan, kesehatan, e-commerce, dan lainnya.',
                'keywords' => 'portofolio,proyek,contoh,karya,portfolio',
                'category' => 'umum',
                'priority' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah PT Digital Raya Fokus menyediakan layanan SEO?',
                'answer' => 'Ya, kami menyediakan layanan SEO dan digital marketing untuk membantu bisnis Anda meningkatkan visibilitas online dan mendapatkan lebih banyak pelanggan potensial.',
                'keywords' => 'seo,marketing,digital,promosi,pemasaran',
                'category' => 'layanan',
                'priority' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            ChatbotFaq::create($faq);
        }
    }
} 