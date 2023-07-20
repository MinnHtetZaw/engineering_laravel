<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bom_supplier_grn_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bom_supplier_grn_id');
            $table->unsignedBigInteger('item_id');
            $table->timestamps();

            $table->foreign('bom_supplier_grn_id')->references('id')->on('bom_supplier_grns')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bom_supplier_grn_item');
    }
};
