<?php
include "rsa_functions.php";

if (!file_exists("data/encrypted.txt")) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Serverio failas nerastas! Pirmiausia užšifruokite tekstą.']);
    exit;
}

$data  = file_get_contents("data/encrypted.txt");
$lines = explode("\n", trim($data));

$cipher = trim($lines[0]);
$n      = (int)trim($lines[1]);
$e      = (int)trim($lines[2]);


// randame p ir q
$factors = factorizeN($n);
if ($factors === null) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Nepavyko rasti n!']);
    exit;
}

$p   = $factors[0];
$q   = $factors[1];
$phi = ($p - 1) * ($q - 1);
$d   = modInverse($e, $phi);

$decrypted = decryptRSA($cipher, $d, $n);

header('Content-Type: application/json');
echo json_encode([
    'cipher'    => $cipher,
    'decrypted' => $decrypted,
    'n'         => $n,
    'e'         => $e,
    'd'         => $d
]);
?>