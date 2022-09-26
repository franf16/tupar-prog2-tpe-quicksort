<?php

function quicksort(Array &$a, int $left, int $right) {

    if ($left < $right) {

        $len = $right - $left;
        
        if ($len < 17) { // en arrays chicos usar insercion
            for ($i = $left + 1; $i <= $right; $i++) {
                for ($j = $i; $j > $left && $a[$j] < $a[$j - 1]; $j--) {
                    $aux = $a[$j - 1];
                    $a[$j - 1] = $a[$j];
                    $a[$j] = $aux;
                }
            }
            return;
        }
    
        // median of 3
        $middle = (int)($left + ($right - $left) / 2);
        
        // 3-element sorting network u__u 
        if ($a[$left] > $a[$middle]) { $aux = $a[$left]; $a[$left] = $a[$middle]; $a[$middle] = $aux; }
        if ($a[$middle] > $a[$right]) { $aux = $a[$middle]; $a[$middle] = $a[$right]; $a[$right] = $aux; }
        if ($a[$left] > $a[$middle]) { $aux = $a[$left]; $a[$left] = $a[$middle]; $a[$middle] = $aux; }
        
        $pivot = $a[$middle]; // valor pivote

        $less = $left;
        $great = $right;

        // sort
        while ($less < $great) {

            for (++$less; $a[$less] < $pivot; $less++);
            for (--$great; $a[$great] > $pivot; $great--); 

            if ($less < $great) {

                $aux = $a[$less];
                $a[$less] = $a[$great];
                $a[$great] = $aux;
            }

        }

        $pivot = $great; // indice pivote

        // recursion
        quicksort($a, $left, $pivot);
        quicksort($a, $pivot + 1, $right);
    }
}