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
      'IAMB'    => "Ingeniería Ambiental",
      'IIA'     => "Ingeniería en Industrias Alimentarias",
      'ISC'     => "Ingeniería en Sistemas Computacionales",
      'II'      => "Ingeniería Industrial",
      'IGE'     => "Ingeniería en Gestión Empresarial",
      'IGE-MIX' => "Ingeniería en Gestión Empresarial Mixta",
    ];

    foreach ($careers as $key => $value) {
      Career::create([
        'key'  => $key,
        'name' => $value
      ]);
    }
    $this->command->info("Careers table seeded");
  }
}
