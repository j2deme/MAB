<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
  protected $fillable = ['key', 'short_name', 'long_name', 'career_id', 'semester', 'ht', 'hp', 'cr', 'is_active'];

  /**
   * CASTINGS
   */
  protected $casts = [
    'is_active' => 'boolean'
  ];

  /**
   * ACCESSORS
   */
  public function getSatcaAttribute()
  {
    return trim("{$this->ht}-{$this->hp}-{$this->cr}");
  }
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

  /**
   * RELATIONSHIPS
   */
  public function career()
  {
    return $this->belongsTo('App\Career');
  }

  public function groups()
  {
    return $this->hasMany('App\Group');
  }
}
