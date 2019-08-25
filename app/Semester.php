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

  /**
   * SCOPES
   */
  public function scopeLast($query)
  {
    return $query->where('is_active', true)->orderBy('key', 'desc')->first();
  }

  /**
   * ACCESSORS
   */
  public function getUpRangeAttribute()
  {
    if (!is_null($this->begin_up)) {
      return $this->begin_up->format('d/m/Y') . " - " . $this->end_up->format('d/m/Y');
    } else {
      return '-';
    }
  }

  public function getDownRangeAttribute()
  {
    if (!is_null($this->begin_down)) {
      return $this->begin_down->format('d/m/Y') . " - " . $this->end_down->format('d/m/Y');
    } else {
      return '-';
    }
  }

  /**
   * RELATIONSHIPS
   */
  public function moves()
  {
    return $this->hasMany('App\Move');
  }
}
