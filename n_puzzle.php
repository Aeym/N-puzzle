<?php
    ini_set('memory_limit', '2048M'); // or you could use 1G
    require_once("./grid.php");
    require_once("./heuristic.php");
    require_once("./algorithm.php");
    require_once("./display.php");
    require_once("./data.php");
    require_once("./parse.php");

    if (!file_exists($argv[1])) {
        echo "File doesn't exist\n";
        return 1;
    }
    else if (!preg_match("/.txt/", $argv[1])) {
        echo "Wrong file extension\n";
        return 1;
    }
    else if (!isFileEmpty($argv[1])) {
        if (($coordinates = parse_file($argv[1])) != 1) {
            ask_user();
            $start = createNode($coordinates, "start", -1, 'c');
            a_star_algorithm($start);
        }
        else {
            return 1;
        }
    }
    else {
        echo "File is empty\n";
        return 1;
    }
 ?>