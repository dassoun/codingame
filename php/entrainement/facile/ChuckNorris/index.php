<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$MESSAGE = stream_get_line(STDIN, 100, "\n");

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));

echo(encoderChaine(chaineEnBinaire($MESSAGE))."\n");

function chaineEnBinaire($chaine) {
    $longueur = strlen($chaine);
    
    $i = 0;
    $chaineBinaire = "";
    while ($i < $longueur) {
        $car = substr($chaine, $i, 1);
        $codeAscii = ord($car);
        $codeBinaire = decbin($codeAscii);
        $codeBinaire = str_pad($codeBinaire, 7, "0", STR_PAD_LEFT);
        
        $chaineBinaire .= $codeBinaire;
        
        $i++;
    }
    
    return $chaineBinaire;
}

function encoderChaine($chaine) {
    
    $longueur = strlen($chaine);
    $i = 0;
    $retour = "";
    $traitementTermine = false;
    while(($i < $longueur) && (!$traitementTermine)) {
        $currentCar = substr($chaine, $i, 1);
        $compteur = 1;
        $j = $i + 1;
        while(($j < $longueur) && (substr($chaine, $j, 1) == $currentCar)) {
            $compteur++;
            $j++;
            
            if ($i + $compteur >= $longueur) {
                $traitementTermine = true;
            }
        }
        
        if ($currentCar == "1") {
            $carEncode = "0";
        } else {
            $carEncode = "00";
        }
        $nbCar = "";
        $nbCar = str_pad($nbCar, $compteur, "0");
        
        if ($i > 0) {
            $retour .= " ";
        }
        
        $retour .= $carEncode." ".$nbCar;
        
        $i = $j;
    }
    return $retour;
}
?>