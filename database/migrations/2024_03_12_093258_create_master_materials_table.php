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
        Schema::create('master_materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_code')->unique();
            $table->string('description');   
            $table->unsignedBigInteger('satuan_id')->nullable();         
            $table->foreign('satuan_id')->references('id')->on('master_satuans')->onDelete('set null');
            $table->unsignedBigInteger('material_type_id')->nullable();         
            $table->foreign('material_type_id')->references('id')->on('master_material_types')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_materials');
    }
};
