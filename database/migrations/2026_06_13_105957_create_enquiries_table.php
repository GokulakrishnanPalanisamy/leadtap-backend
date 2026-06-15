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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name',255);
            $table->string('email')->index();
            $table->string('phone', 10)->index();

            $table->unsignedBigInteger('wp_post_id');
            $table->foreign('wp_post_id')->references('wp_post_id')->on('properties');

            $table->text('message');
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'declined',
            ])->default('pending')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
