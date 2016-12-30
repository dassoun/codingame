<?php
$tab_dico = array();

fscanf(STDIN, "%d %d",
    $L,
    $H
);
$tab_temp = array();
for ($i = 0; $i < $H; $i++)
{
    fscanf(STDIN, "%s",
        $numeral
    );
    $tab_temp = str_split($numeral, $L);
    foreach($tab_temp as $key => $ligne){
        $tab_dico[$key][$i] = $ligne;
    }
}
//error_log(var_export($tab_dico, true));
//error_log(var_export(count($tab_dico), true));
//error_log(var_export(getDecimal(array('.oo.','o..o','.oo.','....'), $tab_dico, $H), true));
//error_log(var_export(getDecimal(array('oooo','____','____','____'), $tab_dico, $H), true));
//error_log(var_export(getDecimal($tab_dico[5], $tab_dico, $H), true));
//error_log(var_export(getDecimal($tab_dico[18], $tab_dico, $H), true));


fscanf(STDIN, "%d",
    $S1
);
$tab_nombre1 = array();
for ($i = 0; $i < $S1; $i++)
{
    fscanf(STDIN, "%s",
        $num1Line
    );
    $tab_nombre1[floor($i/$H)][] = $num1Line;
}
fscanf(STDIN, "%d",
    $S2
);
$tab_nombre2 = array();
for ($i = 0; $i < $S2; $i++)
{
    fscanf(STDIN, "%s",
        $num2Line
    );
    $tab_nombre2[floor($i/$H)][] = $num2Line;
}
fscanf(STDIN, "%s",
    $operation
);


//error_log(var_export(count($tab_nombre1), true));

$nbPuiss = count($tab_nombre1) - 1;
$n1 = 0;
foreach($tab_nombre1 as $nombre1){
    $n1 += getDecimal($nombre1, $tab_dico, $H) * pow(20, $nbPuiss);
    $nbPuiss--;
}
//error_log(var_export($n1, true));
$nbPuiss = count($tab_nombre2) - 1;
$n2 = 0;
foreach($tab_nombre2 as $nombre2){
    $n2 += getDecimal($nombre2, $tab_dico, $H) * pow(20, $nbPuiss);
    $nbPuiss--;
}
//error_log(var_export($n2, true));

$resultat = 0;
switch ($operation){
    case "+":
        $resultat = $n1 + $n2;
        break;
    case "-":
        $resultat = $n1 - $n2;
        break;
    case "/":
        $resultat = $n1 / $n2;
        break;
    case "*":
        $resultat = $n1 * $n2;
        break;
    default:
        
        break;
}

$tab_resultat = array();
$tab_resultat = getMaya($resultat, $tab_dico);

foreach($tab_resultat as $resultat){
    echo implode("\n", $resultat);
    echo "\n";
}

/*==========================================*/
/* Convertit unnombre décimal en son symbol */
/*==========================================*/
function getMaya($nombre, $tab_dico){
    $tab_resultatDecimal = array();
    $tab_resultatMaya = array();
    $nombre_temp = 0;
    $coeff = 0;
    $nonNul = false;
    for($i=15;$i>=0;$i--){
        $coeff = floor($nombre / pow(20, $i));
        if ($coeff != 0){
            $nonNul = true;
        }
        if ($nonNul){
            $tab_resultatDecimal[] = $coeff;
            $tab_resultatMaya[] = $tab_dico[$coeff];
            $nombre -= $coeff * pow(20, $i);
        }
    }
    
    if (!$nonNul){
        $tab_resultatMaya[] = $tab_dico[0];
    }
    
    return $tab_resultatMaya;
}


/*========================================*/
/* Convertit le symbole en nombre décimal */
/*========================================*/
function getDecimal($tab_nombreMaya, $tab_dico, $nbLigne){
    //error_log(var_export($tab_nombreMaya, true));
    $retour = -1;
    $nombreTrouve = false;
    $i = 0;
    while(!$nombreTrouve && ($i <= count($tab_dico))){
        $j = 0;
        $ligneTrouvee = true;
        while($ligneTrouvee && ($j < $nbLigne)){
            //error_log(var_export("i: ".$i." - j: ".$j." - Nombre: ".$tab_nombreMaya[$j]." - dico: ".$tab_dico[$i][$j], true));
            if($tab_nombreMaya[$j] != $tab_dico[$i][$j]){
                $ligneTrouvee = false;
            }
            $j++;
        }
        if ($ligneTrouvee){
            $nombreTrouve = true;
            $retour = $i;
        }
        $i++;
    }
    
    return $retour;
}
?>