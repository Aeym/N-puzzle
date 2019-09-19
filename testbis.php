<?php

    $grid = test($argv[1]);
    // print_r($grid);
    printArr($grid);

    function printArr($arr) {
        // foreach($arr as $valueArr) {
        //     $x = 1;
        //     $c = count($valueArr);
        //     while ($x < $c) {
        //         echo $valueArr[$x] . " ";
        //         $x++;
        //     }
        //     echo "\n";
        // }
        $y = 0;
        $c = count($arr);
        while ($y < $c) {
            $x = 0;
            while ($x < $c) {
                echo $arr[$x][$y] . " ";
                $x++;
            }
            $y++;
            echo "\n";
        }
    }

    function test($n) {
        $nbmax = $n * $n;
        echo "nbmax = " . $nbmax . "\n";
        $nb = 1;
        $snail = 0;
        $x = 0;
        $y = 0;
        while ($nb < $nbmax) {
            while ($x < ($n - $snail)) {
                $ret[$x][$y] = $nb;
                $x++;
                $nb++;
            }
            $x--;
            $y++;
            while ($y < ($n - $snail)) {
                $ret[$x][$y] = $nb;
                $y++;
                $nb++;
            }
            $y--;
            $x--;
            while ($x >= (0 + $snail)) {
                $ret[$x][$y] = $nb;
                $x--;
                $nb++;
            }
            $x++;
            $y--;
            $snail++;
            while ($y >= (0 + $snail)) {
                $ret[$x][$y] = $nb;
                $y--;
                $nb++;
            }
            $y++;
            $x++;
            if ($nb == $nbmax) {
                $ret[$x][$y] = 0;
            }
            // $x++;
            // $nb++;
            // print_r($ret);
        }
        return array_values($ret);
    }

?>