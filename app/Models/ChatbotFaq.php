<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotFaq extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'answer',
        'keywords',
        'is_active',
        'priority',
        'category',
    ];

    /**
     * Atribut yang harus di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Mencari FAQ yang cocok dengan input pengguna.
     *
     * @param string $input
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function findMatchingFaq($input)
    {
        // Hanya ambil FAQ yang aktif
        $faqs = self::where('is_active', true)
            ->orderBy('priority', 'desc')
            ->get();
        
        // Cari kecocokan berdasarkan kata kunci
        $inputLower = strtolower(trim($input));
        
        foreach ($faqs as $faq) {
            // Periksa apakah pertanyaan cocok
            if (str_contains(strtolower($faq->question), $inputLower)) {
                return $faq;
            }
            
            // Periksa apakah ada kata kunci yang cocok
            if ($faq->keywords) {
                $keywords = explode(',', $faq->keywords);
                foreach ($keywords as $keyword) {
                    $keyword = strtolower(trim($keyword));
                    if (str_contains($inputLower, $keyword) || str_contains($keyword, $inputLower)) {
                        return $faq;
                    }
                }
            }
        }
        
        return null;
    }

    /**
     * Dapatkan semua FAQ yang terkelompok berdasarkan kategori.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getGroupedByCategory()
    {
        return self::where('is_active', true)
            ->orderBy('priority', 'desc')
            ->orderBy('category')
            ->get()
            ->groupBy('category');
    }
} 