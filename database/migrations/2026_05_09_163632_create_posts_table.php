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
        Schema::create('posts', function (Blueprint $table) {
    $table->id('post_id'); // Clé primaire du MLD
    $table->text('content');
    $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
    $table->timestamps(); // Gère created_at et updated_at du MLD
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
