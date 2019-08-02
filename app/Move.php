<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
  protected $fillable = ['user_id', 'semester_id', 'group_id', 'type', 'justification', 'answer', 'status', 'linked_to', 'is_batch', 'is_parallel', 'is_upgraded'];

  /**
   * CASTING
   */
  protected $casts = [
    'is_batch'    => 'boolean',
    'is_parallel' => 'boolean',
    'is_upgraded' => 'boolean'
  ];

  /**
   * MUTATORS
   */
  public function getJustificationAttribute($value)
  {
    return json_decode($value, true);
  }

  public function setJustificationAttribute($value)
  {
    $this->attributes['settings'] = json_encode($value);
  }

  public function getAnswerAttribute($value)
  {
    return json_decode($value, true);
  }

  public function setAnswerAttribute($value)
  {
    $this->attributes['settings'] = json_encode($value);
  }

  public function setTypeAttribute($value)
  {
    $this->attributes['type'] = ($value == 'up') ? 'ALTA' : 'BAJA';
  }

  /**
   * RELATIONSHIPS
   */
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function semester()
  {
    return $this->belongsTo('App\Semester');
  }

  public function group()
  {
    return $this->belongsTo('App\Group');
  }
}
