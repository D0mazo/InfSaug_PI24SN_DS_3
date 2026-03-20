<?php

// Euklido algoritmas
function gcd($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

// Išplėstinis Euklido algoritmas
function extended_gcd($a, $b) {
    if ($a == 0)
        return [$b, 0, 1];

    list($g, $x1, $y1) = extended_gcd($b % $a, $a);

    $x = $y1 - intval($b / $a) * $x1;
    $y = $x1;

    return [$g, $x, $y];
}

// Modulinis atvirkštinis
function modInverse($e, $phi) {
    list($g, $x, $y) = extended_gcd($e, $phi);
    if ($g != 1) return null;
    return ($x % $phi + $phi) % $phi;
}

// Greitas modulinis kėlimas laipsniu (be bibliotekų)
function powerMod($base, $exp, $mod) {
    $result = 1;
    $base = $base % $mod;
    while ($exp > 0) {
        if ($exp % 2 == 1) {
            $result = intval(fmod($result * $base, $mod));
        }
        $exp = intval($exp / 2);
        $base = intval(fmod($base * $base, $mod));
    }
    return $result;
}

// Šifravimas
function encryptRSA($text, $e, $n) {
    $result = [];
    for ($i = 0; $i < strlen($text); $i++) {
        $ascii    = ord($text[$i]);
        $result[] = powerMod($ascii, $e, $n);
    }
    return implode(" ", $result);
}

// Dešifravimas
function decryptRSA($cipher, $d, $n) {
    $nums = explode(" ", trim($cipher));
    $text = "";
    foreach ($nums as $num) {
        if ($num === "") continue;
        $ascii = powerMod((int)$num, (int)$d, (int)$n);
        $text .= chr($ascii);
    }
    return $text;
}

?>