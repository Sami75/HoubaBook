<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation', function (Blueprint $table) {
            $table->integer('emetteur_id')->unsigned();
            $table->foreign('emetteur_id')->references('id')->on('users');
            $table->integer('recepteur_id')->unsigned();
            $table->foreign('recepteur_id')->references('id')->on('users');
            $table->integer('status')->default('0');
            $table->primary(array('emetteur_id', 'recepteur_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitation');
    }
}
