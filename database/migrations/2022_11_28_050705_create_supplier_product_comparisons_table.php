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
        Schema::create('supplier_product_comparisons', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('product_id');
            $table->integer('primary_flag')->nullable();
            $table->integer('unit_purchase_price')->nullable();
            $table->integer('currency_id')->nullable();
            $table->integer('discount_type')->nullable();
            $table->integer('discount_value')->nullable();
            $table->integer('discount_condition')->nullable();
            $table->integer('discount_condition_value')->nullable();
            $table->integer('incoterm_id')->nullable();
            $table->string('last_purchase_date')->nullable();
            $table->integer('total_purchase_qty')->nullable();
            $table->string('delivery_leadtime')->nullable();
            $table->integer('leadtime_type')->nullable();
            $table->integer('credit_term_type')->nullable();
            $table->integer('credit_term_value')->nullable();
            $table->integer('credit_condition')->nullable();
            $table->integer('credit_condition_value')->nullable();
            $table->integer('credit_amount')->nullable();
            $table->integer('moq_price')->nullable();
            $table->integer('moq_qty')->nullable();
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
        Schema::dropIfExists('supplier_product_comparisons');
    }
};
