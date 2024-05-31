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
        Schema::create('play_together_details', function (Blueprint $table) {
            $table->unsignedBigInteger('play_together_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->primary(['play_together_id', 'user_id']);
            $table->foreign('play_together_id')->references('id')->on('play_togethers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('play_together_details');
    }
};
