<?php
include "rsa_functions.php";

$data = file_get_contents("data/encrypted.txt");
$lines = explode("\n", trim($data));

$cipher = $lines[0];
$n = intval($lines[1]);
$e = intval($lines[2]);

$phi_guess = null;
$d = null;

// Rasti d reikia p ir q - tad saugome ir juos
// Geriau faile saugoti ir d privatųjį raktą

?>

<link rel="stylesheet" href="style.css">

<div class="container">

    <h2>Dešifravimo Rezultatas</h2>

    <div class="result">
        Užkoduotas tekstas:<br>
        <?php echo $cipher; ?>
    </div>

    <a href="index.php">Atgal</a>

</div>