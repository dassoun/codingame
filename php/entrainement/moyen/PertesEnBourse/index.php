<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d",
    $n
);
$valRef = 0;
$tab = array();
$inputs = fgets(STDIN,32*$n);
$inputs = explode(" ",$inputs);
for ($i = 0; $i < $n; $i++)
{
    $v = intval($inputs[$i]);
    $tab[] = $v;
}

error_log(var_export($tab, true));

$i = 0;
$valRef = $tab[$i];
$perte = 0;
while ($i < (count($tab) - 1)) {
    $j = $i + 1;
    while (($j <= count($tab) - 1) && ($tab[$j] < $valRef)) {
        if (($tab[$j] - $valRef) < $perte) {
            $perte = $tab[$j] - $valRef;
        }
        $j++;
    }
    $valRef = $tab[$j];
    $i = $j;
}

echo($perte."\n");
?>