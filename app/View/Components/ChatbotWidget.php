<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ChatbotWidget extends Component
{
    /**
     * Warna tombol chatbot
     *
     * @var string
     */
    public $buttonColor;

    /**
     * Warna header chatbot
     *
     * @var string
     */
    public $headerColor;

    /**
     * Teks header chatbot
     *
     * @var string
     */
    public $headerText;

    /**
     * Pesan sambutan awal
     *
     * @var string
     */
    public $welcomeMessage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $buttonColor = '#007bff',
        $headerColor = '#007bff',
        $headerText = 'Chat dengan Digital Raya Fokus',
        $welcomeMessage = 'Halo! Selamat datang di Digital Raya Fokus. Ada yang bisa saya bantu?'
    ) {
        $this->buttonColor = $buttonColor;
        $this->headerColor = $headerColor;
        $this->headerText = $headerText;
        $this->welcomeMessage = $welcomeMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.chatbot-widget');
    }
} 