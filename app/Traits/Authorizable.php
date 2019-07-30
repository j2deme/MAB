<?php

namespace App\Traits;
/*
 * A trait to handle authorization based on users permissions for given controller
 */

trait Authorizable
{
  /**
   * Abilities
   *
   * @var array
   */
  private $abilities = [
    'index' => 'view',
    'show' => 'view',
    'create' => 'add',
    'store' => 'add',
    'edit' => 'edit',
    'update' => 'edit',
    'destroy' => 'delete'
  ];

  /**
   * Override of callAction to perform the authorization before it calls the action
   *
   * @param $method
   * @param $parameters
   * @return mixed
   */
  public function callAction($method, $parameters)
  {
    if ($ability = $this->getAbility($method)) {
      $this->authorize($ability);
    }

    return parent::callAction($method, $parameters);
  }

  /**
   * Get ability
   *
   * @param $method
   * @return null|string
   */
  public function getAbility($method)
  {
    $routeName = explode('.', \Request::route()->getName());
    $action = array_get($this->getAbilities(), $method);

    return $action ? $action . '_' . $routeName[0] : null;
  }

  /**
   * @return array
   */
  private function getAbilities()
  {
    return $this->abilities;
  }

  /**
   * @param array $abilities
   */
  public function setAbilities($abilities)
  {
    $this->abilities = $abilities;
  }
}
