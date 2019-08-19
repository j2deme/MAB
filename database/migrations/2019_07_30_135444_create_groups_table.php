<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('groups', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 5);
      $table->integer('semester_id')->unsigned();
      $table->integer('subject_id')->unsigned();
      $table->boolean('is_available')->default(true);
      $table->boolean('is_parallelizable')->default(false);
      $table->softDeletes();
      $table->timestamps();

      $table->index(['semester_id', 'subject_id', 'name']);
      $table->foreign('semester_id')->references('id')->on('semesters');
      $table->foreign('subject_id')->references('id')->on('subjects');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('groups');
  }
}
