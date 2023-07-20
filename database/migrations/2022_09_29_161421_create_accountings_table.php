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
        Schema::create('accountings', function (Blueprint $table) {
            $table->id();
            $table->string('account_code');
            $table->string('account_name');
            $table->unsignedBigInteger('account_type');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->integer('opening_balance')->nullable();
            $table->integer('general_project_flag')->nullable();
            $table->unsignedBigInteger('cost_center_id');
            $table->unsignedBigInteger('currency_id');
            $table->integer('carry_for_work')->nullable();
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
        Schema::dropIfExists('accountings');
    }
};
