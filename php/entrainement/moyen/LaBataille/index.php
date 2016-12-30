<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$tab_valeur = array(
    '2' => 0,
    '3' => 1,
    '4' => 2,
    '5' => 3,
    '6' => 4,
    '7' => 5,
    '8' => 6,
    '9' => 7,
    '10' => 8,
    'J' => 9,
    'Q' => 10,
    'K' => 11,
    'A' => 12
);

$tab_joueur1 = array();
$tab_joueur2 = array();

fscanf(STDIN, "%d",
    $n // the number of cards for player 1
);
for ($i = 0; $i < $n; $i++)
{
    fscanf(STDIN, "%s",
        $cardp1 // the n cards of player 1
    );
    $tab_joueur1[] = $cardp1;
}
//error_log(var_export("Tab Carets J1: ", true));
//error_log(var_export($tab_joueur1, true));
fscanf(STDIN, "%d",
    $m // the number of cards for player 2
);
for ($i = 0; $i < $m; $i++)
{
    fscanf(STDIN, "%s",
        $cardp2 // the m cards of player 2
    );
    $tab_joueur2[] = $cardp2;
}
//error_log(var_export("Tab Carets J2: ", true));
//error_log(var_export($tab_joueur2, true));

$tab_carte = array($tab_joueur1, $tab_joueur2);
//error_log(var_export($tab_carte, true));
$vainqueur = null;
$nbTour = 0;
$decal = 0;

while ($vainqueur === null) {
    $nbTour++;
    
    $tab_resTour = jouerTour($tab_joueur1, $tab_joueur2, $nbTour, $tab_valeur, $decal);
    $tab_joueur1 = $tab_resTour['cartes'][0];
    $tab_joueur2 = $tab_resTour['cartes'][1];
    $decal = $tab_resTour['decal'];
    
    if ($tab_resTour['VainqueurTour'] == 'PAT') {
        $vainqueur = 'PAT';
    }
    if (count($tab_joueur1) == 0) {
        $vainqueur = 2;
    }
    if (count($tab_joueur2) == 0) {
        $vainqueur = 1;
    }
}

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));
if ($vainqueur == 'PAT') {
    echo($vainqueur."\n");
} else {
    echo($vainqueur." ".$nbTour."\n");
}

function jouerTour($tab_carteJ1, $tab_carteJ2, $tour, $tab_valeur, $decal) {
    $vainqueurTour = null;
    $tab_carte = array();
    
    if ($tour == 10) {
        error_log(var_export($tab_carteJ1, true));
        error_log(var_export($tab_carteJ2, true));
    }
    
    while ($vainqueurTour === null) {
        $carte1 = $tab_carteJ1[($tour-1)+$decal];
        $carte2 = $tab_carteJ2[($tour-1)+$decal];
        $valCarte1 = getValeurCarte($tab_carteJ1[($tour-1)+$decal], $tab_valeur);
        $valCarte2 = getValeurCarte($tab_carteJ2[($tour-1)+$decal], $tab_valeur);
        //error_log(var_export($valCarte1, true));
        //error_log(var_export($valCarte2, true));
        
        $tab_carte[0][] = $carte1;
        $tab_carte[1][] = $carte2;
        unset($tab_carteJ1[($tour-1)+$decal]);
        unset($tab_carteJ2[($tour-1)+$decal]);
        
        if ($valCarte1 > $valCarte2) {
            $vainqueurTour = 1;
        } else {
            if ($valCarte1 < $valCarte2) {
                $vainqueurTour = 2;
            } else {
                //error_log(var_export("--- BATAILLE --- / Tour: ".$tour, true));
                //error_log(var_export($carte1." vs ".$carte2, true));
                if ((count($tab_carteJ1) < 4) || (count($tab_carteJ2) < 4)) {
                    $vainqueurTour = "PAT";
                    error_log(var_export("Match nul", true));
                } else {
                    for ($i=0; $i<3; $i++) {
                        $decal++;
                        $carte1 = $tab_carteJ1[($tour-1)+$decal];
                        $carte2 = $tab_carteJ2[($tour-1)+$decal];
                        $tab_carte[0][] = $carte1;
                        $tab_carte[1][] = $carte2;
                        unset($tab_carteJ1[($tour-1)+$decal]);
                        unset($tab_carteJ2[($tour-1)+$decal]);
                    }
                    $decal++;
                }
            }
        }
    }
    
    switch ($vainqueurTour) {
        case 1:
            foreach($tab_carte as $carteJoueur) {
                foreach ($carteJoueur as $carte) {
                    array_push($tab_carteJ1, $carte);
                }
            }
            break;
        case 2:
            foreach($tab_carte as $carteJoueur) {
                foreach ($carteJoueur as $carte) {
                    array_push($tab_carteJ2, $carte);
                }
            }
            break;
        default:
            
            break;
    }
    
    $tab_res = array(
        'VainqueurTour' => $vainqueurTour,
        'cartes' => array($tab_carteJ1, $tab_carteJ2),
        'decal' => $decal
    );
    
    return $tab_res;
}

function getValeurCarte($carte, $tab_valeur) {
    $valeur = $tab_valeur[substr($carte, 0, strlen($carte)-1)];
    
    return $valeur;
}
?>