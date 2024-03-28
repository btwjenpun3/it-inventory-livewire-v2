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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_id');
            $table->foreign('marketing_id')->references('id')->on('marketings')->onDelete('cascade');
            $table->string('article_code');
            $table->string('article_name');
            $table->string('description');
            $table->integer('quantity');
            $table->string('color');
            $table->string('size');
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
