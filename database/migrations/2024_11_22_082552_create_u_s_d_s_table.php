<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usd', function (Blueprint $table) {
            $table->id();
            $table->integer('dollar');
            $table->timestamps();

        });

        DB::table('usd')->insert([
            "id" => 1,
            "dollar" => 16000,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usd');
    }
};
