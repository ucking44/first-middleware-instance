<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_log', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->nullable();
            $table->string('uploaddate')->nullable();
            $table->string('uploadedby')->nullable();
            $table->string('filetype')->nullable();
            $table->integer('totalnumber')->nullable();
            $table->integer('totalerror')->nullable();
            $table->integer('totalpoints')->nullable();
            $table->integer('perxerrors')->nullable();
            $table->integer('status')->nullable();
            $table->string('email_code')->nullable();
            $table->text('email_message')->nullable();
            $table->text('errorreport')->nullable();
            $table->string('finishdate')->nullable();
            $table->integer('perxsuccess')->nullable();
            $table->integer('uploadsuccess')->nullable();
            $table->text('perxreport')->nullable();
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
        Schema::dropIfExists('file_log');
    }
}
