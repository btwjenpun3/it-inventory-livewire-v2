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
        Schema::create('po_supplier_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('po_supplier_id');
            $table->foreign('po_supplier_id')->references('id')->on('po_suppliers')->onDelete('cascade');
            $table->string('material_code');
            $table->string('material_description');
            $table->string('stock');
            $table->string('purchase_quantity');
            $table->string('material_unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_supplier_details');
    }
};
