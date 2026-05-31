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
    Schema::create('comments', function (Blueprint $table) {
        $table->id('comment_id');
        $table->foreignId('post_id')->constrained('posts', 'post_id')->cascadeOnDelete();
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
        $table->text('content');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
