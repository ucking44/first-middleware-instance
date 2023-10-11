<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrolreportLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolreport_log', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('phoneno')->nullable();
            $table->bigInteger('customerid')->nullable()->unsigned();
            $table->string('branchcode')->nullable();
            $table->bigInteger('fileid')->nullable()->unsigned();
            $table->integer('status_code', false, true)->nullable();
            $table->text('status_message')->nullable();
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
        Schema::dropIfExists('enrolreport_log');
    }
}
