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
        Schema::create('warehouse_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_transfer_no');
            $table->unsignedInteger('regional_warehouse_id');
            $table->date('date');
            $table->integer('total_qty');
            $table->tinyInteger('deliver_status')->default(0);
            $table->tinyInteger('accept_status')->default(0);
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
        Schema::dropIfExists('warehouse_transfers');
    }
};
