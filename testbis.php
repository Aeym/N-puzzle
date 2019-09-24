<?php

    $openSet = [];
    $closedSet = [];
    $goalGrid = [];

    // goalGrid($argv[1]);
    // print_r($GLOBALS);
    // printGrid($grid, $argv[1]);
    // echo "\n";
    // echo gridToStr($grid);
    function printGrid($arr, $n) {
        $len = strlen((string)($n * $n - 1));
        $y = 0;
        $c = count($arr);
        $str = "";
        while ($y < $c) {
            $x = 0;
            while ($x < $c) {
                $tmplen = strlen($arr[$y][$x]);
                $tmpStr = $arr[$y][$x] . " ";
                while ($tmplen < $len) {
                    $tmpStr .= " ";
                    $tmplen++;
                }
                $str .= $tmpStr;
                $x++;
            }
            $y++;
            $str .=  "\n";
        }
        echo $str;
    }


    function gridToStr($grid) {
        $c = count($grid);
        $y = 0;
        $tmp = "";
        while ($y < $c) {
            $x = 0;
            while ($x < $c) {
                $tmp .= $grid[$y][$x];
                $x++;
            }
            $y++;
        }
        return $tmp;
    }


    function goalGrid($n) {
        $nbmax = $n * $n;
        echo "nbmax = " . $nbmax . "\n";
        $nb = 1;
        $snail = 0;
        $x = 0;
        $y = 0;
        while ($nb < $nbmax) {
            while ($x < ($n - $snail)) {
                $ret[$y][$x] = $nb;
                $x++;
                $nb++;
            }
            $x--;
            $y++;
            while ($y < ($n - $snail)) {
                $ret[$y][$x] = $nb;
                $y++;
                $nb++;
            }
            $y--;
            $x--;
            if ($nb == $nbmax) {
                $ret[$y][$x] = 0;
                break;
            }
            while ($x >= (0 + $snail)) {
                $ret[$y][$x] = $nb;
                $x--;
                $nb++;
            }
            $x++;
            $y--;
            $snail++;
            while ($y >= (0 + $snail)) {
                $ret[$y][$x] = $nb;
                $y--;
                $nb++;
            }
            $y++;
            $x++;
            if ($nb == $nbmax) {
                $ret[$y][$x] = 0;
            }
        }
        $GLOBALS["strGoal"] = gridToStr($ret);
        $GLOBALS["gridGoal"] = $ret;
        // return $ret;
    }

?>