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
        Schema::create('ai_requests', function (Blueprint $table) {
  $table->id();
  $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
  $table->text('prompt');
  $table->text('response')->nullable();
  $table->integer('tokens_used')->nullable();
  $table->string('status')->default('pending'); // pending, done, failed
  $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_requests');
    }
};
