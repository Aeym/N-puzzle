<?php
    ini_set('memory_limit', '2048M'); // or you could use 1G
    require_once("./grid.php");
    require_once("./heuristic.php");
    require_once("./algorithm.php");
    require_once("./display.php");
    require_once("./data.php");
    require_once("./parse.php");
    require_once("./inversion.php");


    if (!file_exists($argv[1])) {
        echo "Error: file doesn't exist\n";
        return 1;
    }
    else if (!preg_match("/.txt/", $argv[1])) {
        echo "Error: wrong file extension\n";
        return 1;
    }
    else if (!isFileEmpty($argv[1])) {
        if (($coordinates = parse_file($argv[1])) != 1) {
            if (ask_user() != 1) {
                $start = createNode($coordinates, "start", -1, 'c');
                if (solvable($start["grid"]) != 1) {
                    a_star_algorithm($start);
                    return 0;
                }
            }
        }
        return 1;
    }
    else {
        echo "Error: empty file\n";
        return 1;
    }

    function generateGrid($n, $iter) {
        $newGrid = $GLOBALS["gridGoal"];
        $i = 0;
        while ($i < $iter) {
            $tmpA = array("yA" => rand(0, $n -1), "xA" => rand(0, $n - 1));
            $tmpB = array("yB" => rand(0, $n -1), "xB" => rand(0, $n - 1));
            $tmp = $newGrid[$tmpA["yA"]][$tmpA["xA"]];
            $newGrid[$tmpA["yA"]][$tmpA["xA"]] = $newGrid[$tmpB["yB"]][$tmpB["xB"]];
            $newGrid[$tmpB["yB"]][$tmpB["xB"]] =  $tmp;
            $i++;
        }
        return $newGrid;
    }

 ?>