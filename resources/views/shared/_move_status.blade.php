@php
$statuses = [
'0' => ['teal', 'REGISTRADA'], // Registrada
'1' => ['yellow', 'REVISIÓN'], // En revisión
'2' => ['orange', 'RECHAZADA'], // Rechazada por coordinador
'3' => ['green', 'ACEPTADA'], // Aceptada por coordinador
'4' => ['green', 'ACEPTADA'], // Aceptada por jefe / admin
'5' => ['red', 'RECHAZADA'] // Rechazada por jefe / admin
];
$color = $statuses[$status][0];
$label = $statuses[$status][1];
@endphp

@if(array_key_exists($status, $statuses))
<span class="ui {{ $color }} label">{{ $label }}</span>
@else
<span class="ui black label">CANCELADA</span>
@endif