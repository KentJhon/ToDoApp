<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('notes_details', function (Blueprint $table) {
            $table->id('notes_details_id');
            $table->unsignedBigInteger('note_id')->nullable();
            $table->unsignedBigInteger('account_id');
            $table->foreign('note_id')->references('note_id')->on('notes')->onDelete('cascade');
            $table->foreign('account_id')->references('account_id')->on('accounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_details');
    }
};
