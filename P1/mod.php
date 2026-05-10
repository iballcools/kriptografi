<?php 

$jamAwal = 8;
$durasi = 50;
$m = 24;

// Hitung jam akhir dengan modulo
$jamAkhir = ($jamAwal + $durasi) % $m;

echo "Jam Awal : " . $jamAwal . "<br>";
echo "Durasi : " . $durasi . "<br>";
echo "Format : " . $m . " Jam<br>";
echo "Jam Akhir : " . $jamAkhir . "<br>";


?>