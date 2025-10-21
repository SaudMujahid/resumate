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
        Schema::create('ratings', function (Blueprint $table) {
  $table->id();
  $table->foreignId('user_id')->constrained()->onDelete('cascade');
  $table->morphs('rateable'); // rateable_type, rateable_id
  $table->tinyInteger('rating'); // 1-5
  $table->text('review')->nullable();
  $table->timestamps();
  $table->unique(['user_id','rateable_type','rateable_id']); // one rating per user per item
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
