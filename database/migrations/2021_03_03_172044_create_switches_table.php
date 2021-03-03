<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwitchesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('switches', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->integer('semester_id')->unsigned();
      $table->integer('base_semester')->unsigned();
      $table->string('base_group', 3);
      $table->string('switch_group', 3);
      $table->text('candidate');
      $table->boolean('self_match')->default(false);
      $table->boolean('is_canceled')->default(false);
      $table->boolean('is_matched')->default(false);
      $table->string('status');
      $table->string('answer');
      $table->softDeletes();
      $table->timestamps();

      $table->index(['user_id','semester_id']);
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('semester_id')->references('id')->on('semesters');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('switches');
  }
}
