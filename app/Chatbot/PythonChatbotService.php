<?php

namespace App\Chatbot;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PythonChatbotService
{
    protected $apiUrl;
    
    public function __construct()
    {
        $this->apiUrl = env('PYTHON_CHATBOT_API_URL', 'http://localhost:5000');
    }
    
    /**
     * Kirim pesan ke API Python chatbot dan dapatkan responsnya
     * 
     * @param string $message
     * @return string
     */
    public function processMessage($message)
    {
        try {
            $response = Http::post($this->apiUrl . '/api/chatbot', [
                'message' => $message
            ]);
            
            if ($response->successful()) {
                return $response->json('message');
            } else {
                Log::error('Python Chatbot API error: ' . $response->body());
                return 'Maaf, terjadi kesalahan saat memproses pesan Anda. Silakan coba lagi nanti.';
            }
        } catch (\Exception $e) {
            Log::error('Python Chatbot API exception: ' . $e->getMessage());
            return 'Maaf, layanan chatbot sedang tidak tersedia. Silakan coba lagi nanti.';
        }
    }

    /**
     * Kirim pesan ke API Python chatbot dan dapatkan respons beserta data NLP
     * 
     * @param string $message
     * @return array
     */
    public function processMessageWithData($message)
    {
        try {
            $response = Http::post($this->apiUrl . '/api/chatbot', [
                'message' => $message
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'message' => $data['message'] ?? 'Tidak ada respons',
                    'processed_data' => $data['processed_data'] ?? null,
                ];
            } else {
                Log::error('Python Chatbot API error: ' . $response->body());
                return [
                    'message' => 'Maaf, terjadi kesalahan saat memproses pesan Anda. Silakan coba lagi nanti.',
                    'processed_data' => null,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Python Chatbot API exception: ' . $e->getMessage());
            return [
                'message' => 'Maaf, layanan chatbot sedang tidak tersedia. Silakan coba lagi nanti.',
                'processed_data' => null,
            ];
        }
    }
    
    /**
     * Periksa apakah API Python chatbot tersedia
     * 
     * @return bool
     */
    public function isAvailable()
    {
        try {
            $response = Http::get($this->apiUrl . '/api/health');
            return $response->successful() && $response->json('status') === 'ok';
        } catch (\Exception $e) {
            return false;
        }
    }
} 