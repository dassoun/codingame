<?php
/**
 * The while loop represents the game.
 * Each iteration represents a turn of the game
 * where you are given inputs (the heights of the mountains)
 * and where you have to print an output (the index of the mountain to fire on)
 * The inputs you are given are automatically updated according to your last actions.
 **/


// game loop
while (TRUE)
{
    $tab = array();
    
    for ($i = 0; $i < 8; $i++)
    {
        fscanf(STDIN, "%d",
            $mountainH // represents the height of one mountain.
        );
        $tab[] = $mountainH;
    }
    
    $max = 0; 
    $indice = 0;
    for ($i = 0; $i < 8; $i++)
    {
        if ($tab[$i] > $max) {
            $max = $tab[$i];
            $indice = $i;
        }
    }

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));

    echo("$indice\n"); // The index of the mountain to fire on.
}
?>