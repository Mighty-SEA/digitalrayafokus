<?php

namespace App\Http\Controllers;

use App\Chatbot\ChatbotService;
use App\Chatbot\PythonChatbotService;
use App\Models\ChatbotConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $chatbotService;
    protected $pythonChatbotService;

    public function __construct(ChatbotService $chatbotService, PythonChatbotService $pythonChatbotService)
    {
        $this->chatbotService = $chatbotService;
        $this->pythonChatbotService = $pythonChatbotService;
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
            $processedData = null;
            $source = 'php';
            $sentiment = null;
            
            Log::info('Menerima pesan chatbot:', [
                'message' => $userMessage,
                'session_id' => $sessionId
            ]);
            
            // Coba gunakan PHP chatbot untuk memastikan responsnya
            $response = $this->chatbotService->processInput($userMessage);
            
            // Cek apakah sudah ada percakapan untuk sesi ini
            $conversation = ChatbotConversation::where('session_id', $sessionId)->first();
            
            if ($conversation) {
                // Jika sesi sudah ada, perbarui data percakapan yang ada
                // Gabungkan pesan sebelumnya dengan pesan baru
                $conversation->user_message .= "\n---\n" . $userMessage;
                $conversation->bot_response .= "\n---\n" . $response;
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
                        'processed_data' => $processedData,
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