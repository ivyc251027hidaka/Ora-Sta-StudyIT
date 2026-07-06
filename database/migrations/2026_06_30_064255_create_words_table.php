<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->text('description');
            $table->text('sql_example')->nullable();
            $table->string('section');
            $table->enum('difficulty', ['easy', 'normal', 'hard'])->default('normal');
            $table->enum('quiz_type', ['choice', 'written'])->default('choice');
            $table->json('choices')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};