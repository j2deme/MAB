<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('last_name')->nullable();
      $table->string('username'); //->unique(); # Se elimina llave por compatibilidad
      $table->string('email'); //->unique(); # Se elimina llave por compatibilidad
      $table->string('password');
      $table->boolean('is_suspended')->default(false);
      $table->rememberToken();
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
    Schema::drop('users');
  }
}
