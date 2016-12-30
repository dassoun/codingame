<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$piece[] = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
$piece[1]["TOP"] = array(0, 1);
$piece[1]["LEFT"] = array(0, 1);
$piece[1]["RIGHT"] = array(0, 1);
$piece[2]["LEFT"] = array(1, 0);
$piece[2]["RIGHT"] = array(-1, 0);
$piece[3]["TOP"] = array(0, 1);
$piece[4]["TOP"] = array(-1, 0);
$piece[4]["RIGHT"] = array(0, 1);
$piece[5]["TOP"] = array(1, 0);
$piece[5]["LEFT"] = array(0, 1);
$piece[6]["LEFT"] = array(1, 0);
$piece[6]["RIGHT"] = array(-1, 0);
$piece[7]["TOP"] = array(0, 1);
$piece[7]["RIGHT"] = array(0, 1);
$piece[8]["LEFT"] = array(0, 1);
$piece[8]["RIGHT"] = array(0, 1);
$piece[9]["TOP"] = array(0, 1);
$piece[9]["LEFT"] = array(0, 1);
$piece[10]["TOP"] = array(-1, 0);
$piece[11]["TOP"] = array(1, 0);
$piece[12]["RIGHT"] = array(0, 1);
$piece[13]["LEFT"] = array(0, 1);


fscanf(STDIN, "%d %d",
    $W, // number of columns.
    $H // number of rows.
);
$tab = array();
for ($i = 0; $i < $H; $i++)
{
    $LINE = stream_get_line(STDIN, 200, "\n"); // represents a line in the grid and contains W integers. Each integer represents one room of a given type.
    $tab[] = explode(" ", $LINE);
}
//error_log(var_export($tab, true));

fscanf(STDIN, "%d",
    $EX // the coordinate along the X axis of the exit (not useful for this first mission, but must be read).
);

// game loop
while (TRUE)
{
    fscanf(STDIN, "%d %d %s",
        $XI,
        $YI,
        $POS
    );
    
    $X = $XI+$piece[$tab[$YI][$XI]][$POS][0];
    $Y = $YI+$piece[$tab[$YI][$XI]][$POS][1];

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));

    echo("$X $Y\n"); // One line containing the X Y coordinates of the room in which you believe Indy will be on the next turn.
}
?>