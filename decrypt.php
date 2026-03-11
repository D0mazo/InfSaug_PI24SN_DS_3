<?php
include "rsa_functions.php";

$p=$_POST['p'];
$q=$_POST['q'];
$text=$_POST['text'];

$n=$p*$q;
$phi=($p-1)*($q-1);

$e=3;
while(gcd($e,$phi)!=1){
    $e++;
}

$d=modInverse($e,$phi);

$cipher=encryptRSA($text,$e,$n);

file_put_contents("data/encrypted.txt",$cipher."\n".$n."\n".$e);

?>

    <link rel="stylesheet" href="style.css">

    <div class="container">

    <h2>Encryption Result</h2>

    <div class="result">
        Encrypted Text:<br>
        <?php echo $cipher; ?>
    </div>

    <div class="result">
        Public Key (n,e):<br>
        <?php echo "$n , $e"; ?>
    </div>

    <a href="index.php">Back</a>

    </div><?php
