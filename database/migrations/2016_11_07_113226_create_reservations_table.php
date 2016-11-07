<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
          $table->increments('id');
          $table->dateTimeTz('date_time');
          $table->integer('length_minutes');
          $table->string('activity', 75);
          $table->string('status', 45);
          $table->integer('number_persons');
          $table->integer('room_id')->unsigned();
          $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->integer('customer_id')->unsigned();
          $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('reservations');
    }
}
