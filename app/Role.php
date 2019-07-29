<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
  /**
   * Remove all current permissions and set the given ones.
   *
   * @param array ...$permissions
   *
   * @return $this
   */
  public function syncPermissions($permissions)
  {
    $this->permissions()->detach();
    foreach ($permissions as $perm) {
      $this->givePermissionTo($perm);
    }
  }
}
