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
        Schema::create('report_request_minatenance_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_req_maintain_id')->constrained('report_request_maintenances');
            $table->tinyInteger('file_type');
            $table->text('file');
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
        Schema::dropIfExists('report_request_minatenance_files');
    }
};
