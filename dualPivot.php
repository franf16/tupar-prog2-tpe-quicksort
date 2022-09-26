<?php

function dualPivotQuicksort(Array &$a, int $left, int $right) {

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

        // median of 5
        $sixth = (int)($len / 6);
        $m1 = $left + $sixth;
        $m2 = $m1 + $sixth;
        $m3 = $m2 + $sixth;
        $m4 = $m3 + $sixth;
        $m5 = $m4 + $sixth;
        
        // 5-element sorting network o__O
        if ($a[$m1] > $a[$m2]) { $x = $a[$m1]; $a[$m1] = $a[$m2]; $a[$m2] = $x; }
        if ($a[$m4] > $a[$m5]) { $x = $a[$m4]; $a[$m4] = $a[$m5]; $a[$m5] = $x; }
        if ($a[$m1] > $a[$m3]) { $x = $a[$m1]; $a[$m1] = $a[$m3]; $a[$m3] = $x; }
        if ($a[$m2] > $a[$m3]) { $x = $a[$m2]; $a[$m2] = $a[$m3]; $a[$m3] = $x; }
        if ($a[$m1] > $a[$m4]) { $x = $a[$m1]; $a[$m1] = $a[$m4]; $a[$m4] = $x; }
        if ($a[$m3] > $a[$m4]) { $x = $a[$m3]; $a[$m3] = $a[$m4]; $a[$m4] = $x; }
        if ($a[$m2] > $a[$m5]) { $x = $a[$m2]; $a[$m2] = $a[$m5]; $a[$m5] = $x; }
        if ($a[$m2] > $a[$m3]) { $x = $a[$m2]; $a[$m2] = $a[$m3]; $a[$m3] = $x; }
        if ($a[$m4] > $a[$m5]) { $x = $a[$m4]; $a[$m4] = $a[$m5]; $a[$m5] = $x; }


        // pivot values
        $p1 = $a[$m2];
        $p2 = $a[$m4];
        $a[$m2] = $a[$left];
        $a[$m4] = $a[$right];

        $less = $left + 1;
        $great = $right - 1;

        // sort
        for ($k = $less; $k <= $great; $k++) {

            $x = $a[$k];

            if ($x < $p1) {

                $a[$k] = $a[$less];
                $a[$less++] = $x;
            }
            elseif ($x > $p2) {

                for (; $a[$great] > $p2 && $k < $great; $great--);
                
                $a[$k] = $a[$great];
                $a[$great--] = $x;
                
                $x = $a[$k];

                if ($x < $p1) {

                    $a[$k] = $a[$less];
                    $a[$less++] = $x;
                }
            }
        }

        
        $a[$left] = $a[$less - 1];
        $a[$less - 1] = $p1;

        $a[$right] = $a[$great + 1];
        $a[$great + 1] = $p2;

        // pivot indexes
        // $p1 = $less - 1;
        // $p2 = $great + 1;

        dualPivotQuicksort($a, $left, $less - 2);
        dualPivotQuicksort($a, $less, $great);
        dualPivotQuicksort($a, $great + 2, $right);
    }
}