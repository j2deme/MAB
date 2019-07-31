<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
  protected $fillable = ['key', 'name'];

  /**
   * MUTATORS
   */
  public function setKeyAttribute($value)
  {
    $this->attributes['key'] = trim(mb_strtoupper($value, 'UTF-8'));
  }

  public function setNameAttribute($value)
  {
    $this->attributes['name'] = trim(mb_strtoupper($value, 'UTF-8'));
  }
}
