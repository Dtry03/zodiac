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

        Schema::create('tenants', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->unique(); 
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();    
            $table->string('pm_last_four', 4)->nullable(); 
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('subscription_status')->default('pending_payment');
            $table->timestamp('subscribed_at')->nullable(); 
            $table->timestamp('subscription_ends_at')->nullable(); 
            $table->timestamp('grace_period_ends_at')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('theme_color')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.

     */
    public function down(): void
    {
        Schema::dropIfExists('tenants'); 
    }
};
