<?php
include "rsa_functions.php";

$p=$_POST['p'];
$q=$_POST['q'];

// Nuskaityti tekstą iš įkelto failo
$text = file_get_contents($_FILES['textfile']['tmp_name']);

$n=$p*$q;
$phi=($p-1)*($q-1);

$e=3;
while(gcd($e,$phi)!=1){
    $e++;
}

$d=modInverse($e,$phi);

$cipher=encryptRSA($text,$e,$n);

file_put_contents("data/encrypted.txt",$cipher."\n".$n."\n".$e."\n".$d);

?>

<link rel="stylesheet" href="style.css">

<div class="container">

    <h2>Šifravimo Rezultatas</h2>

    <div class="result">
        Užkoduotas tekstas:<br>
        <?php echo $cipher; ?>
    </div>

    <div class="result">
        Viešasis raktas (n,e):<br>
        <?php echo "$n , $e"; ?>
    </div>

    <div class="result">
        Privatusis raktas (d):<br>
        <?php echo $d; ?>
    </div>

    <a href="index.php">Atgal</a>

</div>