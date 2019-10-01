<?php

    function solvable($grid) {
        $str = grid_to_str($grid);
        $goalStr = grid_to_str($GLOBALS["gridGoal"]);
        $invCount = inversion_count($str, $goalStr);
        if (($GLOBALS["nbN"] % 2) == 0) {
            $tmpZ = find_zero($grid);
            $goalZ = find_zero($GLOBALS["gridGoal"]);
            $tmpM = manhattan($tmpZ['x0'], $tmpZ['y0'], $goalZ['x0'], $goalZ['y0']);
            $posZ = abs($tmpZ['y0'] - $goalZ['y0']) + 1;
            // TRAITER LES CHIFFRES DU GOAL STATE COMME CEUX DU STANDARD STATE
            // echo "posZ : " . $posZ . "\n";
            // echo "Inv : " . $invCount . "\n";
            if ($posZ % 2 == 0 && $invCount % 2 != 0 || $posZ % 2 != 0 && $invCount % 2 == 0) {
                return 2;
            }
        } else {
            if (($invCount % 2) == 0) {
                return 1;
            }
        }
        return 0;
    }

    
    function inversion_count($str, $goalStr) {
        $inv = 0;
        $i = 0;
        $len = strlen($str);
        while ($i < $len) {
            $tmpI = $i + 1;
            while ($tmpI < $len) {
                if (strpos($goalStr, $str[$i]) > strpos($goalStr, $str[$tmpI])) {
                    $inv++;
                }
                $tmpI++;
            }
            $i++;
        }
        return $inv;
    }

    // function inversion_count($str) {
    //     $inv = 0;
    //     $i = 0;
    //     $len = strlen($str);
    //     while ($i < $len) {
    //         $tmpI = $i + 1;
    //         while ($tmpI < $len) {
    //             if ($str[$i] > $str[$tmpI] && $str[$tmpI] != 0) {
    //                 $inv++;
    //             }
    //             $tmpI++;
    //         }
    //         $i++;
    //     }
    //     return $inv;
    // }
    
    function depileSnail($grid) {
        $str = "";
        $n = $GLOBALS["nbN"];
        $nbmax = $n * $n;
        $snail = 0;
        $x = 0;
        $y = 0;
        $nb = 1;
        while ($nb < $nbmax) {
            while ($x < ($n - $snail)) {
                $str .= $grid[$y][$x];
                $x++;
                $nb++;
            }
            $x--;
            $y++;
            while ($y < ($n - $snail)) {
                $str .= $grid[$y][$x];
                $y++;
                $nb++;
            }
            $y--;
            $x--;
            if ($nb == $nbmax) {
                $str .= $grid[$y][$x];
                break;
            }
            while ($x >= (0 + $snail)) {
                $str .= $grid[$y][$x];
                $x--;
                $nb++;
            }
            $x++;
            $y--;
            $snail++;
            while ($y >= (0 + $snail)) {
                $str .= $grid[$y][$x];
                $y--;
                $nb++;
            }
            $y++;
            $x++;
            if ($nb == $nbmax) {
                $str .= $grid[$y][$x];
            }
        }
        return $str;
    }

?>