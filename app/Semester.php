<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
  protected $fillable = ['key', 'short_name', 'long_name', 'is_active', 'begin_up', 'end_up', 'begin_down', 'end_down'];

  /**
   * CASTING
   */
  protected $casts = ['is_active' => 'boolean'];

  protected $dates = ['created_at', 'updated_at', 'begin_up', 'end_up', 'begin_down', 'end_down'];
}
