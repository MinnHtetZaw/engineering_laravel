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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('warehouse_type')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('site')->nullable();
            $table->string('serial_no');
            $table->string('model');
            $table->string('size');
            $table->string('color');
            $table->string('dimension');
            $table->integer('hs_code')->nullable();
            $table->text('other_specification')->nullable();
            $table->integer('reserved_flag');
            $table->integer('in_transit_flag');
            $table->integer('in_stock_flag');
            $table->integer('delivered_flag');
            $table->integer('active_flag');
            $table->integer('site_direct_flag');
            $table->integer('condition_type')->nullable();
            $table->text('condition_remark')->nullable();
            $table->text('damage_remark')->nullable();
            $table->unsignedInteger('level_id');
            $table->integer('unit_purchase_price');
            $table->integer('unit_selling_price');
            $table->integer('currency_type_id');
            $table->integer('supplier_id');
            $table->string('purchase_date')->nullable();
            $table->string('delivered_date')->nullable();
            $table->string('registered_date')->nullable();
            $table->string('item_location')->nullable();
            $table->integer('stock_qty');
            $table->integer('grn_flag');

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
        Schema::dropIfExists('items');
    }
};
