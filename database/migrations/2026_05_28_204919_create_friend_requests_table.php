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
    Schema::create('friend_requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('sender_id');
        $table->unsignedBigInteger('receiver_id');
        $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
        $table->timestamps();

        $table->foreign('sender_id')->references('user_id')->on('users')->cascadeOnDelete();
        $table->foreign('receiver_id')->references('user_id')->on('users')->cascadeOnDelete();
        $table->unique(['sender_id', 'receiver_id']); // pas de doublons
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_requests');
    }
};
