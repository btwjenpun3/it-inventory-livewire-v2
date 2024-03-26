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
        Schema::create('marketings', function (Blueprint $table) {
            $table->id();
            $table->string('order_production_no')->nullable();
            $table->date('order_production_date')->nullable();
            $table->string('po_buyer_no');
            $table->date('po_buyer_date');
            $table->string('buyer_code');
            $table->string('buyer_name');
            $table->string('discount')->nullable();
            $table->string('down_payment')->nullable();
            $table->string('tax')->nullable();
            $table->string('currency');         
            $table->date('due_date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('pic_name');
            $table->string('pic_title');
            $table->string('pic_email');           
            $table->string('validate')->nullable();
            $table->date('validate_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketings');
    }
};
