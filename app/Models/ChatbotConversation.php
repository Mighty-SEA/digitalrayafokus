<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotConversation extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'user_message',
        'bot_response',
        'processed_data',
        'source',
        'sentiment',
    ];

    /**
     * Atribut yang harus di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'processed_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Mendapatkan semua percakapan dalam satu sesi.
     *
     * @param string $sessionId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getConversationBySession($sessionId)
    {
        return self::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Mendapatkan percakapan terbaru.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getRecentConversations($limit = 10)
    {
        return self::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
} 