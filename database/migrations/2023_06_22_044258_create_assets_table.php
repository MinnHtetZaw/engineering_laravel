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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('type');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->date('purchase_date');
            $table->integer('price');
            $table->integer('salvage_price');
            $table->integer('use_life');
            $table->integer('yearly_depriciation');
            $table->integer('warranty');
            $table->text('warranty_docs');
            $table->tinyInteger('warranty_status')->nullable()->default(0);
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
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
        Schema::dropIfExists('assets');
    }
};
