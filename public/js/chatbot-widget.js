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
    
    // Debug mode
    const isDebugMode = localStorage.getItem('chatbot_debug_mode') === 'true';
    
    // Toggle debug mode dengan Ctrl+Shift+D
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.shiftKey && e.key === 'D') {
            const newDebugMode = !isDebugMode;
            localStorage.setItem('chatbot_debug_mode', newDebugMode);
            alert(`Debug mode ${newDebugMode ? 'enabled' : 'disabled'}. Please refresh the page.`);
        }
    });
    
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
                    addMessage(data.message, false, data.processed_data);
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
     * @param {object} processedData - Data NLP yang diproses (opsional)
     */
    function addMessage(message, isUser = false, processedData = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = isUser ? 'message user' : 'message bot';
        
        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        messageContent.textContent = message;
        
        messageDiv.appendChild(messageContent);
        
        // Jika dalam debug mode dan ada data NLP, tambahkan informasi tambahan
        if (isDebugMode && !isUser && processedData) {
            // Tambahkan detail NLP dalam collapsed section
            const nlpDetails = document.createElement('div');
            nlpDetails.className = 'nlp-details';
            
            // Buat tombol untuk expand/collapse
            const toggleBtn = document.createElement('button');
            toggleBtn.className = 'nlp-toggle';
            toggleBtn.textContent = 'Show NLP Details';
            toggleBtn.addEventListener('click', function() {
                const details = this.nextElementSibling;
                if (details.style.display === 'none' || !details.style.display) {
                    details.style.display = 'block';
                    this.textContent = 'Hide NLP Details';
                } else {
                    details.style.display = 'none';
                    this.textContent = 'Show NLP Details';
                }
            });
            
            // Detail NLP
            const detailsContent = document.createElement('div');
            detailsContent.className = 'nlp-details-content';
            detailsContent.style.display = 'none';
            
            // Format sentiment
            if (processedData.sentiment) {
                const sentimentDiv = document.createElement('div');
                sentimentDiv.className = `sentiment ${processedData.sentiment.sentiment || 'neutral'}`;
                sentimentDiv.textContent = `Sentiment: ${processedData.sentiment.sentiment || 'neutral'} (${processedData.sentiment.score?.toFixed(2) || 'N/A'})`;
                detailsContent.appendChild(sentimentDiv);
            }
            
            // Format keywords
            if (processedData.keywords && processedData.keywords.length) {
                const keywordsDiv = document.createElement('div');
                keywordsDiv.className = 'keywords';
                keywordsDiv.textContent = `Keywords: ${processedData.keywords.join(', ')}`;
                detailsContent.appendChild(keywordsDiv);
            }
            
            // Format entities if any
            if (processedData.entities && Object.keys(processedData.entities).length) {
                const entitiesDiv = document.createElement('div');
                entitiesDiv.className = 'entities';
                entitiesDiv.textContent = 'Entities: ';
                
                for (const [type, entities] of Object.entries(processedData.entities)) {
                    const entitySpan = document.createElement('span');
                    entitySpan.className = 'entity';
                    entitySpan.textContent = `${type}: ${entities.join(', ')}`;
                    entitiesDiv.appendChild(entitySpan);
                    entitiesDiv.appendChild(document.createElement('br'));
                }
                
                detailsContent.appendChild(entitiesDiv);
            }
            
            nlpDetails.appendChild(toggleBtn);
            nlpDetails.appendChild(detailsContent);
            messageDiv.appendChild(nlpDetails);
        }
        
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