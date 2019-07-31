<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $fillable = ['name', 'semester_id', 'subject_id', 'is_available'];

  /**
   * CASTING
   */
  protected $casts = ['is_available' => 'boolean'];

  /**
   * MUTATORS
   */
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = trim(mb_strtoupper($value, 'UTF-8'));
  }
}
