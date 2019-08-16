@php
switch ($status) {
case '0':
// Registrado
echo "<span class=\"ui olive label\">REGISTRADA</span>";
break;
case '1':
// En revisión
echo "<span class=\"ui yellow label\">REVISIÓN</span>";
break;
case '2':
// Rechazada por coordinador
echo "<span class=\"ui orange label\">RECHAZADA</span>";
break;
case '3':
// Aceptada por coordinador
case '4':
// Aceptada por jefe
echo "<span class=\"ui green label\">ACEPTADA</span>";
break;
case '5':
// Rechazada por jefe
echo "<span class=\"ui red label\">RECHAZADA</span>";
break;
default:
echo "<span class=\"ui black label\">CANCELADA</span>";
}
@endphp
