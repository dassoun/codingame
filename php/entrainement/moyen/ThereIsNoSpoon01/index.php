<?php
/**
 * Don't let the machines win. You are humanity's last hope...
 **/

fscanf(STDIN, "%d",
    $width // the number of cells on the X axis
);
fscanf(STDIN, "%d",
    $height // the number of cells on the Y axis
);
$tab_plateau = array();
for ($i = 0; $i < $height; $i++)
{
    $line = stream_get_line(STDIN, 31, "\n"); // width characters, each either 0 or .
    //error_log(var_export("ligne: ".$line, true));
    $tab_temp = array();
    for ($j=0; $j<$width; $j++) {
        //error_log(var_export($j." ".$i." ".substr($line, $j, 1), true));
        $tab_temp[] = substr($line, $j, 1);
        //error_log(var_export(substr($line, $j, 1), true));
    }
    $tab_plateau[] = $tab_temp;
    //error_log(var_export($tab_plateau, true));
}


for ($i = 0; $i<$height; $i++) {
    $chaine = "";
    for ($j=0; $j<$width; $j++) {
        if ($tab_plateau[$i][$j] == "0") {
            $xDroite = xVoisinDroite($j, $i, $width, $height, $tab_plateau);
            
            $yBas = yVoisinBas($j, $i, $width, $height, $tab_plateau);
            
            $affichage = $j." ".$i;
            
            if ($xDroite >= 0) {
                $affichage .= " ".$xDroite." ".($i);
            } else {
                $affichage .= " -1 -1";
            }
            if ($yBas >= 0) {
                $affichage .= " ".($j)." ".$yBas;
            } else {
                $affichage .= " -1 -1";
            }
            
            // Write an action using echo(). DON'T FORGET THE TRAILING \n
            // To debug (equivalent to var_dump): error_log(var_export($var, true));
            
            echo($affichage."\n"); // Three coordinates: a node, its right neighbor, its bottom neighbor
        }
        $chaine .= " ".$tab_plateau[$i][$j];
    }
    //error_log(var_export($chaine, true));
    //error_log(var_export("(".$j.", ".$i.") droite: ".$droite."bas: ".$bas, true));
}


// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));

//echo($affichage."\n"); // Three coordinates: a node, its right neighbor, its bottom neighbor

function xVoisinDroite($x, $y, $largeurPlateau, $hauteurPlateau, $tab_plateau) {
    //error_log(var_export("xVoisinDroite(".$x.", ".$y.", ".$largeurPlateau.", ".$hauteurPlateau.")", true));
    //error_log(var_export($tab_plateau, true));
    $xRetour = -1;
    $i = $x + 1;
    while (($i < $largeurPlateau) && ($xRetour == -1)) {
        //error_log(var_export("i: ".$i.", y: ".$y." => ".$tab_plateau[$y][$i], true));
        if ($tab_plateau[$y][$i] == "0") {
            $xRetour = $i;
        }
        $i++;
    }
    
    return $xRetour;
}

function yVoisinBas($x, $y, $largeurPlateau, $hauteurPlateau, $tab_plateau) {
    $yRetour = -1;
    $i = $y + 1;
    while (($i < $hauteurPlateau) && ($yRetour == -1)) {
        if ($tab_plateau[$i][$x] == "0") {
            $yRetour = $i;
        }
        $i++;
    }
    
    return $yRetour;
}
?>