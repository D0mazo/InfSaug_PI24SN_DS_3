<?php
include "rsa_functions.php";

// Nuskaitymas iš failo
$data  = file_get_contents("data/encrypted.txt");
$lines = explode("\n", trim($data));

$cipher = trim($lines[0]);
$n      = (float)trim($lines[1]);
$e      = (float)trim($lines[2]);
$d      = (float)trim($lines[3]);

// Dešifravimas
$decrypted = decryptRSA($cipher, $d, $n);

// Rezultatai grąžinami kaip JSON
header('Content-Type: application/json');
echo json_encode([
        'cipher'    => $cipher,
        'decrypted' => $decrypted,
        'n'         => $n,
        'e'         => $e,
        'd'         => $d
]);
?>