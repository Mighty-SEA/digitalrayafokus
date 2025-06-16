<?php

namespace App\Chatbot;

use App\Models\ChatbotFaq;
use Illuminate\Support\Facades\Config;

class ChatbotService
{
    protected $patterns = [];
    protected $responses = [];

    public function __construct()
    {
        // Inisialisasi pola dan respons dasar
        $this->initializePatterns();
    }

    /**
     * Inisialisasi pola dan respons dasar
     */
    protected function initializePatterns()
    {
        // Pola sapaan
        $this->patterns['greetings'] = [
            '/\b(?:halo|hai|hi|hello|hey)\b/i',
            '/\bselamat\s+(?:pagi|siang|sore|malam)\b/i',
        ];
        
        $this->responses['greetings'] = [
            'Halo! Ada yang bisa saya bantu tentang layanan PT Digital Raya Fokus?',
            'Hai, selamat datang di layanan informasi digital PT Digital Raya Fokus. Ada yang bisa saya bantu?',
            'Selamat datang! Saya adalah chatbot PT Digital Raya Fokus. Silakan tanyakan informasi yang Anda butuhkan.',
        ];

        // Pola pertanyaan tentang layanan
        $this->patterns['services'] = [
            '/\b(?:layanan|jasa|produk|service)\b/i',
            '/\bapa\s+(?:saja|yang|)\s+(?:layanan|jasa|produk|ditawarkan)\b/i',
        ];
        
        $this->responses['services'] = [
            'PT Digital Raya Fokus menyediakan berbagai layanan digital seperti pengembangan aplikasi web, mobile, dan sistem informasi terintegrasi.',
            'Layanan kami meliputi konsultasi IT, pengembangan software, dan solusi digital untuk bisnis Anda.',
        ];

        // Pola pertanyaan tentang kontak
        $this->patterns['contact'] = [
            '/\b(?:kontak|hubungi|telepon|email|alamat)\b/i',
            '/\bbagaimana\s+(?:cara|untuk|)\s+(?:menghubungi|kontak)\b/i',
        ];
        
        $this->responses['contact'] = [
            'Anda dapat menghubungi PT Digital Raya Fokus melalui email: info@digitalrayafokus.com atau telepon: 021-XXXXXXXX.',
            'Silakan kunjungi kantor kami di Jl. Contoh No. 123, Jakarta atau hubungi kami di nomor 021-XXXXXXXX.',
        ];

        // Pola default jika tidak ada yang cocok
        $this->patterns['default'] = ['/./'];
        $this->responses['default'] = [
            'Maaf, saya belum memahami pertanyaan Anda. Bisa disampaikan dengan cara lain?',
            'Saya masih belajar untuk memahami pertanyaan Anda. Coba tanyakan dengan cara berbeda.',
            'Mohon maaf, saya tidak mengerti pertanyaan Anda. Silakan hubungi customer service kami untuk bantuan lebih lanjut.',
        ];
    }

    /**
     * Memproses input pengguna dan memberikan respons
     */
    public function processInput(string $input)
    {
        // Coba cari jawaban dari database FAQ
        $faq = ChatbotFaq::findMatchingFaq($input);
        
        if ($faq) {
            return $faq->answer;
        }
        
        // Jika tidak ada di FAQ, gunakan logika sederhana
        $input = strtolower($input);
        
        if (str_contains($input, 'halo') || str_contains($input, 'hai') || str_contains($input, 'hi')) {
            return 'Halo! Ada yang bisa saya bantu terkait layanan PT Digital Raya Fokus?';
        }
        
        if (str_contains($input, 'terima kasih') || str_contains($input, 'makasih')) {
            return 'Sama-sama! Senang bisa membantu Anda.';
        }
        
        if (str_contains($input, 'layanan') || str_contains($input, 'jasa')) {
            return 'PT Digital Raya Fokus menyediakan berbagai layanan IT seperti pengembangan software, konsultasi teknologi, dan infrastruktur IT. Layanan apa yang ingin Anda ketahui lebih lanjut?';
        }
        
        if (str_contains($input, 'harga') || str_contains($input, 'biaya') || str_contains($input, 'tarif')) {
            return 'Untuk informasi harga layanan kami, silakan hubungi tim sales kami di +62 812-3456-7890 atau kirim email ke info@digitalrayafokus.com';
        }
        
        if (str_contains($input, 'kontak') || str_contains($input, 'hubungi') || str_contains($input, 'telepon') || str_contains($input, 'email')) {
            return 'Anda dapat menghubungi kami melalui telepon +62 812-3456-7890 atau email ke info@digitalrayafokus.com';
        }
        
        if (str_contains($input, 'alamat') || str_contains($input, 'lokasi') || str_contains($input, 'kantor')) {
            return 'Kantor kami berlokasi di Jl. Kapten Sarwono No.32, Banjaran Wetan, Kec. Banjaran';
        }
        
        // Respons default jika tidak ada yang cocok
        return 'Terima kasih atas pertanyaan Anda. Untuk informasi lebih lanjut, silakan hubungi kami melalui telepon atau email.';
    }

    /**
     * Tambahkan pola dan respons baru
     * 
     * @param string $type
     * @param array $patterns
     * @param array $responses
     * @return void
     */
    public function addPatternResponses($type, array $patterns, array $responses)
    {
        if (!isset($this->patterns[$type])) {
            $this->patterns[$type] = [];
            $this->responses[$type] = [];
        }
        
        $this->patterns[$type] = array_merge($this->patterns[$type], $patterns);
        $this->responses[$type] = array_merge($this->responses[$type], $responses);
    }
} 