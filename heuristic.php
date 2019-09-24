<?php

    function manhattan_state($grid) {
        $y = 0;
        $total = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($grid[$y][$x] != 0) {
                    $tmp = findInGoal($grid[$y][$x]);
                    $total += manhattan($tmp['x'], $tmp['y'], $x, $y);
                }
                $x++;
            }
            $y++;
        }
        return $total;
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