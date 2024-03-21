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
            $table->string('material_type');
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references('id')->on('master_materials')->onDelete('cascade');
            $table->string('consumption');
            $table->string('total_quantity');
            $table->unsignedBigInteger('satuan_id');
            $table->foreign('satuan_id')->references('id')->on('master_satuans')->onDelete('cascade');
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('master_locations')->onDelete('cascade');
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('master_bom_levels')->onDelete('cascade');
            $table->unsignedBigInteger('procurement_id');
            $table->foreign('procurement_id')->references('id')->on('master_procurements')->onDelete('cascade');
            $table->string('note')->nullable();
            $table->string('quantity_request')->nullable();
            $table->boolean('status')->nullable();
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
