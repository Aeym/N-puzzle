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
            echo solvable($start["grid"]);
            echo "\n";
            // a_star_algorithm($start);
        }
        else {
            return 1;
        }
    }
    else {
        echo "File is empty\n";
        return 1;
    }
function ask_user() {
    echo "\n\n\t\tChose one of the following search method by typing it's associated number (1 or 2)\n\n";
    echo "\t\t[1] - Uniform cost\n";   
    echo "\t\t[2] - Greedy search\n\n\n";
    $search = fgets(STDIN);
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
    if ($search != 1 && $search != 2) {
        echo "Please provide a number between 1 and 2.\n";
        exit(1);
    }
    echo "\n\n\t\tChose one of the following heurisitcs by typing it's associated number\n\n";
    echo "\t\t[1] - Manhattan" . "\n";
    echo "\t\t[2] - Euclidean" . "\n";
    echo "\t\t[3] - Hamming" . "\n";
    echo "\t\t[4] - Linear conflict" . "\n";
    $h = fgets(STDIN);
    if ($h != 1 && $h != 2 && $h != 3 && $h != 4) {
        echo "Please provide a number between 1 and 4.\n";
        exit(1);
    }
    $GLOBALS["chose"] = $h;
    $GLOBALS["search"] = $search;
}
 ?>