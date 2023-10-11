<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_emails', function (Blueprint $table) {
            $table->id();
            $table->integer('enrolment_id')->nullable();
            $table->integer('template_id')->nullable();
            $table->integer('status')->default(0); //->after('template_id')->default(0);
            $table->integer('tries')->default(0); //->after('status')->default(0);
            $table->string('subject')->default('First Loyalty Program Notification');
            $table->text('body')->nullable();//->default();
            $table->string('from')->default('firstbank@loyaltysolutionsnigeria.com');
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
        Schema::dropIfExists('pending_emails');
    }
}
