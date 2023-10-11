<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('status_code')->nullable();
            $table->integer('cid')->nullable();
            $table->string('order_no')->nullable();
            $table->integer('billno')->nullable();
            $table->string('voucher_no')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('points_debit')->nullable();
            $table->integer('points_credit')->nullable();
            $table->integer('tran_amt')->nullable();
            $table->string('itemname')->nullable();
            $table->string('remarks')->nullable();
            $table->dateTime('date');
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
        Schema::dropIfExists('error_logs');
    }
}
