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
        
        // Jika tidak ada di FAQ, gunakan logika pattern matching
        $input = strtolower($input);
        
        // Array pola dan respon
        $patterns = [
            // Pola sapaan
            'greetings' => [
                '/\b(?:halo|hai|hi|hello|hey)\b/i',
                '/\bselamat\s+(?:pagi|siang|sore|malam)\b/i',
                '/\bpermisi\b/i',
            ],
            
            // Pola ucapan terima kasih
            'thanks' => [
                '/\b(?:terima\s*kasih|makasih|thanks|thank\s*you)\b/i',
            ],
            
            // Pola pertanyaan tentang layanan
            'services' => [
                '/\b(?:layanan|jasa|produk|service)\b/i',
                '/\bapa\s+(?:saja|yang|)\s+(?:layanan|jasa|produk|ditawarkan)\b/i',
            ],
            
            // Pola pertanyaan tentang harga
            'price' => [
                '/\b(?:harga|biaya|tarif|budget|anggaran)\b/i',
                '/\bberapa\s+(?:harga|biaya|tarif)\b/i',
            ],
            
            // Pola pertanyaan tentang kontak
            'contact' => [
                '/\b(?:kontak|hubungi|telepon|email|whatsapp|wa)\b/i',
                '/\bbagaimana\s+(?:cara|untuk|)\s+(?:menghubungi|kontak)\b/i',
            ],
            
            // Pola pertanyaan tentang alamat
            'address' => [
                '/\b(?:alamat|lokasi|kantor|dimana)\b/i',
            ],
            
            // Pola pertanyaan tentang waktu pengerjaan
            'timeline' => [
                '/\b(?:lama|waktu|durasi|timeline)\s+(?:pengerjaan|kerja|project|proyek)\b/i',
                '/\bberapa\s+(?:lama|waktu)\b/i',
            ],
            
            // Pola pertanyaan tentang portofolio
            'portfolio' => [
                '/\b(?:portofolio|portfolio|contoh|hasil|kerja|klien|client)\b/i',
                '/\bsiapa\s+(?:saja|)\s+(?:klien|client)\b/i',
            ],
        ];
        
        $responses = [
            'greetings' => [
                'Halo! Ada yang bisa saya bantu terkait layanan PT Digital Raya Fokus?',
                'Hai, selamat datang di layanan informasi digital PT Digital Raya Fokus. Ada yang bisa saya bantu?',
                'Selamat datang! Saya adalah chatbot PT Digital Raya Fokus. Silakan tanyakan informasi yang Anda butuhkan.',
            ],
            'thanks' => [
                'Sama-sama! Senang bisa membantu Anda.',
                'Terima kasih kembali. Jangan ragu untuk bertanya lagi jika ada yang bisa kami bantu.',
            ],
            'services' => [
                'PT Digital Raya Fokus menyediakan berbagai layanan digital seperti pengembangan aplikasi web, mobile, dan sistem informasi terintegrasi.',
                'Layanan kami meliputi konsultasi IT, pengembangan software, dan solusi digital untuk bisnis Anda.',
                'PT Digital Raya Fokus menyediakan beberapa layanan utama, di antaranya: 1) Pengembangan aplikasi web dan mobile, 2) Konsultasi IT dan solusi bisnis, 3) Sistem informasi terintegrasi, 4) Digital marketing. Layanan mana yang ingin Anda ketahui lebih lanjut?',
            ],
            'price' => [
                'Harga layanan kami bervariasi tergantung kebutuhan dan kompleksitas proyek. Silakan hubungi tim sales kami untuk mendapatkan penawaran.',
                'Untuk informasi harga, silakan kirimkan detail kebutuhan Anda ke email sales@digitalrayafokus.com untuk mendapatkan penawaran terbaik.',
            ],
            'contact' => [
                'Anda dapat menghubungi PT Digital Raya Fokus melalui email: info@digitalrayafokus.com atau telepon: +62 812-3456-7890.',
                'Silakan hubungi kami melalui telepon +62 812-3456-7890 atau email ke info@digitalrayafokus.com',
            ],
            'address' => [
                'Kantor PT Digital Raya Fokus berlokasi di Jl. Kapten Sarwono No.32, Banjaran Wetan, Kec. Banjaran.',
                'Anda dapat mengunjungi kantor kami di Jl. Kapten Sarwono No.32, Banjaran Wetan, Kec. Banjaran.',
            ],
            'timeline' => [
                'Waktu pengerjaan proyek tergantung pada kompleksitas dan ruang lingkup. Proyek sederhana bisa selesai dalam 2-4 minggu, sedangkan proyek besar bisa memakan waktu beberapa bulan.',
                'Kami akan memberikan estimasi waktu pengerjaan setelah melakukan analisis kebutuhan. Silakan hubungi tim kami untuk konsultasi lebih lanjut.',
            ],
            'portfolio' => [
                'Kami telah bekerja sama dengan berbagai perusahaan dari berbagai industri. Anda dapat melihat portofolio kami di website resmi digitalrayafokus.com/portofolio.',
                'Portofolio kami mencakup proyek-proyek untuk perusahaan besar seperti ABC Corp, XYZ Inc, dan banyak lagi. Silakan kunjungi website kami untuk informasi lebih detail.',
            ],
        ];
        
        // Cek pola yang cocok
        foreach ($patterns as $intent => $patternList) {
            foreach ($patternList as $pattern) {
                if (preg_match($pattern, $input)) {
                    // Ambil respon acak dari kategori yang cocok
                    $intentResponses = $responses[$intent];
                    return $intentResponses[array_rand($intentResponses)];
                }
            }
        }
        
        // Jika tidak ada yang cocok, coba cek keywords
        $keywords = $this->extractKeywords($input);
        foreach ($keywords as $keyword) {
            foreach ($patterns as $intent => $patternList) {
                foreach ($patternList as $pattern) {
                    // Strip regex pattern markers
                    $cleanPattern = preg_replace('/^\/(.*?)\/[a-z]*$/', '$1', $pattern);
                    $cleanPattern = preg_replace('/[\\\\\(\)\[\]\{\}\^\$\*\+\?\.]/i', '', $cleanPattern);
                    if (str_contains($cleanPattern, $keyword)) {
                        $intentResponses = $responses[$intent];
                        return $intentResponses[array_rand($intentResponses)];
                    }
                }
            }
        }
        
        // Respons default jika tidak ada yang cocok
        $default = [
            'Maaf, saya belum memahami pertanyaan Anda. Bisa disampaikan dengan cara lain?',
            'Saya masih belajar untuk memahami pertanyaan Anda. Coba tanyakan dengan cara berbeda.',
            'Mohon maaf, saya tidak mengerti pertanyaan Anda. Silakan hubungi customer service kami untuk bantuan lebih lanjut.',
            'Terima kasih atas pertanyaan Anda. Untuk informasi lebih lanjut, silakan hubungi kami melalui telepon atau email.'
        ];
        
        return $default[array_rand($default)];
    }
    
    /**
     * Extract keywords from input text
     */
    public function extractKeywords(string $text): array
    {
        // Simple stopwords - add more as needed
        $stopwords = [
            'yang', 'di', 'dan', 'ke', 'pada', 'untuk', 'dari', 'dalam', 'dengan', 
            'adalah', 'ini', 'itu', 'atau', 'juga', 'saya', 'kamu', 'kami', 'mereka',
            'ada', 'akan', 'tidak', 'bisa', 'sudah', 'jika', 'jadi', 'oleh', 'karena',
            'secara', 'ketika', 'maka', 'hanya', 'tentang', 'yaitu', 'yakni', 'daripada',
            'sebagai', 'seperti', 'apakah', 'bagaimana', 'siapa', 'apa', 'kapan', 'dimana',
            'the', 'and', 'of', 'to', 'a', 'in', 'for', 'is', 'on', 'that', 'by', 'this',
            'with', 'i', 'you', 'it', 'not', 'or', 'be', 'are', 'from', 'at', 'as', 'your',
            'have', 'more', 'an', 'was'
        ];
        
        // Tokenize
        $text = strtolower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text); // Remove special chars
        $tokens = preg_split('/\s+/', $text);
        
        // Remove stopwords and short words
        $keywords = [];
        foreach ($tokens as $token) {
            if (!in_array($token, $stopwords) && strlen($token) > 2) {
                $keywords[] = $token;
            }
        }
        
        // Sort by length (longer words often more significant)
        usort($keywords, function($a, $b) {
            return strlen($b) - strlen($a);
        });
        
        // Limit to top keywords
        return array_slice($keywords, 0, 5);
    }
    
    /**
     * Simple sentiment analysis
     */
    public function analyzeSentiment(string $text): string
    {
        $text = strtolower($text);
        
        $positive_words = [
            'bagus', 'baik', 'senang', 'suka', 'luar biasa', 'hebat', 'keren', 
            'mantap', 'terima kasih', 'membantu', 'puas', 'memuaskan', 'ramah',
            'cepat', 'mudah', 'berhasil', 'sukses', 'menyenangkan', 'sempurna'
        ];
        
        $negative_words = [
            'buruk', 'jelek', 'tidak suka', 'tidak bagus', 'kecewa', 'marah', 
            'sedih', 'lambat', 'susah', 'sulit', 'masalah', 'komplain', 'gagal',
            'rumit', 'error', 'tidak bekerja', 'tidak bisa', 'tidak puas'
        ];
        
        $positive_count = 0;
        $negative_count = 0;
        
        foreach ($positive_words as $word) {
            if (str_contains($text, $word)) {
                $positive_count++;
            }
        }
        
        foreach ($negative_words as $word) {
            if (str_contains($text, $word)) {
                $negative_count++;
            }
        }
        
        if ($positive_count > $negative_count) {
            return 'positive';
        } else if ($negative_count > $positive_count) {
            return 'negative';
        }
        
        return 'neutral';
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