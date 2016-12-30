<?php

$tab_1 = array('e', 'a', 'i', 'o', 'n', 'r', 't', 'l', 's', 'u');
$tab_2 = array('d', 'g');
$tab_3 = array('b', 'c', 'm', 'p');
$tab_4 = array('f', 'h', 'v', 'w', 'y');
$tab_5 = array('k');
$tab_8 = array('j', 'x');
$tab_10 = array('q', 'z');


fscanf(STDIN, "%d",
    $N
);
$tab_mot = array();
for ($i = 0; $i < $N; $i++)
{
    $W = stream_get_line(STDIN, 30, "\n");
    $tab_mot[] = $W;
}
$tab_lettre = array();
$LETTERS = stream_get_line(STDIN, 8, "\n");


$scoreMax = 0;
$motMax = "";
foreach($tab_mot as $mot) {
    $tab_lettre = array();
    $tab_lettre = str_split($LETTERS);
    $trouve = true;
    $score = 0;
    $i = 0;
    $t = str_split($mot);
    while($trouve && ($i < count($t))) {
        $indice = array_search($t[$i], $tab_lettre);
        if ($indice === false) {
            $trouve = false;
            $score = 0;
        } else {
            if (in_array($t[$i], $tab_1)) $score += 1;
            elseif (in_array($t[$i], $tab_2)) $score += 2;
            elseif (in_array($t[$i], $tab_3)) $score += 3;
            elseif (in_array($t[$i], $tab_4)) $score += 4;
            elseif (in_array($t[$i], $tab_5)) $score += 5;
            elseif (in_array($t[$i], $tab_8)) $score += 8;
            elseif (in_array($t[$i], $tab_10)) $score += 10;
            
            unset($tab_lettre[$indice]);
        }
        $i++;
    }
    if ($trouve && $score > $scoreMax) {
        $scoreMax = $score;
        $motMax = $mot;
    }
}

echo("$motMax\n");
?>