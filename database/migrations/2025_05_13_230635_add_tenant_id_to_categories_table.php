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
        Schema::table('categories', function (Blueprint $table) {
            
            $table->foreignId('tenant_id')
                  ->after('id') 
                  ->constrained('tenants') 
                  ->onDelete('cascade'); 

            $table->unique(['tenant_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['tenant_id', 'name']); 
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};