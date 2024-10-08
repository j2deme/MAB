<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
  protected $fillable = ['acronym', 'name', 'internal_key'];

  /**
   * CASTING
   */
  protected $casts = [
    'internal_key' => 'integer'
  ];

  /**
   * MUTATORS
   */
  public function setKeyAttribute($value)
  {
    $this->attributes['internal_key'] = trim(mb_strtoupper($value, 'UTF-8'));
  }

  public function setNameAttribute($value)
  {
    $this->attributes['name'] = trim(mb_strtoupper($value, 'UTF-8'));
  }

  /**
   * RELATIONSHIPS
   */
  public function subjects()
  {
    return $this->hasMany('App\Subject');
  }

  public function moves()
  {
    return $this->hasManyThrough('App\Move', 'App\User');
  }
}
