<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permuta extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'switches';
  
  protected $fillable = ['user_id', 'semester_id', 'base_semester', 'base_group', 'switch_group', 'candidate', 'self_match', 'is_matched', 'is_canceled','status', 'answer'];

  /**
   * CASTING
   */
  protected $dates = ['deleted_at'];

  protected $casts = [
    'self_match'    => 'boolean',
    'is_matched' => 'boolean',
    'is_canceled' => 'boolean'
  ];

  /**
   * SCOPES
   */
  public function scopeUnattended($query)
  {
    return $query->whereIn('status', ['0', '1'])
      ->orderBy('user_id', 'asc')
      ->orderBy('status', 'desc');
  }

  public function scopeRegistered($query)
  {
    return $query->where('status', '0')
      ->orderBy('user_id', 'desc')
      ->orderBy('status', 'desc');
  }

  public function scopeOnRevision($query)
  {
    return $query->where('status', ['1', '2'])
      ->orderBy('user_id', 'desc')
      ->orderBy('status', 'desc');
  }

  public function scopeAttended($query)
  {
    return $query->whereIn('status', ['3','4'])
      ->orderBy('user_id', 'desc')
      ->orderBy('status', 'desc');
  }

  /**
   * MUTATORS
   */

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

  /**
   * CUSTOM ATTRIBUTES
   */
  public function getMatchAttribute()
  {
    $match = User::where('username',$this->candidate)->first();
    return ((is_object($match)) ? $match : null);
  }
}
