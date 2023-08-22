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
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('do_no');
            $table->unsignedBigInteger('request_material_id')->nullable();
            $table->unsignedBigInteger('material_issue_id')->nullable();
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->unsignedBigInteger('warehouse_transfer_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('project_phase_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('receive_person')->nullable();
            $table->integer('phone')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('location')->nullable();
            $table->integer('status')->default(0);
            $table->tinyInteger('receive_status')->default(0);
            $table->integer('approve')->default(0);
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
        Schema::dropIfExists('delivery_orders');
    }
};
