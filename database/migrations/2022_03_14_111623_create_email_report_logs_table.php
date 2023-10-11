<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailReportLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_report_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('enrollment_id')->nullable(); //->after('id');
            //$table->unsignedBigInteger('enrollment_id')->nullable();
            $table->integer('status')->nullable(); //->after('enrollment_id');  Enrollment_id
            $table->string('email')->nullable(); //->after('status');
            $table->text('email_body')->nullable(); //->after('email');
            $table->string('subject')->nullable(); //->after('enrollment_id');
            //$table->foreign('enrollment_id')->references('id')->on('enrollments')->onDelete('cascade');
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
        Schema::dropIfExists('email_report_logs');
    }
}
