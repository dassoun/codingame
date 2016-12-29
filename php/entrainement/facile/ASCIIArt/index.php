<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d",
    $L
);
fscanf(STDIN, "%d",
    $H
);
$T = stream_get_line(STDIN, 256, "\n");

$tab = array();

$largeur = 27 * $L;
$hauteur = $H;

for($i=0; $i<$hauteur; $i++) {
    $ROW = stream_get_line(STDIN, 1024, "\n");
    $cpt = 0;
    for($j=0; $j<$largeur; $j+=$L) {
        $chaine = substr($ROW, $j, $L);
        $tab[chr(65+($j/$L))][$i] = $chaine;
    }
}

//error_log(var_export($tab, true));

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));
echo(ecrire($T, $tab, $H)."\n");

function ecrire($mot, $tab, $hauteur) {
    $longueur = strlen($mot);
    $retour = '';
    
    for($i=0; $i<$hauteur; $i++) {
        for($j=0; $j<$longueur; $j++) {
            $codeAscii = ord(substr($mot, $j, 1));
            
            if ($codeAscii >= 97 && $codeAscii <= 122) {
                $lettre = chr($codeAscii - 32);
            } else {
                if ($codeAscii >= 65 && $codeAscii <= 90) {
                    $lettre = chr($codeAscii);
                } else {
                    $lettre = chr(91);
                }
            }
            
            $retour .= $tab[$lettre][$i];
        }
        $retour .= "\n";
    }
    return $retour;
}

?>