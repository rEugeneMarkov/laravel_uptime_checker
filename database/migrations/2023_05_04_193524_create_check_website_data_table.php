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
        Schema::create('check_website_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id');
            $table->unsignedBigInteger('status');
            $table->float('execution_time');
            $table->timestamp('checked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_website_data');
    }
};
