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
define("TAR", 5);
define("OIL", 6);

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

    public function isOilOver($oils) {
        //error_log(var_export("isOilOver", true));
        if (!isSet($oils)) {
            return false;
        }

        //error_log(var_export("isOilOver2", true));
        foreach($oils as $oil) {
            if ($this->getDistance($oil->x, $oil->y) < $oil->radius) {
                return true;
            }
        }

        return false;
    }

    public function getWrecksUnder($wrecks) {
        $wrecksUnder = array();

        foreach($wrecks as $wreck) {
            if ($wreck->getDistance($this->x, $this->y) <= $wreck->radius) {
                $wrecksUnder[] = $wreck;
            }
        }

        return $wrecksUnder;
    }

    public function getDistance($x, $y) {
        $distX = abs($x - $this->x);
        $distY = abs($y - $this->y);
        $dist = sqrt(($distX * $distX) + ($distY * $distY));

        return $dist;
    }

    public function isOnTheWreck($wreck) {
        return ($this->getDistance($wreck->x, $wreck->y) <= $wreck->radius);
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

    public function getNearestWreck($wrecks, $reapers, $nbreaper, $oils) {
        $distMin = 12000;
        foreach($wrecks as $wreck) {
            $distX = abs($wreck->x - $this->x) - $wreck->radius;
            $distY = abs($wreck->y - $this->y) - $wreck->radius;
            $dist = sqrt(($distX * $distX) + ($distY * $distY));

            if (!$this->isOilOver($oils)) {
                if (($reapers[1]->getDistance($wreck->x, $wreck->y) > $reapers[0]->getDistance($wreck->x, $wreck->y)) ||
                                ($reapers[2]->getDistance($wreck->x, $wreck->y) > $reapers[0]->getDistance($wreck->x, $wreck->y))) {
                    if ($dist < $distMin) {
                        $distMin = $dist;
                        $wreckReturn = $wreck;
                    }
                }
            } else {
                error_log(var_export("oil in x: " . $this->x . ", y: " . $this->y, true));
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

/*
    public function getDistance($x, $y) {
        $distX = abs($x - $this->x);
        $distY = abs($y - $this->y);
        $dist = sqrt(($distX * $distX) + ($distY * $distY));

        return $dist;
    }
*/
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

function compareWrecksByAvailableWater($wreck1, $wreck2) {
    if ($wreck1->extra < $wreck2->extra) {
        return 1;
    } else if ($wreck1->extra = $wreck2->extra) {
        return 0;
    } else {
        return -1;
    }
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
    $tars = array();
    $oils = array();

    $overlapedWrecks = array();

    $wrecksUnderBestEnemy = array();

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
        } else if ($unitType == TAR) {
            $tars[] = new Unit($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
        } else if ($unitType == OIL) {
            $oils[] = new Unit($unitId, $unitType, $playerId, $mass, $radius, $x, $y, $vx, $vy, $extra, $extra2);
        }
    }

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));

    $overlapedWrecks = getOverlapedWrecks($wrecks);
    foreach($overlapedWrecks as $overlapedWreck) {
        error_log(var_export("x: " . $overlapedWreck->x . ", y: " . $overlapedWreck->y, true));
    }

    $nearestWreck = $reapers[0]->getNearestWreck($overlapedWrecks, $reapers, 0, $oils);
    if (!isSet($nearestWreck)) {
        $nearestWreck = $reapers[0]->getNearestWreck($wrecks, $reapers, 0, $oils);
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
        if (isSet($nearestWreck)) {
            $reapers[0]->move($nearestWreck->x - $reapers[0]->vx, $nearestWreck->y - $reapers[0]->vy, $reapers[0]->maxAcc);
        } else {
            $reapers[0]->move($destroyers[0]->x - $reapers[0]->vx, $destroyers[0]->y - $reapers[0]->vy, 300);
        }
    }

    // Destroyer
    $bestEnemy = $enemyScore1 > $enemyScore2 ? $reapers[1] : $reapers[2];

    $wrecksUnderBestEnemy = $bestEnemy->getWrecksUnder($wrecks);
    if (count($wrecksUnderBestEnemy) > 0) {
        error_log(var_export("Wrecks under before sort: ", true));
        foreach($wrecksUnderBestEnemy as $wreckUnderBestEnemy) {
            error_log(var_export("x: " . $wreckUnderBestEnemy->x . ", y: " . $wreckUnderBestEnemy->y . " / available water: " . $wreckUnderBestEnemy->extra, true));
        }
        if (count($wrecksUnderBestEnemy) > 1) {
            usort($wrecksUnderBestEnemy, 'compareWrecksByAvailableWater');
        }
        if (count($wrecksUnderBestEnemy) > 1) {
            error_log(var_export("Wrecks under after sort: ", true));
            foreach($wrecksUnderBestEnemy as $wreckUnderBestEnemy) {
                error_log(var_export("x: " . $wreckUnderBestEnemy->x . ", y: " . $wreckUnderBestEnemy->y . " / available water: " . $wreckUnderBestEnemy->extra, true));
            }
        }
        error_log(var_export("====================", true));
    }


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
                $destroyers[0]->move($bestEnemy->x, $bestEnemy->y, $destroyers[0]->maxAcc);
            }
        } else {
            $destroyers[0]->move($bestEnemy->x, $bestEnemy->y, $destroyers[0]->maxAcc);
        }

    } else {
        $fullestTanker = $destroyers[0]->getFullestTanker($tankers);
        if (isSet($fullestTanker)) {
            $destroyers[0]->move($fullestTanker->x, $fullestTanker->y, $destroyers[0]->maxAcc);
        } else {
            echo("WAIT nothing\n");
        }
    }

    // Doof
    if ($myRage >= 30) {
        if (count($wrecksUnderBestEnemy) > 0) {
            if ($doofs[0]->getDistance($wrecksUnderBestEnemy[0]->x, $wrecksUnderBestEnemy[0]->y) <= 2000) {
                error_log(var_export("XXXXXXXXXXXXXXXXXXXXXXXXXX", true));
                if (!$reapers[0]->isOnTheWreck($wrecksUnderBestEnemy[0])) {
                    if (!$wrecksUnderBestEnemy[0]->isOilOver($oils)) {
                        echo("SKILL " . $wrecksUnderBestEnemy[0]->x . " " . $wrecksUnderBestEnemy[0]->y . "\n");
                        error_log(var_export("*** Oil on x: " . $wrecksUnderBestEnemy[0]->x . ", " . $wrecksUnderBestEnemy[0]->y . " ***", true));
                    } else {
                        $doofs[0]->move($bestEnemy->x, $bestEnemy->y, $doofs[0]->maxAcc);
                        error_log(var_export("*** Oil already there ***", true));
                    }
                } else {
                    $doofs[0]->move($bestEnemy->x, $bestEnemy->y, $doofs[0]->maxAcc);
                    error_log(var_export("*** No Oil /!\ Same Wreck ***", true));
                }
            } else {
                $doofs[0]->move($bestEnemy->x, $bestEnemy->y, $doofs[0]->maxAcc);
            }
        } else {
            $doofs[0]->move($bestEnemy->x, $bestEnemy->y, $doofs[0]->maxAcc);
        }
    } else {
        $doofs[0]->move($bestEnemy->x, $bestEnemy->y, $doofs[0]->maxAcc);
    }
}
?>
