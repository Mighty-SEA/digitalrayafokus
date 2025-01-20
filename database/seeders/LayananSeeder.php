<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run()
    {
        $layanans = [
            [
                'title' => 'Konsultasi Teknologi',
                'slug' => 'konsultasi',
                'icon' => 'fa-regular fa-handshake',
                'description' => 'Layanan konsultasi teknologi kami membantu bisnis Anda mengoptimalkan penggunaan teknologi informasi.',
                'features' => [
                    'Analisis Kebutuhan IT',
                    'Perencanaan Strategis IT',
                    'Audit Sistem & Infrastruktur',
                    'Optimasi Proses Bisnis',
                    'Konsultasi Keamanan IT',
                    'Transformasi Digital'
                ],
                'benefits' => [
                    'Solusi yang tepat sesuai kebutuhan',
                    'Efisiensi biaya IT',
                    'Peningkatan produktivitas',
                    'Keamanan sistem terjamin'
                ],
                'is_active' => true,
                'order' => 1
            ],
            [
                'title' => 'Software Development',
                'slug' => 'software',
                'icon' => 'fa-solid fa-code',
                'description' => 'Kami mengembangkan aplikasi sesuai kebutuhan untuk mendukung bisnis Anda.',
                'features' => [
                    'Pengembangan Aplikasi Web',
                    'Pengembangan Aplikasi Mobile',
                    'Sistem Informasi Manajemen',
                    'Integrasi Sistem',
                    'Pemeliharaan & Support',
                    'UI/UX Design'
                ],
                'benefits' => [
                    'Aplikasi sesuai kebutuhan',
                    'Teknologi modern & scalable',
                    'Dukungan teknis berkelanjutan',
                    'Interface yang user-friendly'
                ],
                'is_active' => true,
                'order' => 2
            ],
            [
                'title' => 'Infrastruktur Teknologi',
                'slug' => 'infrastruktur',
                'icon' => 'fa-solid fa-network-wired',
                'description' => 'Solusi infrastruktur IT yang handal, aman, dan scalable untuk mendukung operasional bisnis Anda.',
                'features' => [
                    'Jaringan & Server',
                    'Cloud Computing',
                    'Backup & Recovery',
                    'Keamanan IT',
                    'Virtualisasi',
                    'Monitoring Sistem'
                ],
                'benefits' => [
                    'Infrastruktur yang handal',
                    'Keamanan data terjamin',
                    'Sistem yang scalable',
                    'Dukungan 24/7'
                ],
                'is_active' => true,
                'order' => 3
            ],
            [
                'title' => 'Layanan Manajemen TI',
                'slug' => 'manajemen',
                'icon' => 'fa-solid fa-list-check',
                'description' => 'Serahkan pengelolaan IT kepada kami dan fokus pada bisnis Anda.',
                'features' => [
                    'IT Help Desk',
                    'Pemeliharaan Sistem',
                    'Manajemen Aset IT',
                    'Update & Patch Management',
                    'Monitoring & Reporting',
                    'Disaster Recovery'
                ],
                'benefits' => [
                    'Operasional IT yang efisien',
                    'Respon cepat untuk masalah IT',
                    'Penghematan biaya operasional',
                    'Jaminan ketersediaan sistem'
                ],
                'is_active' => true,
                'order' => 4
            ],
            [
                'title' => 'Pelatihan dan Sertifikasi',
                'slug' => 'pelatihan',
                'icon' => 'fa-solid fa-graduation-cap',
                'description' => 'Program pelatihan dan sertifikasi untuk meningkatkan kompetensi tim IT Anda.',
                'features' => [
                    'Pelatihan Technical Skill',
                    'Workshop IT Management',
                    'Sertifikasi Profesional',
                    'Training Development',
                    'Security Awareness',
                    'Digital Transformation'
                ],
                'benefits' => [
                    'Peningkatan kompetensi tim',
                    'Sertifikasi internasional',
                    'Materi up-to-date',
                    'Instruktur berpengalaman'
                ],
                'is_active' => true,
                'order' => 5
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
} 