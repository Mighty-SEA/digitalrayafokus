<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->string('full_address');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });


        DB::table('companies')->insert([
            'name' => 'PT Digital Raya Fokus',
            'full_address' => 'Jl. Merdeka No. 123, Bandung, Jawa Barat',
            'logo' => 'logos/digital-raya-fokus.png', // Path file logo
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
