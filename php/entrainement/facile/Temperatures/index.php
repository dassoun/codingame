<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d",
    $n // the number of temperatures to analyse
);
$temps = stream_get_line(STDIN, 256, "\n"); // the n temperatures expressed as integers ranging from -273 to 5526

//error_log(var_export($temps, true));

$tab_temp = array();
$tab_temp = explode(' ', $temps);
//error_log(var_export($tab_temp, true));

//error_log(var_export(sizeof($tab_temp), true));
if ($temps == '') {
    echo("0\n");
}

$tempMin = 10000;
foreach($tab_temp as $currentTemp) {
//    error_log(var_export($currentTemp, true));
//    error_log(var_export("temp min: ".$tempMin, true));
    if (abs($currentTemp) < abs($tempMin)) {
        $tempMin = $currentTemp;
    } else {
        if (abs($currentTemp) == abs($tempMin)) {
            if ($currentTemp > $tempMin) {
                $tempMin = $currentTemp;
            }
        }
    }
}

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));

echo($tempMin."\n");
?>