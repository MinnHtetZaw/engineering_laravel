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
        Schema::create('bom_supplier_grns', function (Blueprint $table) {
            $table->id();
            $table->string('grn_no');
            $table->date('grnDate');
            $table->unsignedInteger('bom_sup_po_id');
            $table->integer('arrived_qty');
            $table->integer('po_total_qty');
            $table->string('recevied_by');
            $table->string('delivered_by');
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
        Schema::dropIfExists('bom_supplier_grns');
    }
};
