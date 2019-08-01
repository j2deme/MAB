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
  public function setJustificationAttribute($value)
  {
    $this->attributes['justification'] = trim(mb_strtoupper($value));
  }

  public function setAnswerAttribute($value)
  {
    $this->attributes['answer'] = trim(mb_strtoupper($value));
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
