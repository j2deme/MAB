@php
$statuses = [
'0' => ['teal', 'REGISTRADA'], // Registrada
'1' => ['yellow', 'REVISIÓN'], // En revisión
'2' => ['orange', 'RECHAZADA'], // Rechazada por coordinador
'3' => ['green', 'ACEPTADA'], // Aceptada por coordinador
'4' => ['green', 'ACEPTADA'], // Aceptada por jefe / admin
'5' => ['red', 'RECHAZADA'] // Rechazada por jefe / admin
];

if(array_key_exists($status, $statuses)){
echo "<span class=\"ui {$statuses[$status][0]} label\" data-content=\"{$statuses[$status][1]}\">{$status}</span>";
} else {
echo "<span class=\"ui black label\" data-content=\"CANCELADA\">{$status}</span>";
}
@endphp
