<?php

    function find_heuristic($grid) {
        $y = 0;
        $total = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($grid[$y][$x] != 0) {
                    $tmp = findInGoal($grid[$y][$x]);
                   #  print_r($grid);
                    if ($GLOBALS["chose"] == 1){ 
                        $total += manhattan($tmp['x'], $tmp['y'], $x, $y);
                    }
                    if ($GLOBALS["chose"] == 2) {
                        $total += euclidean($tmp['x'], $tmp['y'], $x, $y);
                    }  
                }
                $x++;
            }
            $y++;
        }
        return $total;
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