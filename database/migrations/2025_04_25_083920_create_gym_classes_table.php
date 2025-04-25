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
        Schema::create('class', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->time('start_time'); 
            $table->integer('duration_minutes'); 
            $table->integer('capacity');

            $table->foreignId('id_instructor')
            ->nullable() 
            ->constrained('users') 
            ->nullOnDelete();

            $table->foreignId('id_categories')
            ->constrained('categories') 
            ->restrictOnDelete(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class');
    }
};
