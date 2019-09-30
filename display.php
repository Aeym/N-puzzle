<?php
      function display_solving_steps($process, $closedList, $openlist_size) {
        $str = $process["parent"];
        $i = 0;
        $time = count($closedList);
        echo print_grid($process["grid"], $GLOBALS["nbN"]) . "\n";
        while ($str != "start") {
            echo print_grid(json_decode($closedList[$str], TRUE)["grid"], $GLOBALS["nbN"]) . "\n";
            $str = json_decode($closedList[$str], TRUE)["parent"];
            $i++;
        }
        echo "Number of moves required : " . $i . "\n";
        echo "complexity in time : " . $time . "\n";   
        echo "complexity in size : " . ($time + $openlist_size) . "\n";
        return 0;
    }
?>