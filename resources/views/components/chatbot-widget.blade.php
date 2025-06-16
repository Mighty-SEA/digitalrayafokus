{{-- Chatbot Widget Component --}}
@props([
    'buttonColor' => '#007bff',
    'headerColor' => '#007bff',
    'headerText' => 'Chat dengan Digital Raya Fokus',
    'welcomeMessage' => 'Halo! Selamat datang di Digital Raya Fokus. Ada yang bisa saya bantu?'
])

{{-- CSRF Token untuk AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Chat Widget Button --}}
<div class="chat-widget-button" id="chatWidgetButton" style="background-color: {{ $buttonColor }}">
    <i class="fas fa-comment-dots fa-lg"></i>
</div>

{{-- Chat Widget Container --}}
<div class="chat-widget-container" id="chatWidgetContainer">
    <div class="chat-widget-header" style="background-color: {{ $headerColor }}">
        <h5 class="mb-0">{{ $headerText }}</h5>
        <button class="chat-widget-close" id="chatWidgetClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="chat-widget-messages" id="chatWidgetMessages">
        <div class="message bot">
            <div class="message-content">
                {{ $welcomeMessage }}
            </div>
        </div>
    </div>
    <div class="chat-widget-input">
        <input type="text" id="chatWidgetInput" placeholder="Ketik pesan Anda di sini...">
        <button id="chatWidgetSend" style="background-color: {{ $buttonColor }}">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

{{-- Chatbot Widget Styles --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/chatbot-widget.css') }}">
<style>
    .chat-widget-button:hover {
        background-color: {{ $buttonColor }};
        filter: brightness(90%);
    }
    
    .user .message-content {
        background-color: {{ $buttonColor }};
    }
    
    .chat-widget-input button:hover {
        background-color: {{ $buttonColor }};
        filter: brightness(90%);
    }
</style>
@endpush

{{-- Chatbot Widget Script --}}
@push('scripts')
<script src="{{ asset('js/chatbot-widget.js') }}"></script>
@endpush 