<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

define("REAPER", 0);
define("DESTROYER", 1);
define("DOOF", 2);
define("TANKER", 3);
define("WRECK", 4);

class Point {
    public $x;
    public $y;

    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
}

class Unit {
    public $unitId;
    public $unitType;
    public $playerId;
    public $mass;
    public $radius;
    public $x;
    public $y;
    public $vx;
    public $vy;
    public $extra;
    public $extra2;
    public $friction;
    public $maxAcc;

    public function __construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2) {
        $this->unitId = $unitId;
        $this->unitType = $unitType;
        $this->playerId = $playerId;
        $this->mass = $mass;
        $this->radius = $radius;
        $this->x = $x;
        $this->y = $y;
        $this->vx = $vx;
        $this->vy = $vy;
        $this->extra = $extra;
        $this->extra2 = $extra2;

        $this->friction = 0;
        $this->maxAcc = 0;

    }

    public function getDestinationPoint() {
        $vx = $this->vx;
        $vy = $this->vy;
        $x = $this->vx;
        $y = $this->vy;
        //error_log(var_export("x: " . $x . ", y: " . $y, true));
        while ($vx > 0 || $vy > 0) {
            $vx = round($vx * (1 - $this->friction));
            $vy = round($vy * (1 - $this->friction));

//            error_log(var_export("vx: " . $vx . ", vy: " . $vy, true));

            $x += $vx;
            $y += $vy;
        }

        return new Point($x, $y);
    }
}

class PlayerUnit extends Unit {
    public function __construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2) {
        parent::__construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
    }

    public function move($x, $y, $acc, $comment = "") {
        if ($comment == "") {
            echo($x . " " . $y . " " . $acc . "\n");
        } else {
            echo($x . " " . $y . " " . $acc . " " . $comment . "\n");
        }
    }

    public function getNearestWreck($wrecks) {
        $distMin = 12000;
        foreach($wrecks as $wreck) {
            $distX = abs($wreck->x - $this->x) - $wreck->radius;
            $distY = abs($wreck->y - $this->y) - $wreck->radius;
            $dist = sqrt(($distX * $distX) + ($distY * $distY));
            if ($dist < $distMin) {
                $distMin = $dist;
                $wreckReturn = $wreck;
            }
        }

        if (isSet($wreckReturn)) {
            return $wreckReturn;
        } else {
            return null;
        }
    }

    public function getBiggestWreck($wrecks) {
        if (!isSet($wrecks)) {
            return null;
        }

        $quantity = -1;
        foreach($wrecks as $wreck) {
            //error_log(var_export($wreck->extra, true));
            if ($wreck->extra > $quantity) {
                $quantity = $wreck->extra;
                $wreckReturn = $wreck;
            }
        }

        if (isSet($wreckReturn)) {
            return $wreckReturn;
        } else {
            return null;
        }
    }

    public function getFullestTanker($tankers) {
        return $this->getBiggestWreck($tankers);
    }

    public function getBiggestTanker($tankers) {
        if (!isSet($tankers)) {
            return null;
        }

        $capacity = -1;
        foreach($tankers as $tanker) {
            if ($tanker->extra2 > $capacity) {
                $quantity = $tanker->extra2;
                $tankerReturn = $tanker;
            }
        }

        if (isSet($tankerReturn)) {
            return $tankerReturn;
        } else {
            return null;
        }
    }

    public function isOnWreck($wrecks) {
        if (!isSet($wrecks)) {
            return false;
        }

        foreach($wrecks as $wreck) {
            $distX = abs($wreck->x - $this->x);// - $wreck->radius;
            $distY = abs($wreck->y - $this->y);// - $wreck->radius;
            $dist = sqrt(($distX * $distX) + ($distY * $distY));

            if ($dist < $wreck->radius) {
                return true;
            }
        }

        return false;
    }

    public function getDistance($x, $y) {
        $distX = abs($x - $this->x);
        $distY = abs($y - $this->y);
        $dist = sqrt(($distX * $distX) + ($distY * $distY));

        return $dist;
    }
}

class Reaper extends PlayerUnit {
    public function __construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2) {
        parent::__construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);

        $this->friction = 0.2;
        $this->maxAcc = 300;
    }

/*    public function isOnWreck($wreck) {

        $distX = abs($wreck->x - $this->x);
        $distY = abs($wreck->y - $this->y);
        $dist = sqrt(($distX * $distX) + ($distY * $distY));

        return ($dist <= $wreck->radius);
    }
*/
}

class Destroyer extends PlayerUnit {
    public function __construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2) {
        parent::__construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);

        $this->friction = 0.3;
        $this->maxAcc = 300;
    }
}

class Tanker extends Unit {
    public function __construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2) {
        parent::__construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);

        $this->friction = 0.4;
        $this->maxAcc = 500;
    }
}

class Doof extends PlayerUnit {
    public function __construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2) {
        parent::__construct($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);

        $this->friction = 0.25;
        $this->maxAcc = 300;
    }
}

function getOverlapedWrecks($wrecks) {
    $overlapedWrecks = array();

    if (!isSet($wrecks)) {
        return $overlapedWrecks;
    }

/*
    foreach($wrecks as $key1 => $wreck1) {
        foreach($wrecks as $key2 => $wreck2) {
            if ($key1 != $key2) {
                $dx = $wreck1->x - $wreck2->x;
                $dy = $wreck1->y - $wreck2->y;

                if (sqrt(($dx * $dx) + ($dy * $dy)) <= ($wreck1->radius + $wreck2->radius)) {
                    $x = (min($wreck1->x, $wreck2->x)) + ($dx / 2);
                    $y = (min($wreck1->y, $wreck2->y)) + ($dy / 2);
                    $overlapedWrecks[] = new Point($x, $y);
                }
            }
        }
    }
*/
    $nbWrecks = count($wrecks);

    for ($i = 0; $i < $nbWrecks - 1; $i++) {
        for ($j = $i + 1; $j < $nbWrecks; $j++) {
            $dx = $wrecks[$i]->x - $wrecks[$j]->x;
            $dy = $wrecks[$i]->y - $wrecks[$j]->y;

            if (sqrt(($dx * $dx) + ($dy * $dy)) <= ($wrecks[$i]->radius + $wrecks[$j]->radius)) {
                //$x = (min($wrecks[$i]->x, $wrecks[$j]->x)) + ($dx / 2);
                //$y = (min($wrecks[$i]->y, $wrecks[$j]->y)) + ($dy / 2);

                $overlapedWrecks[] = ($wrecks[$i]->extra > $wrecks[$j]->extra) ? $wrecks[$i] : $wrecks[$j];
            }
        }
    }

    return $overlapedWrecks;
}


// game loop
while (TRUE)
{
    $startLoopTime = $previousTime = (microtime(true));
//    error_log(var_export("a: " . $previousTime, true));

    fscanf(STDIN, "%d",
        $myScore
    );
    fscanf(STDIN, "%d",
        $enemyScore1
    );
    fscanf(STDIN, "%d",
        $enemyScore2
    );
    fscanf(STDIN, "%d",
        $myRage
    );
    fscanf(STDIN, "%d",
        $enemyRage1
    );
    fscanf(STDIN, "%d",
        $enemyRage2
    );
    fscanf(STDIN, "%d",
        $unitCount
    );

    $reapers = array();
    $wrecks = array();
    $tankers = array();
    $destroyers = array();
    $doofs = array();

    $overlapedWrecks = array();

//    $elapsedTime = (microtime(true) - $previousTime);
//    error_log(var_export("a: " . $elapsedTime, true));
//    $previousTime = microtime(true);
//    $totalElapsedTime = ($previousTime - $startLoopTime);
//    error_log(var_export("a total: " . $totalElapsedTime, true));

    for ($i = 0; $i < $unitCount; $i++)
    {
        fscanf(STDIN, "%d %d %d %f %d %d %d %d %d %d %d",
            $unitId,
            $unitType,
            $playerId,
            $mass,
            $radius,
            $x,
            $y,
            $vx,
            $vy,
            $extra,
            $extra2
        );

        if ($unitType == REAPER) {
            $reapers[$playerId] = new Reaper($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
        } else if ($unitType == WRECK) {
            $wrecks[] = new Unit($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
        } else if ($unitType == TANKER) {
            $tankers[] = new Tanker($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
        } else if ($unitType == DESTROYER) {
            $destroyers[$playerId] = new Destroyer($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
        } else if ($unitType == DOOF) {
            $doofs[$playerId] = new Doof($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
        }
    }

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));

    $overlapedWrecks = getOverlapedWrecks($wrecks);
    foreach($overlapedWrecks as $overlapedWreck) {
        error_log(var_export("x: " . $overlapedWreck->x . ", y: " . $overlapedWreck->y, true));
    }

    $nearestWreck = $reapers[0]->getNearestWreck($overlapedWrecks);
    if (!isSet($nearestWreck)) {
        $nearestWreck = $reapers[0]->getNearestWreck($wrecks);
    }

    // Reaper
    if (!$reapers[0]->isOnWreck($wrecks)) {
        if (isSet($nearestWreck)) {
            if ($reapers[0]->isOnWreck(array($nearestWreck))) {
                echo("WAIT\n");
            } else {
                $reapers[0]->move($nearestWreck->x - $reapers[0]->vx, $nearestWreck->y - $reapers[0]->vy, $reapers[0]->maxAcc);
            }
        } else {
            // On se rapproche de notre Destroyer
            //$reapers[0]->move(0, 0, 300);
            $reapers[0]->move($destroyers[0]->x - $reapers[0]->vx, $destroyers[0]->y - $reapers[0]->vy, 300);
        }
    } else {
        // On récupère l'eau
        $reapers[0]->move($nearestWreck->x - $reapers[0]->vx, $nearestWreck->y - $reapers[0]->vy, $reapers[0]->maxAcc);
        //echo("WAIT\n");
    }

    // Destroyer
    $bestEnemy = $enemyScore1 > $enemyScore2 ? $reapers[1] : $reapers[2];
    if ($myRage >= 60) {
/*
        // Si le meilleur ennemi récupère de l'eau
        if ($bestEnemy->isOnWreck($wrecks)) {
            // Si mon Reaper est à portée de grenade
            if ($destroyers[0]->getDistance($reapers[0]->x, $reapers[0]->y) <= 2000) {
                // Si le meilleur ennemi est à portée d'une grenade qu'on envoie sur moi
                if ($reapers[0]->getDistance($bestEnemy->x, $bestEnemy->y) <= 1000) {
                    // On lance la grenade sur moi
                    echo("SKILL " . $reapers[0]->x . " " . $reapers[0]->y . "\n");
                } else if ($destroyers[0]->getDistance($bestEnemy->x + 1, $bestEnemy->y)) {
                    echo("SKILL " . ($bestEnemy->x + 1) . " " . $bestEnemy->y . "\n");
                } else {
                    $destroyers[0]->move($bestEnemy->x, $bestEnemy->y, $destroyers[0]->maxAcc);
                }
            } else {
                $destroyers[0]->move($bestEnemy->x, $bestEnemy->y, $destroyers[0]->maxAcc);
            }
        } else {
            $destroyers[0]->move($bestEnemy->x, $bestEnemy->y, $destroyers[0]->maxAcc);
        }
*/

        if ($destroyers[0]->getDistance($bestEnemy->x, $bestEnemy->y) <= 2000) {
            if ($bestEnemy->isOnWreck($wrecks)) {
                echo("SKILL " . ($bestEnemy->x + 1) . " " . $bestEnemy->y . " Skill " . $bestEnemy->x . "\n");
            } else {
                $destroyers[0]->move($bestEnemy->x, $bestEnemy->y, $destroyers[0]->maxAcc, "moving");
            }
        } else {
            $destroyers[0]->move($bestEnemy->x, $bestEnemy->y, $destroyers[0]->maxAcc, "moving");
        }

    } else {
        $fullestTanker = $destroyers[0]->getFullestTanker($tankers);
        if (isSet($fullestTanker)) {
            $destroyers[0]->move($fullestTanker->x, $fullestTanker->y, $destroyers[0]->maxAcc, "moving");
        } else {
            echo("WAIT nothing\n");
        }
    }

    // Doof
    $doofs[0]->move($bestEnemy->x, $bestEnemy->y, $doofs[0]->maxAcc);
}
?>
