<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Schema::create('chatbot_conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User ID jika pengguna terautentikasi
            $table->string('session_id')->index(); // ID sesi untuk mengelompokkan percakapan
            $table->text('user_message'); // Pesan dari pengguna
            $table->text('bot_response'); // Respons dari chatbot
            $table->json('processed_data')->nullable(); // Data NLP terproses (entitas, sentimen, dll.)
            $table->string('source')->default('php'); // Sumber respons: php atau python
            $table->string('sentiment')->nullable(); // Sentimen pesan: positive, negative, neutral
            $table->timestamps();
            
            // Tambahkan foreign key jika perlu
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_conversations');
    }
}; 