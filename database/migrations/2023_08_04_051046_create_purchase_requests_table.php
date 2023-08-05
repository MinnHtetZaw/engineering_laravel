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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_no');
            $table->date('request_date');
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('project_phase_id')->nullable();
            $table->unsignedInteger('request_material_id')->nullable();
            $table->unsignedInteger('sale_order_id')->nullable();
            $table->tinyInteger('destination_flag')->nullable()->comment('1-main,2-regional');
            $table->unsignedInteger('destination_regional_id')->nullable();
            $table->string('regional_name')->nullable();
            $table->tinyInteger('sent_status')->default(0);
            $table->tinyInteger('officer_sent_status')->default(0);
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
        Schema::dropIfExists('purchase_requests');
    }
};
