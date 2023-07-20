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
        Schema::create('report_request_maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total_stock_qty')->nullable();
            $table->unsignedBigInteger('request_maintenance_id');
            $table->date('finished_date');
            $table->string('progress');
            $table->string('performance');
            $table->tinyInteger('performance_status');
            $table->string('report_description');
            $table->integer('file_count');
            $table->string('checked_by');

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
        Schema::dropIfExists('report_request_maintenances');
    }
};
