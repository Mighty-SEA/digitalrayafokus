<?php

namespace App\Http\Controllers;

use App\Chatbot\ChatbotService;
use App\Models\ChatbotConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Tampilkan antarmuka chatbot
     */
    public function index()
    {
        return view('chatbot.index');
    }

    /**
     * Proses pesan dari pengguna dan kirim respons
     */
    public function processMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:500',
            ]);

            $userMessage = $request->input('message');
            $sessionId = $request->input('session_id', Str::uuid()->toString());
            $source = 'php';
            
            Log::info('Menerima pesan chatbot:', [
                'message' => $userMessage,
                'session_id' => $sessionId
            ]);
            
            // Ekstrak keywords untuk informasi NLP
            $keywords = $this->chatbotService->extractKeywords($userMessage);
            
            // Analisis sentimen
            $sentiment = $this->chatbotService->analyzeSentiment($userMessage);
            
            // Siapkan data pemrosesan NLP sederhana
            $processedData = [
                'sentiment' => [
                    'sentiment' => $sentiment,
                    'score' => ($sentiment === 'positive' ? 0.8 : ($sentiment === 'negative' ? -0.8 : 0))
                ],
                'keywords' => $keywords,
                'entities' => [],
                'tokens' => explode(' ', $userMessage)
            ];
            
            // Dapatkan respon chatbot
            $response = $this->chatbotService->processInput($userMessage);
            
            // Cek apakah sudah ada percakapan untuk sesi ini
            $conversation = ChatbotConversation::where('session_id', $sessionId)->first();
            
            if ($conversation) {
                // Jika sesi sudah ada, perbarui data percakapan yang ada
                // Gabungkan pesan sebelumnya dengan pesan baru
                $conversation->user_message .= "\n---\n" . $userMessage;
                $conversation->bot_response .= "\n---\n" . $response;
                
                // Simpan data pemrosesan NLP
                $conversation->processed_data = json_encode($processedData);
                $conversation->source = $source;
                $conversation->sentiment = $sentiment;
                $conversation->save();
                
                Log::info('Percakapan sesi berhasil diperbarui');
            } else {
                // Jika ini sesi baru, buat entri baru
                try {
                    ChatbotConversation::create([
                        'user_id' => null, // null jika pengguna tidak login
                        'session_id' => $sessionId,
                        'user_message' => $userMessage,
                        'bot_response' => $response,
                        'processed_data' => json_encode($processedData),
                        'source' => $source,
                        'sentiment' => $sentiment,
                    ]);
                    
                    Log::info('Percakapan sesi baru berhasil disimpan ke database');
                } catch (\Exception $e) {
                    // Log error tapi tetap lanjutkan respons
                    Log::error('Gagal menyimpan percakapan chatbot: ' . $e->getMessage());
                }
            }

            return response()->json([
                'message' => $response,
                'session_id' => $sessionId,
                'processed_data' => $processedData,
                'nlp_info' => [
                    'sentiment' => $sentiment,
                    'keywords' => $keywords,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error pada chatbot: ' . $e->getMessage());
            return response()->json([
                'message' => 'Maaf, terjadi kesalahan saat memproses pesan Anda. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mendapatkan riwayat percakapan berdasarkan session ID
     */
    public function getConversationHistory(Request $request)
    {
        try {
            $sessionId = $request->input('session_id');
            
            if (!$sessionId) {
                return response()->json(['error' => 'Session ID diperlukan'], 400);
            }
            
            $conversation = ChatbotConversation::where('session_id', $sessionId)->first();
            
            if (!$conversation) {
                return response()->json([
                    'conversations' => [],
                    'session_id' => $sessionId,
                ]);
            }
            
            // Bagi percakapan berdasarkan pemisah
            $userMessages = explode("\n---\n", $conversation->user_message);
            $botResponses = explode("\n---\n", $conversation->bot_response);
            
            $conversations = [];
            for ($i = 0; $i < count($userMessages); $i++) {
                $conversations[] = [
                    'user_message' => $userMessages[$i],
                    'bot_response' => $botResponses[$i] ?? '',
                    'created_at' => $conversation->created_at,
                    'updated_at' => $conversation->updated_at,
                ];
            }
            
            return response()->json([
                'conversations' => $conversations,
                'session_id' => $sessionId,
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil riwayat percakapan: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil riwayat percakapan'
            ], 500);
        }
    }
} 