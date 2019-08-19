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
    $this->command->info("Seeding subjects");
    $this->seedISC();
    $this->seedIGE();
    $this->seedIIN();
    $this->seedIAMB();
    $this->seedIIA();
    /* $career = $this->command->choice("Which subjects you want to seed?", ['ISC', 'IGE', 'NONE'], null);
    switch ($career) {
      case 'ISC':
        $this->seedISC();
        break;
      case 'NONE':
        $this->command->info("Nothing to seed");
        break;
    } */
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
      ['ISI92TS', 'PROG. WEB AVANZADA', '9', '1', '4', '5'],
      ['ISI67TM', 'DES.APLIC. MULTIPLATAFORMA', '6', '2', '3', '5'],
      ['ISI74TM', 'DES. BAS. EN PRUEBAS (TDD)', '7', '2', '2', '4'],
      ['ISI78TM', 'TOP.SEL. BASES DATOS', '7', '2', '3', '5'],
      ['ISI85TM', 'INTERNET DE LAS COSAS', '8', '2', '4', '6'],
      ['ISI86TM', 'MOD.DES.APL. MULTIPLATAFORMA', '8', '2', '3', '5'],
    ];
    $this->seed($subjects, 'ISC');
  }

  private function seedIGE()
  {
    $subjects = [
      ['IGE11', 'FUND. DE INVESTIGACION', '1', '2', '2', '4'],
      ['IGE12', 'CALCULO DIFERENCIAL', '1', '3', '2', '5'],
      ['IGE13', 'DESARROLLO HUMANO', '1', '2', '2', '4'],
      ['IGE14', 'FUND. DE GEST. EMP.', '1', '3', '2', '5'],
      ['IGE15', 'FUND. DE FISICA', '1', '2', '2', '4'],
      ['IGE16', 'FUND. DE QUIMICA', '1', '3', '2', '5'],
      ['IGET17', 'TUTORIAS 1', '1', '1', '1', '1'],
      ['IGE21', 'SOFT. DE APL. EJEC.', '2', '1', '4', '5'],
      ['IGE22', 'CALCULO INTEGRAL', '2', '3', '2', '5'],
      ['IGE23', 'CONTAB. ORIENT. NEG.', '2', '2', '3', '5'],
      ['IGE24', 'DINAMICA SOCIAL', '2', '2', '2', '4'],
      ['IGE25', 'TALLER DE ETICA', '2', '0', '4', '4'],
      ['IGE26', 'LEGISLACION LAB.', '2', '3', '1', '4'],
      ['IGET27', 'TUTORIAS 2', '2', '1', '1', '1'],
      ['IGE31', 'MARCO LEG. ORG.', '3', '2', '2', '4'],
      ['IGE32', 'PROB. Y EST. DESC.', '3', '2', '3', '5'],
      ['IGE33', 'COSTOS EMP.', '3', '2', '3', '5'],
      ['IGE34', 'HAB. DIRECT.I', '3', '2', '2', '4'],
      ['IGE35', 'ECON. EMP.', '3', '3', '2', '5'],
      ['IGE36', 'ALG. LINEAL', '3', '3', '2', '5'],
      ['IGE41', 'ING. ECON.', '4', '3', '2', '5'],
      ['IGE42', 'EST. INFEREN. I', '4', '3', '3', '6'],
      ['IGE43', 'INST. PRESUP. EMP.', '4', '2', '3', '5'],
      ['IGE44', 'HAB. DIRECT. II', '4', '2', '2', '4'],
      ['IGE45', 'ENTORNO MACROEC.', '4', '3', '2', '5'],
      ['IGE46', 'INVEST. DE OP.', '4', '3', '2', '5'],
      ['IGE51', 'FINANZAS EN LAS ORG.', '5', '3', '2', '5'],
      ['IGE52', 'ESTAD. INFERENCIAL II', '5', '3', '3', '6'],
      ['IGE53', 'ING. DE PROCESOS', '5', '3', '2', '5'],
      ['IGE54', 'GEST. DEL CAPITAL HUMANO', '5', '3', '3', '6'],
      ['IGE55', 'TALLER DE INVEST. I', '5', '0', '4', '4'],
      ['IGE56', 'MERCADOTECNIA', '5', '3', '2', '5'],
      ['IGE61', 'ADMON. SALUD. Y SEG. OCUP.', '6', '3', '2', '5'],
      ['IGE62', 'EL EMPREN. Y LA INNOV.', '6', '2', '3', '5'],
      ['IGE63', 'GEST. DE LA PROD. I', '6', '2', '2', '4'],
      ['IGE64', 'DISEÑO ORGANIZACIONAL', '6', '2', '3', '5'],
      ['IGE65', 'TALLER DE INVEST. II', '6', '0', '4', '4'],
      ['IGE66', 'SIST. DE INF. DE MERC.', '6', '2', '3', '5'],
      ['IGE67', 'TALLER DE TICS PARA LA GESTION', '6', '0', '6', '6'],
      ['GIO77', 'INTELIG. DE NEGOCIOS', '7', '2', '4', '6'],
      ['IGE71', 'CALID.APLIC. A LA GESTION EMP.', '7', '2', '3', '5'],
      ['IGE72', 'PLAN DE NEGOCIOS', '7', '2', '3', '5'],
      ['IGE73', 'GESTION DE LA PROD. II', '7', '2', '2', '4'],
      ['IGE74', 'GESTION ESTRATEGICA', '7', '2', '3', '5'],
      ['IGE75', 'DES. SUSTENTABLE', '7', '2', '3', '5'],
      ['IGE76', 'MERCADOTECNIA ELEC.', '7', '1', '4', '5'],
      ['IGE77', 'INGENIERIA FINANCIERA', '7', '2', '4', '6'],
      ['IGE87', 'INTELIGENCIA EMPRESARIAL', '7', '2', '4', '6'],
      ['GIO82', 'TALLER GEST. CALIDAD', '8', '2', '4', '6'],
      ['GIO84', 'SIST. GEST. AMBIENTAL', '8', '4', '2', '6'],
      ['GIO85', 'TALLER FINANZAS CORP.', '8', '2', '4', '6'],
      ['GIO86', 'TALLER INNOV. EN LAS ORG.', '8', '2', '4', '6'],
      ['IGE81', 'CADENA DE SUMINISTROS', '8', '3', '2', '5'],
      ['IGE84', 'TALL. ESTRAT. DE CAPITAL H.', '8', '0', '6', '6'],
      ['IGE85', 'GESTION AMBIENTAL', '8', '2', '4', '6'],
      ['IGE86', 'INGENIERIA MERCADOLOGICA', '8', '2', '4', '6'],
      ['IGE92', 'SIST. GESTION AMB.', '8', '5', '1', '6'],
      ['IGE93', 'TALLER GEST. CALIDAD', '8', '2', '4', '6'],
      ['IGE94', 'TALLER FIN. CORP.', '8', '2', '4', '6'],
      ['IGE95', 'GEST. DEL. C. INTELEC. E IN. T', '8', '3', '3', '6'],
    ];
    $this->seed($subjects, 'IGE');
  }

  private function seedIIN()
  {
    $subjects = [
      ['IIN12', 'TALLER DE ETICA', '1', '0', '4', '4'],
      ['IIN61', 'TALLER DE INVEST. I', '6', '0', '4', '4'],
      ['IIN71', 'TALLER DE INVEST. II', '7', '0', '4', '4'],
      ['IIN11', 'FUND. DE INVEST.', '1', '2', '2', '4'],
      ['IIN57', 'DES. SUSTENTABLE', '5', '2', '3', '5'],
      ['IIN13', 'CALCULO DIFERENCIAL', '1', '3', '2', '5'],
      ['IIN23', 'CALCULO INTEGRAL', '2', '3', '2', '5'],
      ['IIN32', 'ALGEBRA LINEAL', '3', '3', '2', '5'],
      ['IIN33', 'CALCULO VECTORIAL', '3', '3', '2', '5'],
      ['IIN34', 'ECONOMIA', '3', '2', '2', '4'],
      ['IIN62', 'ING. ECONOMICA', '6', '2', '2', '4'],
      ['IIN31', 'METROLOG. Y NORMALIZ.', '3', '2', '2', '4'],
      ['IIN25', 'PROB. Y EST.', '2', '2', '2', '4'],
      ['IIN52', 'GESTION DE COSTOS', '5', '2', '2', '4'],
      ['IIN81', 'FORM. Y EV. DE PROY.', '8', '2', '3', '5'],
      ['IIN66', 'MERCADOTECNIA', '6', '2', '3', '5'],
      ['IIN35', 'ESTAD. INFERENCIAL I', '3', '3', '2', '5'],
      ['IIN45', 'EST. INFERENCIAL II', '4', '3', '2', '5'],
      ['IINT17', 'TUTORIAS 1', '1', '1', '1', '1'],
      ['IINT28', 'TUTORIAS 2', '2', '1', '1', '1'],
      ['IIN53', 'ADMON. DE LAS OP. I', '5', '2', '2', '4'],
      ['IIN63', 'ADMON. DE LAS OP. II', '6', '2', '2', '4'],
      ['IIN65', 'ADMON. DEL MANT.', '6', '2', '2', '4'],
      ['IIN43', 'ALG. Y LENG. DE PROG.', '4', '2', '2', '4'],
      ['IIN21', 'ELECTRICIDAD Y ELECTRONICA IND', '2', '2', '2', '4'],
      ['IIN42', 'FISICA', '4', '2', '2', '4'],
      ['IIN76', 'GEST. DE LOS SIST. CALIDAD', '7', '2', '2', '4'],
      ['IIN44', 'INVEST. DE OP. I', '4', '2', '2', '4'],
      ['IIN54', 'INVEST. DE OP. II', '5', '2', '2', '4'],
      ['IIN72', 'PLANEACION FINANCIERA', '8', '2', '2', '4'],
      ['IIN73', 'PLAN. Y DIS. DE INSTALAC.', '7', '2', '2', '4'],
      ['IIN41', 'PROC. DE FAB.', '4', '2', '2', '4'],
      ['IIN22', 'PROP. DE LOS MATERIALES', '2', '2', '2', '4'],
      ['IIN15', 'QUIMICA', '1', '2', '2', '4'],
      ['IIN82', 'REL. INDUSTRIALES', '8', '2', '2', '4'],
      ['IIN64', 'SIMULACION', '6', '2', '2', '4'],
      ['IIN27', 'TALL. DE LIDERAZGO', '2', '2', '2', '4'],
      ['IIN55', 'CTRL. ESTAD. DE LA CALIDAD', '5', '3', '2', '5'],
      ['IIN56', 'ERGONOMIA', '5', '3', '2', '5'],
      ['IIN47', 'HIG. Y SEG. IND.', '4', '3', '2', '5'],
      ['IIN74', 'SIST. DE MANUFACTURA', '7', '3', '2', '5'],
      ['IIN75', 'LOG. Y CADENAS SUMINISTRO', '7', '1', '3', '4'],
      ['IIN14', 'TALLER H. INT.', '1', '1', '3', '4'],
      ['IIN36', 'EST. DEL TRAB. I', '3', '4', '2', '6'],
      ['IIN46', 'EST. DEL TRAB. II', '4', '4', '2', '6'],
      ['IIN16', 'DIBUJO INDUSTRIAL', '1', '0', '6', '6'],
      ['IIN26', 'AN.DE LA REALIDAD NAL.', '2', '1', '2', '3'],
      ['IIN51', 'ADMON. DE PROY.', '5', '2', '1', '3'],
      ['IIN24', 'ING. DE SISTEMAS', '2', '2', '1', '3'],
      ['IIN77', 'ING. DE LA CALIDAD', '7', '2', '3', '5'],
      ['IIN83', 'DIS.Y DES. DE NVOS. PROD.', '8', '2', '3', '5'],
      ['IIN84', 'PROD. MAS LIMPIA', '8', '2', '3', '5'],
      ['IIN87', 'TOPICOS DE MANUFAC.', '8', '2', '3', '5'],
      ['IIN86', 'DIS. ANALISIS SIST. PROD. E.', '8', '3', '2', '5'],
      ['IIN85', 'DIS. AUTOMATIZMOS IND.', '8', '2', '4', '6'],
      ['IIN87MC', 'ERGONOMIA APLICADA', '8', '0', '4', '4'],
      ['IIN77MC', 'ING. DE LA CALIDAD', '7', '2', '3', '5'],
      ['IIN83MC', 'ING. DE PRODUCTO', '8', '2', '3', '5'],
      ['IIN84MC', 'PROD. MAS LIMPIA', '8', '2', '3', '5'],
      ['IIN86MC', 'ING. LOGISTICA', '8', '3', '3', '6'],
      ['IIN85MC', 'AUTOMATIZACION', '8', '2', '4', '6'],
      ['IIN67SP', 'ERGONOMIA LABORAL', '6', '0', '4', '4'],
      ['IIN87SP', 'INTRODUCCION A INDUSTRIA 4.0', '8', '0', '4', '4'],
      ['IIN79SP', 'ING. CAL. Y SEIS SIGMA', '7', '2', '2', '4'],
      ['IIN84SP', 'INGENIERIA DE PROD. Y ECOD.', '8', '2', '2', '4'],
      ['IIN77SP', 'SISTEMAS DE AUTOMATIZACION', '7', '2', '3', '5'],
      ['IIN85SP', 'PRODUCCION MAS LIMPIA', '8', '2', '3', '5'],
      ['IIN86SP', 'INGENIERIA LOGISTICA', '8', '2', '3', '5'],
    ];
    $this->seed($subjects, 'II');
  }

  private function seedIAMB()
  {
    $subjects = [
      ['IAMB11', 'QUIMICA INORGANICA', '1', '3', '2', '5'],
      ['IAMB12', 'CALCULO DIFERENCIAL', '1', '3', '2', '5'],
      ['IAMB13', 'DIB. ASIST. POR COMP.', '1', '0', '4', '4'],
      ['IAMB14', 'TALLER DE ETICA', '1', '0', '4', '4'],
      ['IAMB15', 'FUND. DE INVEST.', '1', '2', '2', '4'],
      ['IAMB16', 'BIOLOGIA', '1', '3', '2', '5'],
      ['IAMB21', 'QUIMICA ANALITICA', '3', '3', '3', '6'],
      ['IAMB22', 'ALGEBRA LINEAL', '2', '3', '2', '5'],
      ['IAMB23', 'FISICA', '2', '3', '2', '5'],
      ['IAMB24', 'PROB. Y ESTAD. AMB.', '2', '3', '2', '5'],
      ['IAMB25', 'CALCULO INTEGRAL', '2', '3', '2', '5'],
      ['IAMB26', 'ECOLOGIA', '2', '3', '2', '5'],
      ['IAMB31', 'FUND. QUIM. ORG.', '2', '3', '2', '5'],
      ['IAMB32', 'CALCULO VECTORIAL', '3', '3', '2', '5'],
      ['IAMB33', 'DIS. DE EXP. AMB.', '3', '2', '2', '4'],
      ['IAMB34', 'TERMODINAMICA', '3', '3', '2', '5'],
      ['IAMB35', 'ECONOMIA AMBIENTAL', '3', '3', '0', '3'],
      ['IAMB36', 'BIOQUIMICA', '3', '4', '2', '6'],
      ['IAMB41', 'AN. INSTRUM.', '4', '3', '2', '5'],
      ['IAMB42', 'EC. DIFERENCIALES', '4', '3', '2', '5'],
      ['IAMB43', 'BAL. MATERIA Y ENERG.', '4', '3', '2', '5'],
      ['IAMB44', 'SIST. DE INF. GEOGRAF.', '5', '2', '2', '4'],
      ['IAMB45', 'FISICOQUIMICA I', '4', '3', '2', '5'],
      ['IAMB46', 'MICROBIOLOGIA', '4', '2', '4', '6'],
      ['IAMB51', 'FEN. DE TRANSP.', '5', '3', '2', '5'],
      ['IAMB52', 'DES. SUSTENTABLE', '4', '2', '3', '5'],
      ['IAMB53', 'GEST. AMBIENTAL I', '5', '3', '2', '5'],
      ['IAMB54', 'MEC. DE FLUIDOS', '5', '3', '2', '5'],
      ['IAMB55', 'FISICOQUIMICA II', '5', '3', '2', '5'],
      ['IAMB56', 'TOX. AMBIENTAL', '5', '3', '2', '5'],
      ['IAMB61', 'TALL. DE INVEST. I', '6', '0', '4', '4'],
      ['IAMB62', 'CONTAM. ATMOSFERICA', '6', '3', '2', '5'],
      ['IAMB63', 'GEST. AMBIENTAL II', '6', '2', '2', '4'],
      ['IAMB64', 'ING. DE COSTOS', '6', '2', '2', '4'],
      ['IAMB65', 'GESTION DE RESIDUOS', '6', '3', '3', '6'],
      ['IAMB66', 'COMPONENTES EQ. IND.', '6', '3', '2', '5'],
      ['IAMB71', 'TALL. DE INVEST. II', '7', '0', '4', '4'],
      ['IAMB72', 'POTAB. DE AGUA', '7', '3', '3', '6'],
      ['IAMB73', 'EV. DE IMPAC. AMB.', '7', '2', '3', '5'],
      ['IAMB74', 'FORM. Y EV. PROY.', '8', '3', '2', '5'],
      ['IAMB75', 'REMED. DE SUELOS', '7', '3', '3', '6'],
      ['IAMB76', 'FERT. DE SUELOS', '7', '3', '2', '5'],
      ['IAMB76S', 'EST. DE CALID. DEL AGUA', '7', '3', '2', '5'],
      ['IAMB78S', 'LEG. DEL AGUA EN MEX.', '7', '3', '2', '5'],
      ['IAMB81', 'SEG. E HIG. IND.', '8', '2', '2', '4'],
      ['IAMB82', 'FUND. AGUAS RESIDUALES', '8', '3', '3', '6'],
      ['IAMB83', 'QUIM. Y FIS. DE SUELOS', '8', '1', '4', '5'],
      ['IAMB83S', 'IMPAC.AMB. SIST. ACUIF.A.H.', '8', '3', '2', '5'],
      ['IAMB84', 'CONSERV. DE SUELOS', '8', '3', '2', '5'],
      ['IAMB84S', 'QUIM. Y FIS. DE SUELOS', '8', '1', '4', '5'],
      ['IAMB85', 'MANEJO SUST. DE SUELOS', '8', '4', '1', '5'],
      ['IAMB85S', 'FERT. DE SUELOS', '8', '3', '2', '5'],
      ['IAMB86', 'IMP. DE CAMB. DE USO DE SUELO', '8', '5', '0', '5'],
      ['IAMBT17', 'TUTORIAS 1', '1', '1', '1', '1'],
      ['IAMBT27', 'TUTORIAS 2', '2', '1', '1', '1'],
    ];
    $this->seed($subjects, 'IAMB');
  }

  private function seedIIA()
  {
    $subjects = [
      ['IIA11', 'BIOLOGIA', '1', '3', '2', '5'],
      ['IIA12', 'QUIMICA INORGANICA', '1', '3', '2', '5'],
      ['IIA13', 'CALCULO DIFERENCIAL', '1', '3', '2', '5'],
      ['IIA14', 'TALLER DE ETICA', '1', '0', '4', '4'],
      ['IIA15', 'FUNDAMENTOS DE INVESTIGACION', '1', '2', '2', '4'],
      ['IIA16', 'INT. A LA IND. ALIM.', '1', '2', '1', '3'],
      ['IIA21', 'LAB. QUIM. ANALITICA', '2', '1', '4', '5'],
      ['IIA22', 'QUIMICA ORGANICA', '2', '3', '2', '5'],
      ['IIA23', 'CALCULO INTEGRAL', '2', '3', '2', '5'],
      ['IIA24', 'ALGEBRA LINEAL', '2', '3', '2', '5'],
      ['IIA25', 'PROBABILIDAD Y ESTADISTICA', '2', '2', '2', '4'],
      ['IIA26', 'FUND. DE FISICA', '2', '2', '2', '4'],
      ['IIA31', 'BIOQ. DE ALIM. I', '3', '3', '2', '5'],
      ['IIA32', 'ECUACIONES DIFERENCIALES', '3', '3', '2', '5'],
      ['IIA33', 'TERMODINAMICA', '3', '4', '2', '6'],
      ['IIA34', 'PROGRAMACION', '4', '0', '4', '4'],
      ['IIA35', 'DISEÑOS EXPERIMENTALES', '3', '2', '3', '5'],
      ['IIA41', 'BIOQ. DE ALIM. II', '4', '3', '2', '5'],
      ['IIA42', 'TECNOLOG. DE CONSERV.', '5', '2', '4', '6'],
      ['IIA43', 'FLUJO DE FLUIDOS', '4', '2', '4', '6'],
      ['IIA44', 'MICROBIOLOGIA', '4', '2', '4', '6'],
      ['IIA45', 'ANALISIS DE ALIMENTOS', '3', '2', '4', '6'],
      ['IIA46', 'TALL. DE CTRL. ESTAD. DE PROC.', '4', '0', '4', '4'],
      ['IIA51', 'EV. SENSORIAL', '5', '3', '2', '5'],
      ['IIA52', 'TECNOL. DE FRUTAS, HORT.Y CONF', '5', '2', '4', '6'],
      ['IIA53', 'TALL. DE INVEST. I', '4', '0', '4', '4'],
      ['IIA54', 'OPERAC. DE TRANSF. DE CALOR', '5', '2', '4', '6'],
      ['IIA55', 'DES. SUSTENTABLE', '3', '2', '3', '5'],
      ['IIA56', 'MICROB. DE ALIMENTOS', '5', '2', '4', '6'],
      ['IIA61', 'BIOTECNOLOGIA', '6', '3', '3', '6'],
      ['IIA62', 'GEST. CALIDAD E INOC. ALIM.', '6', '2', '2', '4'],
      ['IIA63', 'INOV. Y DES. DE NVOS. PROD.', '6', '0', '4', '4'],
      ['IIA64', 'OP. DE TRANS. DE MASA', '6', '2', '4', '6'],
      ['IIA65', 'TECNOL. DE CARNICOS', '6', '2', '4', '6'],
      ['IIA66', 'TALL. DE INVEST. II', '5', '0', '4', '4'],
      ['IIA71', 'TECNOL. DE LACTEOS', '7', '2', '4', '6'],
      ['IIA72', 'TECNOL. DE CEREALES Y OLEAG.', '7', '2', '4', '6'],
      ['IIA73', 'DIS. DE PLANTAS ALIMENTARIAS', '7', '2', '3', '5'],
      ['IIA74', 'OPERACIONES MECANICAS', '7', '2', '4', '6'],
      ['IIA75', 'IND. A LA ADMON. Y ECON.', '7', '2', '2', '4'],
      ['IIA76', 'ALIMENTOS TRANSGENICOS', '7', '3', '2', '5'],
      ['IIA76CC', 'BUENAS PRAC. MANEJO ALIM.', '7', '3', '2', '5'],
      ['IIA76CI', 'BUENAS PRAC. MANEJO ALIM.', '7', '3', '2', '5'],
      ['IIA77', 'BUENAS PRAC. MAN. ALIM.', '7', '3', '2', '5'],
      ['IIA77CC', 'ALIMENTOS FUNCIONALES', '7', '3', '2', '5'],
      ['IIA77CI', 'PROC. FERM. EN LA IND. ALIM.', '7', '1', '4', '5'],
      ['IIA81', 'FORMULACION Y EV. DE PROYECTOS', '8', '3', '2', '5'],
      ['IIA82', 'DIS. E IMPART. DE CURSOS PRES.', '8', '1', '3', '4'],
      ['IIA83', 'SIST.CTRL.E INOC. ALIM', '8', '3', '2', '5'],
      ['IIA83CC', 'MAN. INT. PLAG. SECTOR AGROAL.', '8', '3', '2', '5'],
      ['IIA83CI', 'MANEJO INT. PLAG. SECT. AGROAL', '8', '3', '2', '5'],
      ['IIA84', 'NANOTEC. ALIMENTARIA', '8', '3', '2', '5'],
      ['IIA84CC', 'AN. PEL.Y P. CRIT. C. (HACCP)', '8', '3', '2', '5'],
      ['IIA84CI', 'TOP. SEL. IND. ALIM.', '8', '3', '2', '5'],
      ['IIA85', 'MANEJO INT. PLAG SEC. ALIM.', '8', '3', '2', '5'],
      ['IIA85CC', 'TRAZABILIDAD ALIMENTARIA', '8', '4', '1', '5'],
      ['IIA85CI', 'TRAZAB. ALIM.', '8', '4', '1', '5'],
      ['IIAT17', 'TUTORIAS 1', '1', '1', '1', '1'],
      ['IIAT27', 'TUTORIAS 2', '2', '1', '1', '1'],
    ];
    $this->seed($subjects, 'IIA');
  }

  private function seed($subjects, $key)
  {
    $c = Career::where('key', $key)->first();
    foreach ($subjects as $subj) {
      $s = Subject::where('key', $subj[0])->count();

      if ($s == 0) {
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
    }
    $this->command->info("{$key} subjects seeded successfully!");
  }
}
