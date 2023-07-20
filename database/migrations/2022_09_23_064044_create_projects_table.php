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

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->date('estimate_date');
            $table->date('submission_date');
            $table->string('rfq_file_path');
            $table->integer('status');
            $table->integer('year');
            $table->integer('project_value');
            $table->integer('expected_budget');
            $table->string('location');
            $table->string('project_contact_person');
            $table->integer('phone');
            $table->string('email');
            $table->string('project_owner');
            $table->unsignedBigInteger('customer_id');
            $table->integer('roi_value');
            $table->string('team');
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
        Schema::dropIfExists('projects');
    }
};
