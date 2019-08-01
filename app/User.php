<?php

namespace App;

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
    'name', 'last_name', 'username', 'email', 'password', 'is_suspended'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * CASTING
   */
  protected $casts = [
    'is_suspended' => 'boolean'
  ];

  /**
   * ACCESSORS
   */
  public function getFullNameAttribute()
  {
    return trim("{$this->name} {$this->last_name}");
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
}
