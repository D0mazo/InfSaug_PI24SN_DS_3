<?php
include "rsa_functions.php";

if (!file_exists("data/encrypted.txt")) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Užšifruotas failas nerastas!']);
    exit;
}

$data  = file_get_contents("data/encrypted.txt");
$lines = explode("\n", trim($data));

$cipher = trim($lines[0]);
$n      = (int)trim($lines[1]);
$e      = (int)trim($lines[2]);
$d      = (int)trim($lines[3]);

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