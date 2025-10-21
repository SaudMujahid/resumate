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
        Schema::create('resumes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('template_id')->nullable()->constrained();
      $table->string('title')->default('My Resume');
      $table->text('content'); // rendered HTML or JSON structured data
      $table->json('meta')->nullable(); // store metadata (generated fields)
      $table->enum('visibility',['private','public'])->default('private');
      $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
