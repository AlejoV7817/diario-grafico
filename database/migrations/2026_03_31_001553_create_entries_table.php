<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();

            // Relación con usuario
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Datos del diario
            $table->date('date');
            $table->string('title');
            $table->text('content');

            // Estado emocional (-10 a 10)
            $table->integer('mood_value');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};