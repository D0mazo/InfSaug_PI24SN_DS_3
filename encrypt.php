<?php
include "rsa_functions.php";

$p = (int)$_POST['p'];
$q = (int)$_POST['q'];

if (isset($_FILES['textfile']) && $_FILES['textfile']['size'] > 0) {
    $text = file_get_contents($_FILES['textfile']['tmp_name']);
} else {
    $text = $_POST['text'];
}

if (!isPrime($p) || !isPrime($q)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'P ir Q turi būti pirminiai skaičiai!']);
    exit;
}

$n   = $p * $q;
$phi = ($p - 1) * ($q - 1);

if ($n <= 127) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'P × Q turi būti didesnis nei 127!']);
    exit;
}

$e = 3;
while (gcd($e, $phi) != 1) {
    $e += 2;
}

$d = modInverse($e, $phi);
$cipher = encryptRSA($text, $e, $n);

if (!is_dir("data")) mkdir("data");
file_put_contents("data/encrypted.txt", $cipher . "\n" . $n . "\n" . $e . "\n" . $d);

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