<?php
include "rsa_functions.php";

$p = (float)$_POST['p'];
$q = (float)$_POST['q'];

// Tekstas iš failo arba įvesties
if (isset($_FILES['textfile']) && $_FILES['textfile']['size'] > 0) {
    $text = file_get_contents($_FILES['textfile']['tmp_name']);
} else {
    $text = $_POST['text'];
}

// RSA parametrų skaičiavimas
$n   = $p * $q;
$phi = ($p - 1) * ($q - 1);

// Viešojo rakto radimas
$e = 3;
while (gcd($e, $phi) != 1) {
    $e++;
}

// Privataus rakto radimas (išplėstinis Euklido)
$d = modInverse($e, $phi);

// Šifravimas
$cipher = encryptRSA($text, $e, $n);

// Saugojimas į failą
if (!is_dir("data")) mkdir("data");
file_put_contents("data/encrypted.txt", $cipher . "\n" . $n . "\n" . $e . "\n" . $d);

// Rezultatai grąžinami kaip JSON
header('Content-Type: application/json');
echo json_encode([
        'cipher' => $cipher,
        'n'      => $n,
        'e'      => $e,
        'd'      => $d,
        'phi'    => $phi,
        'text'   => $text
]);
?>