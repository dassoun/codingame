<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d",
    $N
);
fscanf(STDIN, "%d",
    $C
);
$tab = array();
$somme = 0;
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%d",
        $B
    );
    $tab[] = $B;
    $somme += $B;
}

if ($C > $somme) {
    echo("IMPOSSIBLE\n");
} else {
    $cpt = 0;
    $somme = 0;
    while ($somme < $C) {
        $cpt++;
        $montantMin = 1000000;
        foreach($tab as $key => $budget) {
            if ($budget < $montantMin) {
                $montantMin = $budget;
                $indiceASuppr = $key;
            }
        }
        $montantParPersonne = floor(($C - $somme) / count($tab));
        
        // Montant min inférieur à la moyenne
        if ($montantMin <= $montantParPersonne){
            $somme += $montantMin;
            unset($tab[$indiceASuppr]);
            echo $montantMin."\n";
        } else {
            // pb d'arrondi
            if ($montantParPersonne < ($C - $somme) / count($tab)){
                unset($tab[$indiceASuppr]);
                $somme += $montantParPersonne;
                
                echo($montantParPersonne."\n");
            } else {
                // pas de pb d'arrondi
                for($i=0;$i<count($tab)-1;$i++) {
                    $somme += $montantParPersonne;
                    
                    echo($montantParPersonne."\n");
                    //unset($tab[$indiceASuppr]);
                }
                echo(($C - $somme)."\n");
                $somme = $C;
            }
        }
    }
}
?>