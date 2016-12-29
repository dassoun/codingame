<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$tab_mime = array();

fscanf(STDIN, "%d",
    $N // Number of elements which make up the association table.
);
fscanf(STDIN, "%d",
    $Q // Number Q of file names to be analyzed.
);
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%s %s",
        $EXT, // file extension
        $MT // MIME type.
    );
    $tab_mime[strtoupper($EXT)] = $MT;
}

//error_log(var_export($tab_mime, true));
//error_log(var_export(array_count_values($tab_mime), true));
//error_log(var_export(count($tab_mime), true));


for ($i = 0; $i<$Q; $i++)
{
    $FNAME = stream_get_line(STDIN, 500, "\n"); // One file name per line.
    $extension = strtoupper(pathinfo($FNAME, PATHINFO_EXTENSION));

    if (isset($tab_mime[strtoupper($extension)])) {
        echo($tab_mime[strtoupper($extension)]."\n");
    } else {
        echo("UNKNOWN\n");
    }
}

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));

//echo("UNKNOWN\n"); // For each of the Q filenames, display on a line the corresponding MIME type. If there is no corresponding type, then display UNKNOWN.
?>