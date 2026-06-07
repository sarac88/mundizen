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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('category')->nullable();
            $table->string('title', 80);
            $table->text('description')->nullable();
            $table->json('certifications')->nullable();
            $table->string('mode')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->json('availability')->nullable();
            $table->string('price_unit')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('terms_accepted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
