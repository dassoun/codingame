<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d",
    $N
);
$tab = array();
$tabY = array();
$xMin = 50000;
$xMax = 0;
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%d %d",
        $X,
        $Y
    );
    $tab[] = array($X, $Y);
    $tabY_median[] = $Y;
    if (!isset($tabY[$Y])) {
        $tabY[$Y] = 1;
    } else {
        $tabY[$Y]++;
    }
    if ($X < $xMin) $xMin = $X;
    if ($X > $xMax) $xMax = $X;
}
sort($tabY_median);

// y du cable principal
$nbY = count($tabY);
$yCP = 0;
$nbMax = 0;
if ($nbY <= 2) {
    // y où il y le plus de maisons
    foreach ($tabY as $key => $Y) {
        if ($Y > $nbMax) {
            $nbMax = $Y;
            $yCP = $key;
        }
    }
} else {
    // y median
    $yCP = round(count($tabY_median) / 2);
    $yCP = $tabY_median[$yCP - 1];
}

error_log(var_export("*".$yCP."*", true));

// longueur cable horizontal
$L = $xMax - $xMin;
// Longueur des câbles verticaux
$l = 0;
foreach ($tab as $t) {
    $l += abs($t[1] - $yCP);
}

echo(($L + $l)."\n");
?>