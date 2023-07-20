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
        Schema::create('phase_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
			$table->string('description');
			$table->date('start_date');
			$table->date('end_date');
			$table->unsignedBigInteger('project_phase_id');
			$table->integer('status')->default(0);
            $table->integer('complete')->default(0);
            $table->integer('progress')->default(0);
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
        Schema::dropIfExists('phase_tasks');
    }
};
