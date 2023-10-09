<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('material_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('material_id');
            $table->integer('quantity');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('material_id')->references('id')->on('raw_materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_allocations');
    }
};
