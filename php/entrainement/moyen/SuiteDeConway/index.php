<?php
fscanf(STDIN, "%d",
    $R
);
fscanf(STDIN, "%d",
    $L
);

$retour = "";

$t = conway($R, $L);

$s = "";
foreach($t as $c) {
    $s .= $c." ";
}
$s = substr($s, 0, strlen($s)-1);

echo("$s\n");


function ligneSuivante($t) {
    $i = 0;
    $retour = "";
    while ($i < count($t)) {
        $j = $i + 1;
        $memeCar = true;
        $cpt = 1;
        $car = $t[$i];
        while ($j < count($t) && $memeCar) {
            if ($t[$i] == $t[$j]) {
                $cpt++;
                $j++;
            } else {
                $memeCar = false;
            }
        }
        $retour[] = $cpt;
        $retour[] = $t[$i];
        $i = $j;
    }
    
    return $retour;
}

function conway($n, $nLigne) {
    $retour = "";
    if ($nLigne == 1) {
        $retour = array($n);
    } else {
        $retour = ligneSuivante(conway($n, $nLigne-1));
    }
    
    return $retour;
}
?>