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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users'); 
            $table->text('request'); 
            $table->enum('request_type', ['GET', 'POST', 'PUT', 'DELETE'])->nullable();
            $table->timestamp('request_time'); 
            $table->text('response')->nullable(); 
            $table->integer('response_status')->nullable(); 
            $table->ipAddress('ip_address'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
