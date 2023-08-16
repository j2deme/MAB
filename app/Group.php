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
   * ACCESSORS
   */
  public function getFullKeyAttribute()
  {
    return (is_object($this->subject)) ? $this->subject->key . "-" . $this->name : $this->name;
  }

  public function getKeyAttribute()
  {
    return $this->name;
  }
  /**
   * MUTATORS
   */
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = trim(mb_strtoupper($value, 'UTF-8'));
  }

  public function setKeyAttribute($value)
  {
    $this->attributes['name'] = trim(mb_strtoupper($value, 'UTF-8'));
  }

  /**
   * RELATIONSHIPS
   */
  public function semester()
  {
    return $this->belongsTo('App\Semester');
  }

  public function subject()
  {
    return $this->belongsTo('App\Subject');
  }

  public function moves()
  {
    return $this->hasMany('App\Move');
  }
}