<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%s",
    $LON
);
fscanf(STDIN, "%s",
    $LAT
);
fscanf(STDIN, "%d",
    $N
);

$tab_defib = array();
$LON = (float)str_replace(',', '.', $LON);
$LAT = (float)str_replace(',', '.', $LAT);

for ($i = 0; $i < $N; $i++)
{
    $DEFIB = stream_get_line(STDIN, 256, "\n");
    $tab_defib[$i] = explode(";", $DEFIB);
    
    // on remplace les ',' des hamps numérique par des points
    $tab_defib[$i][4] = (float)str_replace(',', '.', $tab_defib[$i][4]);
    $tab_defib[$i][5] = (float)str_replace(',', '.', $tab_defib[$i][5]);
}
//error_log(var_export($tab_defib, true));

$distanceMin = 100000000;
for ($i=0; $i<$N; $i++) {
    $distance = (calculeDistance($tab_defib[$i][4], $tab_defib[$i][5], $LON, $LAT));
    if ($distance < $distanceMin) {
        //error_log(var_export($distance." ".$tab_defib[$i][1], true));
        //error_log(var_export($tab_defib[$i][1]." - "."longitude: ".$tab_defib[$i][4]." - "."latitude: ".$tab_defib[$i][5], true));
        $NomDefib = $tab_defib[$i][1];
        $distanceMin = $distance;
    }
}

/*
$tmp1 = calculeDistance(3.87409666178277, 3.88995587137398, 43.610433894746, 43.6260090150577);
error_log(var_export($tmp1, true));
$tmp2 = calculeDistance(3.87110915929521, 3.88995587137398, 43.6065196099402, 43.6260090150577);
error_log(var_export($tmp2, true));
*/

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));

echo($NomDefib."\n");

function calculeDistance($longitudeA, $latitudeA, $longitudeB, $latitudeB){
    $x = abs($longitudeB - $longitudeA) * cos(($latitudeA + $latitudeB) / 2);
    $y = abs($latitudeB - $latitudeA);
    $distance = sqrt(pow($x, 2) + pow($y, 2)) * 6371;
    
    return $distance;
}
?>