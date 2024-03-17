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
        Schema::create('bom_production_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bom_production_id');
            $table->foreign('bom_production_id')->references('id')->on('bom_productions')->onDelete('cascade');
            $table->string('material');
            $table->string('ingredient');
            $table->string('quantity');
            $table->string('unit');
            $table->string('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_production_details');
    }
};
