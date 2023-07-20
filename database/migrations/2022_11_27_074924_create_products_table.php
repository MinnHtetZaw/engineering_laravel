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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('brand_id');
            $table->string('product_name');
            $table->integer('part_number');
            $table->string('measuring_unit');
            $table->string('register_date');
            $table->string('description');
            $table->integer('instock_order');
            $table->integer('min_order_quantity');
            $table->integer('moq_price');
            $table->integer('instock_quantity');
            $table->integer('reorder_quantity');
            $table->integer('primary_supplier_id');
            $table->integer('second_supplier_id');
            $table->string('product_img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
