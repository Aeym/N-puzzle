<?php

    function find_heuristic($grid) {
        $y = 0;
        $total = 0;
        $conflict = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($grid[$y][$x] != 0) {
                    $tmp = findInGoal($grid[$y][$x]);
                    // print_r($tmp);
                    if ($GLOBALS["chose"] == 1){ 
                        $total += manhattan($tmp['x'], $tmp['y'], $x, $y);
                    }
                    if ($GLOBALS["chose"] == 2) {
                        $total += euclidean($tmp['x'], $tmp['y'], $x, $y);
                    }
                    if ($GLOBALS["chose"] == 3) {
                        if ($grid[$y][$x] != $GLOBALS["gridGoal"][$y][$x]) {
                            $total += 1;
                        }                        
                    }
                    if ($GLOBALS["chose"] == 4) {
                        // echo "test\n";
                        $total += manhattan($tmp['x'], $tmp['y'], $x, $y);
                        $conflict += conflicts($grid, $y, $x, $tmp);
                    }
                }
                $x++;
            }
            $y++;
        }
        if ($GLOBALS["chose"] == 4) {
            return $total + $conflict;
        } else {
            return $total;
        }
    }

    function conflicts($grid, $yT, $xT, $cGoal) {
        // $gG = $GLOBALS["goalGrid"];
        // echo "test4\n";
        $conf = 0;
        $x = 0;
        // if ($yT != 0) {
        //     // echo "test5\n";
        //     return 0;
        // }
        while ($x < $GLOBALS["nbN"]) {
            if ($x != $xT) {
                $tmpC = findInGoal($grid[$yT][$x]);
                // echo "A : " . $grid[$yT][$xT] . "\n";
                // echo "B : " . $grid[$yT][$x] . "\n";
                // echo "ygoalB : " . $tmpC["y"] . "\n";
                // echo "ygoalA : " . $cGoal["y"] . "\n";
                if ($tmpC["y"] == $cGoal["y"]) {
                    // echo "testbis\n"; // les deux tuiles sont dans la même ligne dans goalState ?
                    if ($xT < $x && $cGoal['x'] > $tmpC['x'] || $xT > $x && $cGoal['x'] < $tmpC['x']) {
                        // echo "test3\n";
                        // // echo $grid[$yT][$xT] . "\n";
                        $conf++;
                    }
                }
            }
            $x++;
        }
        $y = 0;
        while ($y < $GLOBALS["nbN"]) {
            if ($y != $yT) {
                $tmpC = findInGoal($grid[$y][$xT]);
                if ($tmpC["x"] == $cGoal["x"]) {
                    if ($yT < $y && $cGoal['y'] > $tmpC['y'] || $yT > $y && $cGoal['y'] < $tmpC['y']) {
                        $conf++;
                    }
                }
            }
            $y++;
        }
        // echo "conf : " . $conf . "\n";
        return $conf;

    }

    function euclidean($xGoal, $yGoal, $xActual, $yActual) {
        return sqrt(pow($xActual - $xGoal, 2) + pow($yActual - $yGoal, 2));
    }

    function manhattan($xGoal, $yGoal, $xActual, $yActual) {
        return abs($xGoal - $xActual) + abs($yGoal - $yActual);
    }

    function findInGoal($num) {
        $y = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($GLOBALS["gridGoal"][$y][$x] == $num) {
                    return array("x" => $x, "y" => $y);
                }
                $x++;
            }
            $y++;
        }
        return 0;
    }
?>