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
            $table->unsignedInteger('sale_order_id')->nullable();
            $table->integer('total_qty');
            $table->unsignedInteger('request_material_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('project_phase_id')->nullable();
            $table->tinyInteger('isApproved')->default(0)->comment('1-Approved');
            $table->integer('delivery_order_status')->default(0);
            $table->integer('warehouse_transfer_status')->default(0);
            $table->unsignedInteger('warehouse_transfer_id')->nullable();
            $table->integer('status')->default(0);
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
