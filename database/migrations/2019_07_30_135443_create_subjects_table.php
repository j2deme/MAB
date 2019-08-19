<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('subjects', function (Blueprint $table) {
      $table->increments('id');
      $table->string('key');
      $table->string('short_name');
      $table->string('long_name');
      $table->integer('career_id')->unsigned();
      $table->timestamps();

      $table->foreign('career_id')->references('id')->on('careers');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('subjects');
  }
}
