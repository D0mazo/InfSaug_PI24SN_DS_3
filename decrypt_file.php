<?php
include "rsa_functions.php";

if (!isset($_FILES['encryptedFile']) || $_FILES['encryptedFile']['size'] === 0) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failas nebuvo įkeltas!']);
    exit;
}

$content = file_get_contents($_FILES['encryptedFile']['tmp_name']);
$lines   = explode("\n", $content);

$cipher = null;
$n      = null;
$e      = null;

foreach ($lines as $i => $line) {
    $line = trim($line);
    if ($line === 'Užšifruotas tekstas:') {
        $cipher = trim($lines[$i + 1]);
    }
    if ($line === 'Viešasis raktas (n, e):') {
        $parts = explode(',', trim($lines[$i + 1]));
        $n = (int)trim($parts[0]);
        $e = (int)trim($parts[1]);
    }
    // d nebeskaitome iš failo!
}

if ($cipher === null || $n === null || $e === null) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Neteisingas failo formatas!']);
    exit;
}

// d apskaičiuojamas iš n
$factors = factorizeN($n);
if ($factors === null) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Nepavyko faktorizuoti n!']);
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

