<?php
fscanf(STDIN,"%d %d %d %d %d %d %d %d",$a,$z,$e,$r,$t,$y,$u,$i);
$o=array();
for($i=0;$i<$i;$i++){
    fscanf(STDIN,"%d %d",$p,$q);
    $o[$p] = $q;
}
while (TRUE){
    fscanf(STDIN,"%d %d %s",$s,$d,$f);
    $g = "WAIT";
    if(($s!=-1)||($d!=-1)||($f!='NONE')){
        if($s==$r) {
            if($d>$t) {
                if($f=='RIGHT'){
                    $g='BLOCK';
                }
            }else{
                if($d<$t){
                    if($f=='LEFT'){
                        $g='BLOCK';
                    }
                }
            }
        }else{ 
            if($d>$o[$s]){
                if($f=='RIGHT'){
                    $g='BLOCK';
                }
            }else{
                if(($d<$o[$s])) {
                    if($f=='LEFT') {
                        $g='BLOCK';
                    }
                }
            }
        }
    }
    echo($g."\n");
}