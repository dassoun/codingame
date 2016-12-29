<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d",
    $N
);

$tab_puissance = array();
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%d",
        $Pi
    );
    $tab_puissance[] = $Pi;
}

$ecartMin = 9999999999999999;
asort($tab_puissance);

$tab_trie = array();
foreach($tab_puissance as $p) {
    $tab_trie[] = $p;
}

for ($i=1; $i<$N; $i++){
    $p1 = $tab_trie[$i-1];
    $p2 = $tab_trie[$i];
    
    $ecart = $p2 - $p1;
    if ($ecart < $ecartMin) {
        $ecartMin = $ecart;
    }
}


// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));

echo($ecartMin."\n");
?>