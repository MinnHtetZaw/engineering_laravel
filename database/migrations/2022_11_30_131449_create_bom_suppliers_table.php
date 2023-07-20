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
        Schema::create('bom_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('request_no');
            $table->unsignedBigInteger('bom_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('request_quotation_date');
            $table->string('quotation_reply_date')->nullable();
            $table->integer('status')->default(0);
            $table->string('po_sent_date')->nullable();
            $table->string('invoice_received_date')->nullable();
            $table->string('import_start_date')->nullable();
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
        Schema::dropIfExists('bom_suppliers');
    }
};
