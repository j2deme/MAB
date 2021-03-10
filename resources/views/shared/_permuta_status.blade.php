@php
$statuses = [
'0' => ['teal', 'REGISTRADA'],
'1' => ['olive','PRE AUTORIZADA'],
'2' => ['yellow', 'REVISIÓN'],
'3' => ['green', 'ACEPTADA'],
'4' => ['red', 'RECHAZADA']
];
$label = $statuses[$status][1];

//data-content=\"$label\"
if(array_key_exists($status, $statuses)){
echo "<span class=\"ui {$statuses[$status][0]} label\">{$label}</span>";
} else {
echo "<span class=\"ui black label\">CANCELADA</span>";
}
@endphp
