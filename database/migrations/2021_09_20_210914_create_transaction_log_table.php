<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_log', function (Blueprint $table) {
            $table->id();
            $table->string('trandate')->nullable();
            $table->unsignedBigInteger('customerid')->nullable();
            $table->string('memberid')->nullable();
            $table->string('productcode')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('description')->nullable();
            $table->string('tranchannel')->nullable();
            $table->string('tranamt')->nullable();
            $table->string('branchcode')->nullable();
            $table->unsignedBigInteger('tranid')->nullable();
            $table->string('senddate')->default(0);
            $table->string('status_code')->default(0);
            $table->string('status_message')->default(0)->nullable();
            $table->tinyInteger('cronid')->default(0);
            $table->tinyInteger('tries')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('points_earned')->nullable();
            $table->bigInteger('fileid')->nullable();
            $table->foreign('customerid')->references('id')->on('enrollments');
            $table->foreign('tranid')->references('id')->on('transactions');
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
        Schema::dropIfExists('transaction_log');
    }
}
