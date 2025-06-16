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
        Schema::create('chatbot_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question', 255);
            $table->text('answer');
            $table->text('keywords')->nullable()->comment('Kata kunci yang terkait dengan pertanyaan ini');
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0)->comment('Prioritas urutan pertanyaan, semakin tinggi semakin prioritas');
            $table->string('category')->nullable()->comment('Kategori pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_faqs');
    }
}; 