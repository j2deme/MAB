<?php

use Illuminate\Database\Seeder;
use App\Career;

class CareersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $careers = [
      [20, 'IAMB', "Ingeniería Ambiental"],
      [6, 'IIA', "Ingeniería en Industrias Alimentarias"],
      [9, 'ISC', "Ingeniería en Sistemas Computacionales"],
      [4, 'II', "Ingeniería Industrial"],
      [10, 'IGE', "Ingeniería en Gestión Empresarial"],
      [14, 'IGE-MIX', "Ingeniería en Gestión Empresarial Mixta"],
      [26, 'II-MIX','Ingeniería Industrial Mixta'],
      [25, 'IAGRO', 'Ingeniería en Agronomía'],
    ];

    foreach ($careers as $c) {
      Career::create([
        'key'  => $c[0],
        'name' => $c[1],
        'internal_key' => $c[2]
      ]);
    }
    $this->command->info("Careers table seeded");
  }
}
