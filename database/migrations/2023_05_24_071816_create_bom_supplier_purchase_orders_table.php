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
        Schema::create('bom_supplier_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bom_supplier_id');
            $table->string('supplier_po_no');
            $table->string('po_email_title');
            $table->string('po_email_description');
            $table->string('po_email_filepath');
            $table->integer('po_total_qty')->default(0);
            $table->integer('po_total_price')->default(0);
            $table->string('po_date');
            $table->integer('status');
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
        Schema::dropIfExists('bom_supplier_purchase_orders');
    }
};
