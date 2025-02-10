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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('short_description')->nullable();
            $table->text('game_url')->nullable();
            $table->string('genre')->nullable();
            $table->string('platform')->nullable();
            $table->string('publisher')->nullable();
            $table->string('developer')->nullable();
            $table->date('release_date')->nullable();
            $table->string('freetogame_profile_url')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
