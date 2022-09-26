<?php

require_once("swap.php");

function dualPivotQuicksort(Array &$a, int $left, int $right) {

    /**
     * ESTRATEGIA:
     * 
     * elije dos valores (pivotes), segun los cuales ordena (particiona) el arreglo:
     *  
     * $left |          PARTE 1           | pivote 1 |                    PARTE 2                      | pivote 2 |           PARTE 3             |  $right
     *          elementos < al pivote 1                   elementos > al pivote 1 && < al pivote 2                      elementos > al pivote 2
     * 
     * Vuelve a hacer la misma operacion, para PARTE 1, PARTE 2 y PARTE 3, hasta que los arreglos tengan 1 elemento (ya van a estar ordenados).
     * No incluye los pivotes en las partes, porque ya estan ordenados.
     * 
     * ***
     * No consideramos los casos donde:
     *  1) los pivotes son iguales entre si
     *  2) los elementos son iguales a los pivotes
     * */   

    if ($left < $right) {

        partition($a, $left, $right, $p1, $p2);

        dualPivotQuicksort($a, $left, $p1 - 1);
        dualPivotQuicksort($a, $p1 + 1, $p2 - 1);
        dualPivotQuicksort($a, $p2 + 1, $right);
    }

}

function partition(Array &$a, int $left, int $right, ?int &$p1, ?int &$p2) { // ?Tipo permite valores null (asi no hay que inicializar p1 y p2 en 0)

    /**
     * Elije dos valores pivote, y recorre el arreglo manteniendo 3 indices:
     * 
     * 1) LESS : comienza en LEFT:
     *  a su izquierda, elementos inferiores al pivote1,
     *  a su derecha, elementos >= al pivote1 y <= al pivote2
     * 
     * 2) GREAT : comienza en RIGHT:
     *  a su izquierda, elementos >= al pivote1 y <= al pivote2
     *  a su derecha, elementos mayores al pivote2
     * 
     * 3) k : comienza en LESS,  es el indice que determina:
     *  - el elemento a posicionar en cada ejecucion.
     *  - el corte del ciclo de ordenamiento (cuando se cruza con GREAT (k > great), ya fueron analizados todos los elementos)
     * */

    /**
     * Para elegir los dos pivotes se ordenan 5 elementos y se eligen como pivotes el 2do y el 4to
     * ( nos aseguramos que haya un elemento menor y otro mayor a los pivotes ¿?)
     * */

    $sixth = (int)($len / 6);
    $m1 = $left + $sixth;
    $m2 = $m1 + $sixth;
    $m3 = $m2 + $sixth;
    $m4 = $m3 + $sixth;
    $m5 = $m4 + $sixth;

    if ($a[$m1] > $a[$m2]) { $x = $a[$m1]; $a[$m1] = $a[$m2]; $a[$m2] = $x; }
    if ($a[$m4] > $a[$m5]) { $x = $a[$m4]; $a[$m4] = $a[$m5]; $a[$m5] = $x; }
    if ($a[$m1] > $a[$m3]) { $x = $a[$m1]; $a[$m1] = $a[$m3]; $a[$m3] = $x; }
    if ($a[$m2] > $a[$m3]) { $x = $a[$m2]; $a[$m2] = $a[$m3]; $a[$m3] = $x; }
    if ($a[$m1] > $a[$m4]) { $x = $a[$m1]; $a[$m1] = $a[$m4]; $a[$m4] = $x; }
    if ($a[$m3] > $a[$m4]) { $x = $a[$m3]; $a[$m3] = $a[$m4]; $a[$m4] = $x; }
    if ($a[$m2] > $a[$m5]) { $x = $a[$m2]; $a[$m2] = $a[$m5]; $a[$m5] = $x; }
    if ($a[$m2] > $a[$m3]) { $x = $a[$m2]; $a[$m2] = $a[$m3]; $a[$m3] = $x; }
    if ($a[$m4] > $a[$m5]) { $x = $a[$m4]; $a[$m4] = $a[$m4]; $a[$m5] = $x; }

    // MUCHO mas lento
    // if ($a[$m1] > $a[$m2]) { swap($a[$m1], $a[$m2]); }
    // if ($a[$m4] > $a[$m5]) { swap($a[$m4], $a[$m5]); }
    // if ($a[$m1] > $a[$m3]) { swap($a[$m1], $a[$m3]); }
    // if ($a[$m2] > $a[$m3]) { swap($a[$m2], $a[$m3]); }
    // if ($a[$m1] > $a[$m4]) { swap($a[$m1], $a[$m4]); }
    // if ($a[$m3] > $a[$m4]) { swap($a[$m3], $a[$m4]); }
    // if ($a[$m2] > $a[$m5]) { swap($a[$m2], $a[$m5]); }
    // if ($a[$m2] > $a[$m3]) { swap($a[$m2], $a[$m3]); }
    // if ($a[$m4] > $a[$m5]) { swap($a[$m4], $a[$m5]); }

    $p1 = $a[$m2];
    $p2 = $a[$m4];
    $a[$m2] = $a[$left];
    $a[$m4] = $a[$right];

    /**
     * El array en LEFT y RIGHT ya está ordenados (p1 y p2),
     * por eso el indice de los elementos < al pivote, empieza de LEFT + 1,
     * y el de los elementos > al pivote de RIGHT - 1.
     * Cuando se hayan posicionado todos los elementos (k > GREAT),
     * se van a posicionar los pivotes (ahora en LEFT y RIGHT) en sus respectivos lugares (antes de LESS, despues de GREAT)
     * */

    /**                                        
     *              LEFT                  LESS            -- k -->           GREAT                 RIGHT
     *           [   $p1   |    < pivot1    |      pivot1 <= && <= pivot2      |    > pivot2    |   $p2   ]
     *                                    P1                                    P2
     *                           PARTE 1                   PARTE 2                   PARTE 3
     * */

    $less = $left + 1;
    $great = $right - 1;

    for ($k = $less; $k <= $great; $k++) {
        
        $x = $a[$k]; // el elemento actual

        /**
         * Posicionar el elemento actual y actualizar los indices correspondientes.
         * */

        if ($x < $p1) { // si es menor del pivote 1
            
            /**
             * intercambiar el elemento actual,
             * con el primer elemento de la parte 2
             * (que queda en la parte 2, siendo superado por k al siguiente ciclo del for)
             * */

            $a[$k] = $a[$less];
            $a[$less++] = $x; // y avanzar less (fue posicionado un elemento menor al pivote1)

            // swap($a[$k], $a[$less]);
            // $less++;

        }
        elseif ($x > $p2) { // si es mayor del pivote 2

            /** 
             * mientras haya elementos mayores a p2, y haya elementos para particionar,
             * retroceder great (el indice de inicio de los elementos mayores a p2)
             * */

            for (; $a[$great] > $p2 && $k < $great; $great--);
            // while ($a[$great] > $p2 && $k < $great) {
            //     $great--;
            // }

            /**
             * intercambiar el elemento actual,
             * con el primer elemento encontrado que no es mayor al pivote2
             * */

            $a[$k] = $a[$great];
            $a[$great--] = $x; // y retroceder great (fue posicionado un elemento mayor al pivote2)

            // swap($a[$k], $a[$great]);
            // $great--;

            /**
             * actualizar el valor de x, (ahora en a[k] esta el primer elemento encontrado que no era mayor a p2)
             * y posicionarlo, si es menor a p1.
             * Si es mayor a p1 (y como era menor a p2) va a quedar en la parte 2 (elementos entre p1 y p2),
             * (es superado por k al siguiente ciclo del for) 
             * */

            $x = $a[$k];

            if ($x < $p1) {

                $a[$k] = $a[$less];
                $a[$less++] = $x;

                // swap($a[$k], $a[$less]);
                // $less++;
            }
        }
        else {
            /**
             * Si no es menor a p1 o mayor a p2,
             * se queda en la parte 2 (elementos entre p1 y p2), 
             * siendo superado por k al siguiente ciclo del for
             *  */
        }
        /**
         * A cada ciclo, tiene 3 opciones:
         *  Intercambia A[LESS] con A[K], Avanza LESS   
         *      ->  el elemento en k era menor a p1, en LESS (lo mas probable) habia un elemento de la PARTE 2 (si LESS == k [todos los elementos analizados fueron menores a p1], se intercambia a si mismo y avanza)
         *  Intercambia A[GREAT] con A[K], Retrocede (1 o mas veces) GREAT  
         *      ->  el elemento en k era mayor a p1, en GREAT habia un elemento todavia no particionado
         *      ->  el nuevo elemento en k es posicionado en la PARTE 1 o en la PARTE 2
         *  Avanza k 
         *      -> el elemento en k era mayor a p1 y menor a p2, y queda en la PARTE 2
         * */
    }

    // posicionar los pivotes
    $a[$left] = $a[$less - 1];
    $a[$less - 1] = $p1;

    $a[$right] = $a[$great + 1];
    $a[$great + 1] = $p2;

    // devolver los indices de los pivotes
    $p1 = $less - 1;
    $p2 = $great + 1;
}