<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Permission;
use App\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Ask for db migration refresh, default is no
    if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
      // Call the php artisan migrate:refresh
      $this->command->call('migrate:refresh');
      $this->command->warn("Data cleared, starting from blank database.");

      // Seed the default permissions
      $permissions = Permission::defaultPermissions();

      foreach ($permissions as $perms) {
        Permission::firstOrCreate(['name' => $perms]);
      }
      $this->command->info('Default permissions added.');

      $this->command->info('Creating basic roles & users for MAB');
      $roles = ['Admin', 'Estudiante', 'Coordinador', 'Jefe'];
      $this->createRoles($roles);
      $this->command->info('Roles added successfully');

      $this->command->warn('All done :)');
    } else {
      $this->command->warn("Not able to perform seeding to avoid violation of integrity constraints");
    }
  }

  private function createRoles($roles)
  {
    foreach ($roles as $role) {
      $role = Role::firstOrCreate(['name' => trim($role)]);

      if ($role->name == 'Admin') {
        // assign all permissions
        $role->syncPermissions(Permission::all());
        $this->command->info('Admin granted all the permissions');
      } else {
        // for others by default only read access
        $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
      }
    }
    $this->createUsers();
    $this->command->info('Users added successfully');
  }

  private function createUsers()
  {
    $faker = Faker\Factory::create();
    // Create users for administration roles
    $admin = new User();
    $admin->name = "Administrador";
    $admin->username = "admin";
    $admin->email = "dep@tecvalles.mx";
    $admin->password = bcrypt('secret');
    $admin->remember_token = str_random(10);
    $admin->save();
    $admin->assignRole('Admin');
    $this->command->info('Admin created');

    foreach (['IGE', 'ISC', 'II', 'ING', 'MIX'] as $key) {
      $coord = new User([
        'name' => "Coordinador {$key}",
        'username' => str_slug("Coordinador {$key}", "_"),
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10)
      ]);
      $coord->save();
      $coord->assignRole('Coordinador');
      unset($coord);
    }
    $this->command->info('Coordinators created');

    $jefe = new User();
    $jefe->name = 'Jefe DEP';
    $jefe->username = 'jefedep';
    $jefe->email = $faker->email;
    $jefe->password = bcrypt(str_random(10));
    $jefe->remember_token = str_random(10);
    $jefe->save();
    $jefe->assignRole('Jefe');
    $this->command->info('DEP chief created');
  }
}
