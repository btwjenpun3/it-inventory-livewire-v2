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

            $table->string('material_code');
            $table->string('material_description');
            $table->string('material_color');
            $table->string('material_size');
            $table->string('material_unit');
            $table->string('material_type');

            $table->string('consumption');
            $table->string('total_quantity');

            $table->string('location_code');
            $table->string('location_name');
            $table->string('location_warehouse_code');
            $table->string('location_rak_code');

            $table->string('level');
            $table->string('procurement');
            $table->string('lead_time')->nullable();
            
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
