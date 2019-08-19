<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemestersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('semesters', function (Blueprint $table) {
      $table->increments('id');
      $table->string('key')->unique();
      $table->string('short_name');
      $table->string('long_name');
      $table->boolean('is_active')->default(false);
      $table->datetime('begin_up')->nullable()->default(null);
      $table->datetime('end_up')->nullable()->default(null);
      $table->datetime('begin_down')->nullable()->default(null);
      $table->datetime('end_down')->nullable()->default(null);
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
    Schema::drop('semesters');
  }
}
