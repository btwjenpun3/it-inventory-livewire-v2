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
        Schema::create('po_suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_id');
            $table->foreign('marketing_id')->references('id')->on('marketings')->onDelete('cascade');
            $table->string('po_no');
            $table->string('po_date');
            $table->string('grouping');
            $table->string('supplier_code')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('supplier_state')->nullable();
            $table->string('supplier_address')->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_grouping')->nullable();
            $table->string('supplier_payment_term')->nullable();
            $table->string('supplier_shipment_term')->nullable();
            $table->string('supplier_currency')->nullable();
            $table->string('supplier_eta')->nullable();
            $table->string('supplier_pic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_suppliers');
    }
};
