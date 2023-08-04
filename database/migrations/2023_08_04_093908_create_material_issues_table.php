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
        Schema::create('material_issues', function (Blueprint $table) {
            $table->id();
            $table->string('material_issue_no');
            $table->unsignedInteger('purchase_order_id');
            $table->integer('total_qty');
            $table->unsignedInteger('material_request_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('project_phase_id');
            $table->tinyInteger('isApproved')->default(0)->comment('1-Approved');
            $table->integer('delivery_order_status');
            $table->integer('warehouse_transfer_status');
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
        Schema::dropIfExists('material_issues');
    }
};
