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
        Schema::create('request_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('request_no');
            $table->date('requset_date');
            $table->string('condition');
            $table->text('requirement_remark')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignId('asset_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->tinyInteger('finish_status');
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
        Schema::dropIfExists('request_maintenances');
    }
};
