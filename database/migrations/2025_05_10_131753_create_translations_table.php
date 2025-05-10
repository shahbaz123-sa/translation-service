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
        Schema::create('translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale', 10)->index(); // e.g., en, fr, es
            $table->string('key')->index();        // e.g., welcome_message
            $table->text('content');              // e.g., Welcome!
            $table->json('tags')->nullable();    // e.g., ["mobile", "web"]
            $table->timestamps();

            $table->unique(['locale', 'key']); // ensure unique per language
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
