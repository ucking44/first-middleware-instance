<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group_privileges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usergroup_id')->nullable();
            $table->unsignedBigInteger('priviledge_id')->nullable();// Added priviledge_id column
            $table->foreign('usergroup_id')->references('id')->on('user_groups');
            //$table->foreign('priviledge_id')->references('id')->on('privileges');
            $table->unsignedBigInteger('route_id')->nullable();
            //$table->foreign('route_id')->references('id')->on('routes');
            $table->tinyInteger('create')->default(0);
            $table->tinyInteger('read')->default(0);
            $table->tinyInteger('edit')->default(0);
            $table->tinyInteger('delete')->default(0);
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
        Schema::dropIfExists('user_group_privileges');
    }
}
