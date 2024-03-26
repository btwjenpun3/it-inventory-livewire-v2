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
        Schema::create('bom_production_detail_subtotals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_id');
            $table->foreign('marketing_id')->references('id')->on('marketings')->onDelete('cascade');
            $table->string('material_code');
            $table->string('material_name');
            $table->string('material_unit');
            $table->string('subtotal');
            $table->string('material_requested');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_production_detail_subtotals');
    }
};
