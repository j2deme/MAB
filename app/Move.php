<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Move extends Model
{
  use SoftDeletes;
  protected $fillable = ['user_id', 'semester_id', 'group_id', 'type', 'justification', 'answer', 'status', 'linked_to', 'is_batch', 'is_parallel', 'is_upgraded'];

  /**
   * CASTING
   */
  protected $dates = ['deleted_at'];

  protected $casts = [
    'is_batch'    => 'boolean',
    'is_parallel' => 'boolean',
    'is_upgraded' => 'boolean'
  ];

  /**
   * SCOPES
   */
  public function scopeUnattended($query)
  {
    return $query->whereIn('status', ['0', '1'])
      ->where('is_parallel', false)
      ->orderBy('user_id', 'desc')
      ->orderBy('type', 'desc')
      ->orderBy('is_parallel', 'asc')
      ->orderBy('status', 'desc');
  }

  public function scopeUnattendedParallel($query)
  {
    return $query->whereIn('status', ['0', '1'])
      ->orderBy('user_id', 'desc')
      ->orderBy('type', 'desc')
      ->orderBy('is_parallel', 'asc')
      ->orderBy('status', 'desc');
  }

  public function scopeRegistered($query, $parallel = false)
  {
    return $query->where('status', '0')
      ->where('is_parallel', $parallel)
      ->orderBy('user_id', 'desc')
      ->orderBy('type', 'desc')
      ->orderBy('is_parallel', 'asc')
      ->orderBy('status', 'desc');
  }

  public function scopeOnRevision($query, $parallel = false)
  {
    return $query->where('status', '1')
      ->where('is_parallel', $parallel)
      ->orderBy('user_id', 'desc')
      ->orderBy('type', 'desc')
      ->orderBy('is_parallel', 'asc')
      ->orderBy('status', 'desc');
  }

  public function scopeAttended($query, $parallel = false)
  {
    return $query->whereIn('status', ['2', '3', '4', '5'])
      ->where('is_parallel', $parallel)
      ->orderBy('user_id', 'desc')
      ->orderBy('type', 'desc')
      ->orderBy('is_parallel', 'asc')
      ->orderBy('status', 'desc');
  }

  /**
   * MUTATORS
   */
  public function getJustificationAttribute($value)
  {
    return json_decode($value, true);
  }

  public function setJustificationAttribute($value)
  {
    $this->attributes['justification'] = json_encode($value);
  }

  public function getAnswerAttribute($value)
  {
    return json_decode($value, true);
  }

  public function setAnswerAttribute($value)
  {
    $this->attributes['answer'] = json_encode($value);
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
