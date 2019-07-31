<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
  protected $fillable = ['key', 'short_name', 'long_name', 'career_id'];

  /**
   * MUTATORS
   */
  public function setKeyAttribute($value)
  {
    $this->attributes['key'] = trim(mb_strtoupper($value, 'UTF-8'));
  }

  public function setShortNameAttribute($value)
  {
    $this->attributes['short_name'] = trim(mb_strtoupper($value, 'UTF-8'));
  }

  public function setLongNameAttribute($value)
  {
    $this->attributes['long_name'] = trim(mb_strtoupper($value, 'UTF-8'));
  }
}
