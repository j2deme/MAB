<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('moves', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->integer('semester_id')->unsigned();
      $table->integer('group_id')->unsigned();
      $table->string('type', 5);
      $table->string('justification');
      $table->string('answer');
      $table->string('status');
      $table->integer('linked_to')->nullable();
      $table->boolean('is_batch')->default(false);
      $table->boolean('is_parallel')->default(false);
      $table->boolean('is_upgraded')->default(false);
      $table->softDeletes();
      $table->timestamps();

      $table->index(['user_id', 'semester_id', 'group_id', 'type']);
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('semester_id')->references('id')->on('semesters');
      $table->foreign('group_id')->references('id')->on('groups');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('moves');
  }
}
