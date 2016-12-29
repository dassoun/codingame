<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$tab_point = array();
$tab_lien = array();
$tab_sortie = array();

fscanf(STDIN, "%d %d %d",
    $N, // the total number of nodes in the level, including the gateways
    $L, // the number of links
    $E // the number of exit gateways
);

for ($i = 0; $i < $L; $i++)
{
    fscanf(STDIN, "%d %d",
        $N1, // N1 and N2 defines a link between these nodes
        $N2
    );
    if ($N1 < $N2) {
        $tab_lien[] = array($N1, $N2);
    } else {
        $tab_lien[] = array($N2, $N1);
    }
}

for ($i = 0; $i < $E; $i++)
{
    fscanf(STDIN, "%d",
        $EI // the index of a gateway node
    );
    $tab_sortie[] = $EI;
}

// game loop
while (TRUE)
{
    fscanf(STDIN, "%d",
        $SI // The index of the node on which the Skynet agent is positioned this turn
    );

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));
    
    // Calcul du nombre de liens vers la sortie
    $tab_nbLien = array();
    foreach($tab_sortie as $sortie) {
        $tab_nbLien[$sortie] = 0;
        foreach ($tab_lien as $lien) {
            if (($lien[0] == $sortie) || ($lien[1] == $sortie)) {
                $tab_nbLien[$sortie]++;
            }
        }
    }
    
    $tab_chemin = array();
    $bon_chemin = array();
    $tab_tousChemins = array();
    foreach ($tab_sortie as $sortie) {
        if ($tab_nbLien[$sortie] > 0) {
            $tab_chemin = getChemin($SI, $sortie, $tab_lien);
            $bon_chemin[$sortie] = getBonChemin($tab_chemin, $sortie);
        }
    }
    
    // On essaie de bloquer en priorité la sortie qui a le plus de liens => on la détermine
    $nbLienMax = 0;
    $sortiePrioritaire = 100000;
    foreach ($tab_nbLien as $key => $nbLien) {
        if ($nbLien > $nbLienMax) {
            $nbLienMax = $nbLien;
            $sortiePrioritaire = $key;
        }
    }
    
    $cheminFinal = array();
    $nbPointMin = 100000;
    $nbPoint;
    foreach ($bon_chemin as $key => $chemin) {
        $nbPoint = count($chemin);
        if ($nbPoint < $nbPointMin) {
            $nbPointMin = $nbPoint;
            $cheminFinal = $chemin;
        } else {
            if ($nbPointMin == $nbPoint) {
                if ($sortiePrioritaire == $key) {
                    $cheminFinal = $chemin;
                }
            }
        }
    }
    
    
    // Couper les 1ers liens du chemin
    $A = $cheminFinal[0];
    $B = $cheminFinal[1];
    
    $tab_lien = supprLien($A, $B, $tab_lien);
    
    
    echo($A." ".$B."\n"); // Example: 0 1 are the indices of the nodes you wish to sever the link between
}



function getBonChemin($tab_chemin, $arrivee) {
    foreach($tab_chemin as $chemin) {
        if (in_array($arrivee, $chemin)) {
            return $chemin;
        }
    }
    return false;
}

function supprLien($A, $B, $tab_lien) {
    $trouve = false;
    
    if ($B < $A) {
        $C = $A;
        $A = $B;
        $B = $C;
    }
    foreach($tab_lien as $key => $lien) {
        if (($lien[0] == $A) && ($lien[1] == $B)) {
            $trouve = true;
            unset($tab_lien[$key]);
        }
    }
    
    return $tab_lien;
}

function getChemin($depart, $arrivee, $tab_lien) {
    $cheminTrouve = false;
    $cheminExiste = true;
    $nbPoint = 1;
    $tab_point[$nbPoint][] = array($depart);
    
    while ($cheminExiste && !$cheminTrouve) {
        
        $tab_chemin_temp = array();
        foreach($tab_point[$nbPoint] as $key => $tab_pt) {
            foreach($tab_pt as $point) {
                $tab_pointSuivant = getPointsSuivants($point, $tab_lien);
                    foreach($tab_pointSuivant['points'] as $nouveauPoint) {
                        //error_log(var_export($nouveauPoint, true));
                        $tab_temp = $tab_pt;
                        //error_log(var_export($tab_point, true));
                        //error_log(var_export("    ", true));
                        array_push($tab_temp, $nouveauPoint);
                        //error_log(var_export($tab_temp, true));
                        $tab_chemin_temp[] = $tab_temp;
                        //$tab_point[$nbPoint+1][] = $tab_temp;
                        
                        if ($nouveauPoint == $arrivee) {
                            $cheminTrouve = true;
                        }
                    }
                    
                    // On supprime les liens deja employes
                    foreach($tab_pointSuivant['liensASuppr'] as $lienASuppr) {
                        //error_log(var_export($tab_lien[$lienASuppr], true));
                        unset($tab_lien[$lienASuppr]);
                    }
            }
        }
        
        if (count($tab_chemin_temp) > 0) {
            $nbPoint++;
            
            foreach ($tab_chemin_temp as $chemin_temp) {
                $tab_point[$nbPoint][] = $chemin_temp;
            }
        }
        
    }
    return $tab_point[$nbPoint];
}


function getPointsSuivants($depart, $tab_lien) {
    $tab_pointSuivant = array();
    $tab_lienASuppr = array();
    
    //error_log(var_export($tab_lien, true));
    foreach ($tab_lien as $key => $lien) {
        $indicePosCourrante = -1;
        
        if ($lien[0] == $depart) {
            $indicePosCourrante = 0;
            $indicePointDest = 1;
        } else {
            if ($lien[1] == $depart) {
                $indicePosCourrante = 1;
                $indicePointDest = 0;
            }
        }
        if ($indicePosCourrante != -1) {
            $tab_pointSuivant[] = $lien[$indicePointDest];
            $tab_lienASuppr[] = $key;
        }
    }

    $tab_retour = array('points' => $tab_pointSuivant, 'liensASuppr' => $tab_lienASuppr);
    
    return $tab_retour;
}
?>