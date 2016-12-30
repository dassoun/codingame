<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d",
    $W, // width of the building.
    $H // height of the building.
);

$tab_x = array();
$tab_y = array();


fscanf(STDIN, "%d",
    $N // maximum number of turns before game over.
);
fscanf(STDIN, "%d %d",
    $X0,
    $Y0
);

// Tableau de marges
$tab_marge = array(
    'Haut' => 0, 
    'Droite' => 0, 
    'Bas' => 0, 
    'Gauche' => 0
);

error_log(var_export("w: ".$W, true));
error_log(var_export("h: ".$H, true));

$tailleXIni = $W;
$tailleYIni = $H;
$posX = $X0;
$posY = $Y0;

// game loop
while (TRUE)
{
    fscanf(STDIN, "%s",
        $BOMB_DIR // the direction of the bombs from batman's current location (U, UR, R, DR, D, DL, L or UL)
    );
    
    error_log(var_export($BOMB_DIR, true));
    $tab_marge = calculerMarge($X0, $Y0, $W, $H, $BOMB_DIR, $tab_marge);
    error_log(var_export($tab_marge, true));
    
    $tab_deplacement = calculerDeplacement($W, $H, $BOMB_DIR, $tab_marge);
    error_log(var_export($tab_deplacement, true));
    
    $X0 += $tab_deplacement[0];
    $Y0 += $tab_deplacement[1];
    
    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));

    echo($X0." ".$Y0."\n"); // the location of the next window Batman should jump to.
}

function calculerMarge($posX, $posY, $taillePlateauX, $taillePlateauY, $bombDir, $tab_marge) {
    if (strpos($bombDir, 'U' ) !== false) {
        $tab_marge['Bas'] = $taillePlateauY - $posY;
    }
    if (strpos($bombDir, 'R' ) !== false) {
        $tab_marge['Gauche'] = $posX + 1;
    }
    if (strpos($bombDir, 'D' ) !== false) {
        $tab_marge['Haut'] = $posY + 1;
    }
    if (strpos($bombDir, 'L' ) !== false) {
        $tab_marge['Droite'] = $taillePlateauX - $posX;
    }
    
    if ((strpos($bombDir, 'U' ) === false) && (strpos($bombDir, 'D' ) === false)) {
        $tab_marge['Haut'] = $posY;
        $tab_marge['Bas'] = $taillePlateauY - ($posY + 1);
    }
    if ((strpos($bombDir, 'U' ) === false) && (strpos($bombDir, 'D' ) === false)) {
        $tab_marge['Gauche'] = $posX;
        $tab_marge['Droite'] = $taillePlateauX - ($posX + 1);;
    }
    
    return $tab_marge;
}

function calculerDeplacement($taillePlateauX, $taillePlateauY, $bombDir, $tab_marge) {
    $mouvX = 0;
    $mouvY = 0;
    
    $largeur = $taillePlateauX - ($tab_marge['Gauche'] + $tab_marge['Droite']);
    $hauteur = $taillePlateauY - ($tab_marge['Haut'] + $tab_marge['Bas']);
    error_log(var_export("largeur: ".$largeur, true));
    error_log(var_export("hauteur: ".$hauteur, true));
    
    if (strpos($bombDir, 'U' ) !== false) {
        $mouvY = round($hauteur / 2) * (-1);
    }
    if (strpos($bombDir, 'R' ) !== false) {
        $mouvX = round($largeur / 2);
    }
    if (strpos($bombDir, 'D' ) !== false) {
        $mouvY = round($hauteur / 2);
    }
    if (strpos($bombDir, 'L' ) !== false) {
        $mouvX = round($largeur / 2) * (-1);
    }
    
    return array($mouvX, $mouvY);
}
?>