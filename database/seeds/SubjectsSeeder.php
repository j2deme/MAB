<?php

use App\Career;
use App\Subject;
use Illuminate\Database\Seeder;

class SubjectsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $career = $this->command->choice("Which subjects you want to seed?", ['ISC', 'IGE', 'NONE'], null);
    switch ($career) {
      case 'ISC':
        $this->seedISC();
        break;

      case 'NONE':
        $this->command->info("Nothing to seed");
        break;
    }
  }

  private function seedISC()
  {
    $subjects = [
      ['ISI11', 'CALCULO DIFERENCIAL', '1', '3', '2', '5'],
      ['ISI12', 'FUND. DE PROG.', '1', '2', '3', '5'],
      ['ISI13', 'TALLER DE ETICA', '1', '0', '4', '4'],
      ['ISI14', 'MAT. DISCRETAS', '1', '3', '2', '5'],
      ['ISI15', 'TALLER DE ADMON.', '1', '1', '3', '4'],
      ['ISI16', 'FUND. DE INVEST.', '1', '2', '2', '4'],
      ['ISIT17', 'TUTORIAS 1', '1', '1', '1', '1'],
      ['ISI21', 'CALCULO INTEGRAL', '2', '3', '2', '5'],
      ['ISI22', 'PROG. ORIENT. A OB.', '2', '2', '3', '5'],
      ['ISI23', 'CONT. FIN.', '2', '2', '2', '4'],
      ['ISI24', 'QUIMICA', '2', '2', '2', '4'],
      ['ISI25', 'ALGEBRA LINEAL', '2', '3', '2', '5'],
      ['ISI26', 'PROB. Y EST.', '2', '3', '2', '5'],
      ['ISIT27', 'TUTORIAS 2', '2', '1', '1', '1'],
      ['ISI31', 'CALCULO VECTORIAL', '3', '3', '2', '5'],
      ['ISI32', 'ESTRUCTURA DE DATOS', '3', '2', '3', '5'],
      ['ISI33', 'CULTURA EMPRESARIAL', '3', '2', '2', '4'],
      ['ISI34', 'INVEST. DE OP.', '3', '2', '2', '4'],
      ['ISI35', 'FISICA GENERAL', '3', '3', '2', '5'],
      ['ISI51', 'DES. SUSTENTABLE', '3', '2', '3', '5'],
      ['ISI41', 'EC.DIFERENCIALES', '4', '3', '2', '5'],
      ['ISI42', 'TOP. AV. PROG.', '4', '2', '3', '5'],
      ['ISI43', 'FUN. BASE DATOS', '4', '3', '2', '5'],
      ['ISI44', 'METODOS NUMERICOS', '4', '2', '2', '4'],
      ['ISI45', 'PRINC. ELEC. Y APLIC. DIG.', '4', '2', '3', '5'],
      ['ISI55', 'SIMULACION', '4', '2', '3', '5'],
      ['ISI36', 'FUND.ING. SOFT.', '5', '2', '2', '4'],
      ['ISI46', 'GRAFICACION', '5', '2', '2', '4'],
      ['ISI52', 'FUND. TELECOM.', '5', '2', '2', '4'],
      ['ISI53', 'TALL. DE BASE DATOS', '5', '0', '4', '4'],
      ['ISI54', 'SIST. OPERATIVOS', '5', '2', '2', '4'],
      ['ISI56', 'ARQ. DE COMP.', '5', '2', '3', '5'],
      ['ISI61', 'LENG. Y AUT. I', '6', '2', '3', '5'],
      ['ISI62', 'REDES DE COMP.', '6', '2', '3', '5'],
      ['ISI63', 'ADMON. BASE DATOS', '6', '1', '4', '5'],
      ['ISI64', 'TALL. DE SIST. OP.', '6', '0', '4', '4'],
      ['ISI65', 'ING. DE SOFT.', '6', '2', '3', '5'],
      ['ISI66', 'LENG. INTERFAZ', '6', '2', '2', '4'],
      ['ISI71', 'LENG. Y AUTO. II', '7', '2', '3', '5'],
      ['ISI72', 'CONM.Y ENRUT. REDES DATOS', '7', '2', '3', '5'],
      ['ISI73', 'TALL. DE INVEST. I', '7', '0', '4', '4'],
      ['ISI74', 'SIST. PROG.', '7', '2', '2', '4'],
      ['ISI75', 'GEST. PROY. SOFT.', '7', '3', '3', '6'],
      ['ISI76', 'INGENIERIA WEB', '7', '2', '3', '5'],
      ['ISI76TS', 'INGENIERIA WEB', '7', '1', '3', '4'],
      ['ISI78TS', 'DIS. Y CONSTRUC. B.D. DISTRIB', '7', '2', '4', '6'],
      ['ISI81', 'PROG. LOGICA Y F.', '8', '2', '2', '4'],
      ['ISI82', 'ADMON. REDES', '8', '0', '4', '4'],
      ['ISI83', 'TALL. DE INVEST. II', '8', '0', '4', '4'],
      ['ISI84', 'PROG. WEB.', '8', '1', '4', '5'],
      ['ISI85', 'ARQ. DE SERVIDORES', '8', '1', '4', '5'],
      ['ISI85TS', 'DES. APLIC. DISP. MOVILES', '8', '1', '4', '5'],
      ['ISI86', 'ADMON. AV. DE BASES DATOS', '8', '2', '3', '5'],
      ['ISI86TS', 'COMPUTO FORENSE', '8', '1', '4', '5'],
      ['ISI87', 'PROG. MOVIL', '8', '1', '4', '5'],
      ['ISI91', 'INTELIG. ART.', '9', '2', '2', '4'],
      ['ISI92', 'PROG. WEB. AV.', '9', '1', '4', '5'],
      ['ISI92TS', 'PROG. WEB AVANZADA', '9', '1', '4', '5']
    ];
    $this->seed($subjects, 'ISC');
  }

  private function seed($subjects, $key)
  {
    $c = Career::where('key', $key)->first();
    foreach ($subjects as $subj) {
      $c->subjects()->create([
        'key' => $subj[0],
        'short_name' => $subj[1],
        'long_name' => $subj[1],
        'semester' => $subj[2],
        'ht' => $subj[3],
        'hp' => $subj[4],
        'cr' => $subj[5]
      ]);
      unset($s);
    }
    $this->command->info("{$key} subjects seeded successfully!");
  }
}
