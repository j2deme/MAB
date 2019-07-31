<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreditsToSubjectsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('subjects', function (Blueprint $table) {
      $table->integer('semester')->unsigned()->default(0);
      $table->integer('ht')->unsigned()->default(0);
      $table->integer('hp')->unsigned()->default(0);
      $table->integer('cr')->unsigned()->default(0);
      $table->boolean('is_active')->default(true);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('subjects', function (Blueprint $table) {
      $table->dropColumn(['semester', 'ht', 'hp', 'cr', 'is_active']);
    });
  }
}
