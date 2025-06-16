<footer class="bg-foot text-white pt-16 pb-8">
    <!-- CSRF Token untuk Ajax -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Company Info -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 group">
                    @if(isset($settings['company_logo2']) && $settings['company_logo2'])
                    <img src="{{ asset('storage/' . $settings['company_logo2']) }}" 
                    alt="Logo {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}" 
                         class="relative w-full max-w-lg mx-auto rounded-2xl transform group-hover:-translate-y-2 transition-transform duration-500">
                @else
                    <img src="{{ asset('asset/logo.png') }}" 
                    alt="Logo {{ $settings['company_name'] ?? 'Digital Raya Fokus' }}" 
                         class="w-12 h-12">
                @endif
                    <div>
                        <h3 class="text-xl font-bold mb-1">{{ $settings['company_name'] }}</h3>
                        <div class="w-20 h-0.5 bg-blue-500 transform origin-left group-hover:scale-x-150 transition-transform duration-300"></div>
                    </div>
                </div>
                <p class="text-gray-400 leading-relaxed">
                    {{ $settings['company_description'] }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-6 relative inline-block group">
                    Layanan Kami
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-500 transform origin-left group-hover:scale-x-100 transition-transform duration-300"></div>
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Konsultasi Teknologi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Pengembangan Software</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Infrastruktur Teknologi</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Layanan Manajemen TI</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 flex items-center group">
                            <i class="fas fa-chevron-right text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 mr-2"></i>
                            <span>Pelatihan dan Sertifikasi</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-6 relative inline-block group">
                    Hubungi Kami
                    <div class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-500 transform origin-left group-hover:scale-x-100 transition-transform duration-300"></div>
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/10 flex items-center justify-center group-hover:bg-blue-600 transition-all duration-300">
                            <i class="fas fa-map-marker-alt text-blue-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <span class="text-gray-400 group-hover:text-blue-400 transition-colors duration-300 flex-1">{{ $settings['company_address'] }}</span>
                    </li>
                    <li class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/10 flex items-center justify-center group-hover:bg-blue-600 transition-all duration-300">
                            <i class="fas fa-phone-alt text-blue-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <a href="tel:{{ $settings['company_phone'] }}" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            {{ $settings['company_phone'] }}
                        </a>
                    </li>
                    <li class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/10 flex items-center justify-center group-hover:bg-blue-600 transition-all duration-300">
                            <i class="fas fa-envelope text-blue-400 group-hover:text-white transition-colors"></i>
                        </div>
                        <a href="mailto:{{ $settings['company_email'] }}" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
                            {{ $settings['company_email'] }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-mint mt-12 pt-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} {{ $settings['company_name'] }}. All rights reserved.</p>
        </div>
    </div>

    <!-- ChatBot Widget Button -->
    <div class="chat-widget-button" id="chatWidgetButton">
        <i class="fas fa-comment-dots fa-lg"></i>
    </div>
    
    <!-- ChatBot Widget Container -->
    <div class="chat-widget-container" id="chatWidgetContainer">
        <div class="chat-widget-header">
            <div class="header-logo">
                <i class="fas fa-robot mr-2"></i>
                <h5 class="mb-0">Asisten Digital PT Digital Raya Fokus</h5>
            </div>
            <button class="chat-widget-close" id="chatWidgetClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="chat-widget-messages" id="chatWidgetMessages">
            <div class="message bot">
                <div class="message-content">
                    <div class="message-bubble">
                        Halo! Selamat datang di PT Digital Raya Fokus. Ada yang bisa saya bantu terkait layanan digital kami?
                    </div>
                    <div class="message-time">
                        Hari ini {{ date('H:i') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-widget-input">
            <div class="input-container">
                <input type="text" id="chatWidgetInput" placeholder="Ketik pesan Anda di sini...">
                <button id="chatWidgetSend">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="powered-by">
                Powered by Digital Raya Fokus
            </div>
        </div>
    </div>

    <!-- ChatBot Widget Styles -->
    <style>
        /* Chatbot Widget Styles */
        .chat-widget-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #1a73e8;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.4);
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .chat-widget-button:hover {
            transform: scale(1.1);
            background-color: #1557b0;
        }
        
        .chat-widget-container {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 370px;
            height: 550px;
            background-color: #f8f9fa;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            overflow: hidden;
            display: none;
            flex-direction: column;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }
        
        .chat-widget-header {
            background-color: #1a73e8;
            color: white;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chat-widget-close {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        
        .chat-widget-close:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .chat-widget-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23f0f0f0' fill-opacity='0.3' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        .chat-widget-input {
            padding: 12px;
            border-top: 1px solid #e9ecef;
            background-color: #fff;
        }
        
        .input-container {
            display: flex;
            background-color: #f1f3f4;
            border-radius: 24px;
            padding: 8px 16px;
            transition: box-shadow 0.2s;
        }
        
        .input-container:focus-within {
            box-shadow: 0 0 0 2px #1a73e8;
            background-color: #fff;
        }
        
        .chat-widget-input input {
            flex: 1;
            padding: 8px 12px;
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            color: #333;
        }
        
        .chat-widget-input input::placeholder {
            color: #9aa0a6;
        }
        
        .chat-widget-input button {
            background-color: transparent;
            color: #1a73e8;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        
        .chat-widget-input button:hover {
            background-color: rgba(26, 115, 232, 0.1);
        }
        
        .powered-by {
            text-align: center;
            font-size: 11px;
            margin-top: 8px;
            color: #9aa0a6;
        }
        
        .message {
            margin-bottom: 16px;
            display: flex;
        }
        
        .message.user {
            justify-content: flex-end;
        }
        
        .message-content {
            max-width: 80%;
            display: flex;
            flex-direction: column;
        }
        
        .message-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            word-wrap: break-word;
            line-height: 1.4;
            position: relative;
        }
        
        .message-time {
            font-size: 11px;
            color: #9aa0a6;
            margin-top: 4px;
            margin-left: 8px;
        }
        
        .bot .message-bubble {
            background-color: #f1f3f4;
            color: #202124;
            border-bottom-left-radius: 4px;
        }
        
        .user .message-bubble {
            background-color: #1a73e8;
            color: white;
            border-bottom-right-radius: 4px;
        }
        
        .user .message-time {
            text-align: right;
            margin-right: 8px;
        }
        
        .typing-indicator {
            display: inline-block;
            padding: 12px 16px;
            background-color: #f1f3f4;
            border-radius: 18px;
            border-bottom-left-radius: 4px;
        }
        
        .typing-indicator span {
            height: 8px;
            width: 8px;
            float: left;
            margin: 0 2px;
            background-color: #9aa0a6;
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
        
        /* Responsif untuk Perangkat Mobile */
        @media (max-width: 480px) {
            .chat-widget-container {
                width: 90%;
                height: 70vh;
                right: 5%;
                left: 5%;
                bottom: 80px;
            }
            
            .chat-widget-button {
                width: 50px;
                height: 50px;
                right: 10px;
                bottom: 10px;
            }
        }
    </style>

    <!-- ChatBot Widget Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.getElementById('chatWidgetButton');
            const chatContainer = document.getElementById('chatWidgetContainer');
            const chatClose = document.getElementById('chatWidgetClose');
            const chatMessages = document.getElementById('chatWidgetMessages');
            const chatInput = document.getElementById('chatWidgetInput');
            const chatSend = document.getElementById('chatWidgetSend');
            
            // Session ID untuk melacak percakapan
            let sessionId = localStorage.getItem('chatbot_session_id');
            if (!sessionId) {
                sessionId = generateUUID();
                localStorage.setItem('chatbot_session_id', sessionId);
            }
            
            // Buka/tutup chat widget
            chatButton.addEventListener('click', function() {
                chatContainer.style.display = 'flex';
                chatButton.style.display = 'none';
                // Auto scroll ke pesan terbaru
                chatMessages.scrollTop = chatMessages.scrollHeight;
                // Focus pada input
                setTimeout(() => {
                    chatInput.focus();
                }, 300);
            });
            
            chatClose.addEventListener('click', function() {
                chatContainer.style.display = 'none';
                chatButton.style.display = 'flex';
            });
            
            // Kirim pesan saat klik tombol kirim
            chatSend.addEventListener('click', function() {
                sendMessage();
            });
            
            // Kirim pesan saat tekan Enter
            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
            
            // Dapatkan CSRF token
            const getCSRFToken = () => {
                const metaTag = document.querySelector('meta[name="csrf-token"]');
                return metaTag ? metaTag.getAttribute('content') : '';
            };
            
            // Fungsi untuk mengirim pesan
            function sendMessage() {
                const message = chatInput.value.trim();
                if (message) {
                    // Tampilkan pesan user
                    addMessage(message, true);
                    chatInput.value = '';
                    
                    // Tampilkan indikator mengetik
                    const typingIndicator = showTypingIndicator();
                    
                    // Kirim pesan ke server
                    fetch('/chatbot/message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCSRFToken()
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
            }
            
            // Fungsi untuk menambahkan pesan ke area chat
            function addMessage(message, isUser = false) {
                const messageDiv = document.createElement('div');
                messageDiv.className = isUser ? 'message user' : 'message bot';
                
                const messageContent = document.createElement('div');
                messageContent.className = 'message-content';
                
                const messageBubble = document.createElement('div');
                messageBubble.className = 'message-bubble';
                messageBubble.textContent = message;
                
                const messageTime = document.createElement('div');
                messageTime.className = 'message-time';
                
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                messageTime.textContent = `${hours}:${minutes}`;
                
                messageContent.appendChild(messageBubble);
                messageContent.appendChild(messageTime);
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
                    <div class="message-content">
                        <div class="typing-indicator">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                `;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                return typingDiv;
            }
            
            // Fungsi untuk menghasilkan UUID
            function generateUUID() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }
        });
    </script>
</footer>
