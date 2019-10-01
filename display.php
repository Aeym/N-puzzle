<?php
    function disp_color($var, $which) {
        if ($which == 1) {
            $test = "\033[1;37m\033[41m";
            $test .= $var . "\033[0m";
            return($test);
        }
        else if ($which == 2) {
            $test = "\033[0;30m\033[47m";
            $test .= $var . "\033[0m";
            return($test);
        }
        else {
            $test = "\033[0;30m\033[42m";
            $test .= $var . "\033[0m";
            return($test);
        }
    }

    function display_solving_steps($process, $closedList, $openlist_size) {
        $str = $process["parent"];
        $path = array();
        $i = 0;
        $time = count($closedList);
        $path[] = $process["grid"];
        while ($str != "start") {
            $path[] = json_decode($closedList[$str], TRUE)["grid"];
            $str = json_decode($closedList[$str], TRUE)["parent"];
            $i++;
        }
        if($i < 50) {
            $timeSleep = 10000000 / (2 * $i);
        } else {
            $timeSleep = 10000000 / $i;
        }
        $pathbis = array_reverse($path);
        foreach ($pathbis as $elem) {
            echo print_grid($elem, $GLOBALS["nbN"]) . "\n";
            usleep((int)$timeSleep);
        }
        echo "Number of moves required : " . $i . "\n";
        echo "complexity in time : " . $time . "\n";   
        echo "complexity in size : " . ($time + $openlist_size) . "\n";
        return 0;
    }
?>