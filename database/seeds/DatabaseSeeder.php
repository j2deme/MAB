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
    if ($this->command->confirm('Se reiniciara la base de datos antes de hacer el seeding, ¿Continuar y eliminar datos previos?')) {
      // Call the php artisan migrate:refresh
      $this->command->call('migrate:refresh');
      $this->command->warn("Datos eliminados, iniciando base de datos en blanco.");

      // Seed the default permissions
      $permissions = Permission::defaultPermissions();

      foreach ($permissions as $perms) {
        Permission::firstOrCreate(['name' => $perms]);
      }
      $this->command->info('Permisos default agregados.');

      $this->command->info('Creando roles y usuarios base para MAB');
      $roles = ['Admin', 'Estudiante', 'Coordinador', 'Jefe'];
      $this->createRoles($roles);
      $this->command->info('Roles agregados correctamente.');

      $this->command->warn('Finalizado :)');
    } else {
      $this->command->warn("No se pudo realizr el seeding para evitar violaciones a integridad en los datos.");
    }
  }

  private function createRoles($roles)
  {
    foreach ($roles as $role) {
      $role = Role::firstOrCreate(['name' => trim($role)]);

      if ($role->name == 'Admin') {
        // assign all permissions
        $role->syncPermissions(Permission::all());
        $this->command->info('Admin autorizado con todos los permisos.');
      } else {
        // for others by default only read access
        $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
      }
    }
    $this->createUsers();
    $this->command->info('Usuarios agregados correctamente.');
  }

  private function createUsers()
  {
    $faker = Faker\Factory::create();
    // Create users for administration roles
    $admin = new User();
    $admin->name = "Administrador";
    $admin->username = "admin";
    $admin->email = "jesus.delgado@tecvalles.mx";
    $admin->password = 'secret';
    $admin->remember_token = str_random(10);
    $admin->save();
    $admin->assignRole('Admin');
    $this->command->info('Administrador creado');

    foreach (['IGE', 'ISC', 'II', 'ING', 'MIX'] as $key) {
      $coord = new User([
        'name' => "Coordinador {$key}",
        'username' => str_slug("Coordinador {$key}", "_"),
        'email' => strtolower(str_slug("Coordinador {$key}", "_")) . "@tecvalles.mx",
        'password' => 'temporal',
        'remember_token' => str_random(10)
      ]);
      $coord->save();
      $coord->assignRole('Coordinador');
      unset($coord);
    }
    $this->command->info('Coordinadores creados');

    $jefe = new User();
    $jefe->name = 'Jefe DEP';
    $jefe->username = 'jefedep';
    $jefe->email = 'dep@tecvalles.mx';
    $jefe->password = 'secret';
    $jefe->remember_token = str_random(10);
    $jefe->save();
    $jefe->assignRole('Jefe');
    $this->command->info('Jefe DEP creado');
  }
}
