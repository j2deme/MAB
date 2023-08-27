<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
  protected $fillable = ['key', 'short_name', 'long_name', 'is_active', 'begin_up', 'end_up', 'begin_down', 'end_down', 'max_ups'];

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
    /*$active = Semester::where('is_active', true)->get();
    if (count($active) == 0) {
      return $query->orderBy('key', 'desc')->first();
    } else {
      return $query->where('is_active', true)->orderBy('key', 'desc')->first();
    }*/
    return $query->where('is_active', true)->first();
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

  public function getHasEndedAttribute()
  {
    return ($this->moves->whereIn('status', ['0', '1'])->count() == 0);
  }

  /**
   * RELATIONSHIPS
   */
  public function moves()
  {
    return $this->hasMany('App\Move');
  }

  public function groups()
  {
    return $this->hasMany('App\Group');
  }
}