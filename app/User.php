<?php

namespace App;

use App\Semester;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasRoles;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'last_name',
    'username',
    'email',
    'password',
    'is_suspended',
    'is_enrolled'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * CASTING
   */
  protected $casts = [
    'is_suspended' => 'boolean',
    'is_enrolled' => 'boolean'
  ];

  /**
   * ACCESSORS
   */
  public function getFullNameAttribute()
  {
    return trim(mb_strtoupper("{$this->name} {$this->last_name}", 'UTF-8'));
  }

  /**
   * MUTATORS
   */
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = trim($value);
  }

  public function setLastNameAttribute($value)
  {
    $this->attributes['last_name'] = trim($value);
  }

  public function setUsernameAttribute($value)
  {
    $this->attributes['username'] = trim($value);
  }

  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = bcrypt($value);
  }

  /**
   * RELATIONSHIPS
   */
  public function career()
  {
    return $this->belongsTo('App\Career');
  }

  public function moves()
  {
    return $this->hasMany('App\Move');
  }

  /**
   * CUSTOM ATTRIBUTES
   */
  public function getUpsAttribute()
  {
    $last_semester = Semester::last()->first();
    return $this->moves()->where('semester_id', $last_semester->id)->where('type', 'ALTA')->count();
  }

  public function getDownsAttribute()
  {
    $last_semester = Semester::last()->first();
    return $this->moves()->where('semester_id', $last_semester->id)->where('type', 'BAJA')->count();
  }

  public function getAttendedAttribute()
  {
    $last_semester = Semester::last()->first();
    return $this->moves()->where('semester_id', $last_semester->id)->whereIn('status', ['2', '3', '4', '5'])->count();
  }
}
