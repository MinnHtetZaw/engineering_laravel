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
        Schema::create('request_materials', function (Blueprint $table) {
            $table->id();
            $table->date('request_date');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('project_phase_id');
            $table->tinyInteger('isApproved')->default(0)->comment('0-Pending,1-Approve,2-Decline');
            $table->tinyInteger('isRequested')->default(0)->comment('0-Pending,1-requested');
            $table->tinyInteger('isIssued')->default(0)->comment('0-Pending,1-issued');
            $table->unsignedInteger('employee_id');
            $table->text('reason')->nullable();
            $table->string('requested_by')->nullable();

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
        Schema::dropIfExists('request_materials');
    }
};
