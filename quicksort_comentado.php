<?php

require_once("swap.php");

function quicksort(Array &$a, int $left, int $right) {

    /**
     * ESTRATEGIA:
     * 
     * elije un valor (pivote), segun el cual ordena (particiona) el arreglo:
     *  
     * $left |          PARTE 1           | $pivote |              PARTE 2             | $right
     *           elementos < al pivote                      elementos > al pivote
     * 
     * vuelve a hacer la misma operacion, para PARTE 1 y PARTE 2, hasta que los arreglos tengan 1 elemento (ya van a estar ordenados).
     * no incluye los pivotes en las partes, porque ya estan ordenados.
     * */    

     if ($left < $right) {

        $pivot = partition($a, $left, $right);
        quicksort($a, $left, $pivot - 1);
        quicksort($a, $pivot + 1, $right);

     }
}

function partition(Array &$a, int $left, int $right) {

    /**
     * Elije un valor pivote, y recorre el arreglo manteniendo dos indices:
     * LESS : comienza en LEFT, y a su izquierda hay elementos inferiores al pivote
     * GREAT : comienza en RIGHT, y a su derecha hay elementos superiores al pivote
     */

    /**
     * Como pivote elejimos la mediana de tres (inicio, mitad, fin)
     */
    $middle = (int)($left + ($right - $left) / 2);

    if ($a[$left] > $a[$middle])
        swap($a[$left], $a[$middle]);
    if ($a[$middle] > $a[$right])
        swap($a[$middle], $a[$right]);
    if ($a[$left] > $a[$middle])
        swap($a[$left], $a[$middle]);
    
    $pivot = $a[$middle];

    /**
     * Como el primer y ultimo elemento ya estan ordenados,
     * LESS y GREAT comienzan corridos de uno
     * ( en los for avanza antes de ver si el elemento en less/great es menor/mayor,    )
     * ( porque ya van a haber sido ordenados por la mediana de tres, o el swap         )
     */
    
     /**
      *            ->LESS           PIVOT          GREAT<-
      * [    $left    |    < pivot    |    > pivot    |    $right    ]
      */

    $less = $left;
    $great = $right;

    /**
     * Mientras haya elementos para ordenar (no se crucen los indices)
     */
     while (true) {

        for (++$less; $a[$less] < $pivot; $less++);
        // LESS avanza, mientras haya elementos < al pivote
        // do {
        //     $less = $less + 1;
        // } while($a[$less] < $pivot);

        for (--$great; $a[$great] > $pivot; $great--); 
        // GREAT retrocede, mientras haya elementos > al pivote
        // do {
        //     $great = $great - 1;
        // } while($a[$great] > $pivot);

        if ($less >= $great) { // si se cruzan los indices, termina
        return $great;
        }

        /**
         * intercambiar a[LESS] y a[GREAT]
         * ( en LESS hay un elemento que no es menor al pivote  )
         * ( en GREAT hay un elemento que no es mayor al pivote )
         */

        $aux = $a[$less];
        $a[$less] = $a[$great];
        $a[$great] = $aux;
        // swap($a[$less], $a[$great]); // MUCHO mas lento
     }
}