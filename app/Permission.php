<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
  public static function defaultPermissions()
  {
    $actions = ['view', 'add', 'edit', 'delete'];
    $models = ['users', 'roles', 'moves', 'semesters', 'groups', 'subjects','careers'];

    $permissions = [];
    foreach ($actions as $action) {
      foreach ($models as $model) {
        $permissions[] = "{$action}_{$model}";
      }
    }
    return $permissions;
  }
}
