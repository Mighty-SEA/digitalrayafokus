@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chatbot PT Digital Raya Fokus</h5>
                    <button id="clear-chat" class="btn btn-sm btn-light">
                        <i class="fas fa-trash"></i> Bersihkan
                    </button>
                </div>
                <div class="card-body">
                    <div id="chat-messages" class="chat-messages mb-3" style="height: 350px; overflow-y: auto;">
                        <div class="message bot">
                            <div class="message-content">
                                Halo! Selamat datang di layanan chatbot PT Digital Raya Fokus. Ada yang bisa saya bantu?
                            </div>
                        </div>
                    </div>
                    <form id="chat-form">
                        <div class="input-group">
                            <input type="text" id="user-message" class="form-control" placeholder="Ketik pesan Anda di sini..." required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .chat-messages {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    
    .message {
        margin-bottom: 15px;
        display: flex;
    }
    
    .message.user {
        justify-content: flex-end;
    }
    
    .message-content {
        padding: 10px 15px;
        border-radius: 15px;
        max-width: 80%;
        word-wrap: break-word;
    }
    
    .bot .message-content {
        background-color: #e9ecef;
        color: #212529;
        border-top-left-radius: 5px;
    }
    
    .user .message-content {
        background-color: #007bff;
        color: white;
        border-top-right-radius: 5px;
    }
    
    .typing-indicator {
        display: inline-block;
        padding: 10px 15px;
        background-color: #e9ecef;
        border-radius: 15px;
        border-top-left-radius: 5px;
    }
    
    .typing-indicator span {
        height: 10px;
        width: 10px;
        float: left;
        margin: 0 1px;
        background-color: #9E9EA1;
        display: block;
        border-radius: 50%;
        opacity: 0.4;
    }
    
    .typing-indicator span:nth-of-type(1) {
        animation: 1s blink infinite 0.3333s;
    }
    
    .typing-indicator span:nth-of-type(2) {
        animation: 1s blink infinite 0.6666s;
    }
    
    .typing-indicator span:nth-of-type(3) {
        animation: 1s blink infinite 0.9999s;
    }
    
    @keyframes blink {
        50% {
            opacity: 1;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatForm = document.getElementById('chat-form');
        const userMessageInput = document.getElementById('user-message');
        const chatMessages = document.getElementById('chat-messages');
        const clearChatButton = document.getElementById('clear-chat');
        
        // Session ID untuk melacak percakapan
        let sessionId = localStorage.getItem('chatbot_session_id');
        if (!sessionId) {
            sessionId = generateUUID();
            localStorage.setItem('chatbot_session_id', sessionId);
        }
        
        // Memuat riwayat percakapan jika ada
        loadConversationHistory();
        
        // Fungsi untuk menambahkan pesan ke area chat
        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser ? 'message user' : 'message bot';
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.textContent = message;
            
            messageDiv.appendChild(messageContent);
            chatMessages.appendChild(messageDiv);
            
            // Auto scroll ke pesan terbaru
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Fungsi untuk menampilkan indikator mengetik
        function showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message bot typing-message';
            typingDiv.innerHTML = `
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return typingDiv;
        }
        
        // Fungsi untuk mengirim pesan ke server
        function sendMessage(message) {
            // Tampilkan pesan user
            addMessage(message, true);
            
            // Tampilkan indikator mengetik
            const typingIndicator = showTypingIndicator();
            
            // Kirim pesan ke server
            fetch('{{ route('chatbot.message') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: message,
                    session_id: sessionId
                })
            })
            .then(response => response.json())
            .then(data => {
                // Hapus indikator mengetik
                typingIndicator.remove();
                
                // Simpan session ID baru jika ada
                if (data.session_id) {
                    sessionId = data.session_id;
                    localStorage.setItem('chatbot_session_id', sessionId);
                }
                
                // Tampilkan respons dari chatbot setelah delay singkat
                setTimeout(() => {
                    addMessage(data.message);
                }, 500);
            })
            .catch(error => {
                // Hapus indikator mengetik
                typingIndicator.remove();
                
                // Tampilkan pesan error
                addMessage('Maaf, terjadi kesalahan saat memproses pesan Anda. Silakan coba lagi.');
                console.error('Error:', error);
            });
        }
        
        // Fungsi untuk memuat riwayat percakapan
        function loadConversationHistory() {
            if (!sessionId) return;
            
            fetch('{{ route('chatbot.history') }}?session_id=' + sessionId)
                .then(response => response.json())
                .then(data => {
                    if (data.conversations && data.conversations.length > 0) {
                        // Hapus pesan selamat datang default
                        chatMessages.innerHTML = '';
                        
                        // Tampilkan riwayat percakapan
                        data.conversations.forEach(conv => {
                            addMessage(conv.user_message, true);
                            addMessage(conv.bot_response, false);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading conversation history:', error);
                });
        }
        
        // Fungsi untuk menghasilkan UUID
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
        
        // Event listener untuk form submit
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = userMessageInput.value.trim();
            if (message) {
                sendMessage(message);
                userMessageInput.value = '';
            }
        });
        
        // Event listener untuk tombol bersihkan chat
        clearChatButton.addEventListener('click', function() {
            // Hapus semua pesan kecuali pesan selamat datang
            chatMessages.innerHTML = `
                <div class="message bot">
                    <div class="message-content">
                        Halo! Selamat datang di layanan chatbot PT Digital Raya Fokus. Ada yang bisa saya bantu?
                    </div>
                </div>
            `;
            
            // Generate session ID baru
            sessionId = generateUUID();
            localStorage.setItem('chatbot_session_id', sessionId);
        });
    });
</script>
@endpush 