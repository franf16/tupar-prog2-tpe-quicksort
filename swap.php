<?php

function swap(&$v1, &$v2) {
    /**
     * Symmetryc array destructuring (https://www.php.net/manual/en/migration71.new-features.php)
     * permite hacer con la sintaxis de array [], lo que antes con list (https://www.php.net/manual/en/function.list.php),
     * asignar variables como si fuesen arrays
     */
    [$v1, $v2] = [$v2, $v1];
}