<?php

// require_once "dualPivot_comentaod.php";
// require_once "quicksort_comentado.php";
require_once "dualPivot.php";
require_once "quicksort.php";


$time1; $abs2; $time1; $abs1; 
$a = $b = array();
$primera = true;
$bienQUICK = $malQUICK = $bienRUSO = $malRUSO = 0;

for ($i = 0; $i < 10; $i++) {
    echo "\n--- $i ---\n";
    $a = arrRand();
    $b = $a;

    // $b = arrRand();

    $time2 = -microtime(true);
    dualPivotQuicksort($b, 0, count($b) - 1);
    $time2 += microtime(true);
    echo "dualPivot: $time2\n";
    $abs2 += $time2;

    if ($primera)
        print_r($b);

    // $b = $a;
    $c = $a;

    $time1 = -microtime(true);
    quicksort($c, 0, count($b) - 1);
    $time1 += microtime(true);
    echo "quicksort: $time1\n";
    $abs1 += $time1;

    if ($primera)
        print_r($b);

    $diff = $time2 - $time1;
    (array_diff($a, $b) ? $malRUSO++ : $bienRUSO++);
    (array_diff($a, $c) ? $malQUICK++ : $bienQUICK++);
    echo "diff: $diff\n---------\n";
    
    unset($a);
    unset($b);
    unset($c);
    $primera = $primera ? false : false;
}
echo "promedio dual pivot: ".$abs2/$i."\n";
echo "promedio quicksort: ".$abs1/$i."\n";
echo "RUSO: bien : $bienRUSO , mal : $malRUSO\n";
echo "QUICK: bien : $bienQUICK , mal : $malQUICK";

function arrRand() {
    // $rango = 10000000;
    $rango = 500;

    $a = array();
    // for ($i = 0; $i < 500000; $i++) {
    for ($i = 0; $i < 50; $i++) {
        $a[] = rand(-$rango, $rango);
    }
    return $a;
}
