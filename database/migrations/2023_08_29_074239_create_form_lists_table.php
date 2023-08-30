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
        Schema::create('form_lists', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
			$table->string('prefix');
			$table->string('index_digit')->nullable();
			$table->unsignedInteger('check_by');
            $table->unsignedInteger('approve_by');
            $table->unsignedInteger('prepare_by');
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
        Schema::dropIfExists('form_lists');
    }
};
