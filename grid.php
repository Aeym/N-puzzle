<?php

    function print_grid($arr, $n) {
        $colors = new Colors();
        $len = strlen((string)($n * $n - 1));
        $y = 0;
        $c = count($arr);
        $str = "";
        while ($y < $c) {
            $x = 0;
            while ($x < $c) {
                $tmplen = strlen($arr[$y][$x]);
                if ($arr[$y][$x] == 0) {
                    #echo $colors->getColoredString($str, "black", "light_gray");
                  #  echo disp_color2($str);
                    $str = "";
                    $tmpZ = $arr[$y][$x];
                    $tmpZ .= " ";
                    while ($tmplen < $len) {
                        $tmpZ .= " ";
                        $tmplen++;
                    }
                    #echo $colors->getColoredString($tmpZ, "white", "red");
                    echo disp_color($str);
                    
                }
                else {
                    $tmpStr = $arr[$y][$x] . " ";
                    while ($tmplen < $len) {
                        $tmpStr .= " ";
                        $tmplen++;
                    }
                    $str .= $tmpStr;
                }
                $x++;
            }
            $y++;
            echo disp_color2($str);
            #echo $colors->getColoredString($str, "black", "light_gray");
            echo  "\n";
            $str = "";
        }
        //echo $colors->getColoredString($str, "black", "light_gray");
        //echo $str;
    }

    function find_zero($grid) {
        $y = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($grid[$y][$x] == 0) {
                    return array("x0" => $x, "y0" => $y);
                }
                $x++;
            }
            $y++;
        }
        return 0;
    }

    function grid_to_str($grid) {
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


    function goal_grid($n) {
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
        $GLOBALS["strGoal"] = grid_to_str($ret);
        $GLOBALS["gridGoal"] = $ret;
        // return $ret;
    }

?>