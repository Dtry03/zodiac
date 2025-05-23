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
        Schema::create('signups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_user')
                  ->constrained('users') 
                  ->cascadeOnDelete(); 

             $table->foreignId('id_class')
                   ->constrained('class')
                   ->cascadeOnDelete(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signups');
    }
};
