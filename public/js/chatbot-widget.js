/**
 * Chatbot Widget
 * JavaScript untuk mengoperasikan widget chatbot floating
 */
document.addEventListener('DOMContentLoaded', function() {
    // Elemen-elemen UI
    const chatButton = document.getElementById('chatWidgetButton');
    const chatContainer = document.getElementById('chatWidgetContainer');
    const chatClose = document.getElementById('chatWidgetClose');
    const chatMessages = document.getElementById('chatWidgetMessages');
    const chatInput = document.getElementById('chatWidgetInput');
    const chatSend = document.getElementById('chatWidgetSend');
    
    // Cek apakah semua elemen ditemukan
    if (!chatButton || !chatContainer || !chatClose || !chatMessages || !chatInput || !chatSend) {
        console.error('Beberapa elemen chatbot tidak ditemukan');
        return;
    }
    
    // Session ID untuk melacak percakapan
    let sessionId = localStorage.getItem('chatbot_session_id');
    if (!sessionId) {
        sessionId = generateUUID();
        localStorage.setItem('chatbot_session_id', sessionId);
    }
    
    // Memuat riwayat percakapan jika ada
    loadConversationHistory();
    
    // Buka/tutup chat widget
    chatButton.addEventListener('click', function() {
        chatContainer.style.display = 'flex';
        chatButton.style.display = 'none';
        // Auto scroll ke pesan terbaru
        chatMessages.scrollTop = chatMessages.scrollHeight;
        // Focus pada input
        chatInput.focus();
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
            e.preventDefault();
            sendMessage();
        }
    });
    
    /**
     * Fungsi untuk mengirim pesan ke server
     */
    function sendMessage() {
        const message = chatInput.value.trim();
        if (message) {
            // Tampilkan pesan user
            addMessage(message, true);
            chatInput.value = '';
            
            // Tampilkan indikator mengetik
            const typingIndicator = showTypingIndicator();
            
            // Dapatkan CSRF token dari meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            // Kirim pesan ke server
            fetch('/chatbot/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    message: message,
                    session_id: sessionId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
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
    
    /**
     * Fungsi untuk menambahkan pesan ke area chat
     * @param {string} message - Isi pesan
     * @param {boolean} isUser - true jika pesan dari user, false jika dari bot
     */
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
    
    /**
     * Fungsi untuk menampilkan indikator mengetik
     * @returns {HTMLElement} - Elemen indikator mengetik untuk dihapus nanti
     */
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
    
    /**
     * Fungsi untuk memuat riwayat percakapan
     */
    function loadConversationHistory() {
        if (!sessionId) return;
        
        fetch(`/chatbot/history?session_id=${sessionId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
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
    
    /**
     * Fungsi untuk menghasilkan UUID
     * @returns {string} - UUID acak
     */
    function generateUUID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
}); 