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
        Schema::create('bom_material_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bom_production_detail_id');
            $table->foreign('bom_production_detail_id')->references('id')->on('bom_production_details')->onDelete('cascade');
            $table->string('quantity_to_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};
