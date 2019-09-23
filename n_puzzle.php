<?php

    if (!file_exists($argv[1])) {
        echo "File doesn't exist\n";
        return 1;
    }
    if (!preg_match("/.txt/", $argv[1])) {
        echo "Wrong file extension\n";
        return 1;
    }
    if (!isFileEmpty($argv[1])) {
        if (($coordinates = parse_file($argv[1])) != 1) {
            # ICI DEBUT DU PROGRAMME
        }
        else {
            return 1;
        }
    }
    else {
        echo "File is empty\n";
        return 1;
    }


function parse_file($argv) {
    $i = 0;
    $coordinates = [];
    $nbvalues = 0;
    $fileArr = file($argv);
    delComms($fileArr);
    $total = $fileArr[0];
    $total *= $total;
    unset($fileArr[0]);
    $fileArr = array_values($fileArr);

    for ($i = 0, $len = count($fileArr); $i < $len; $i++) {   
        $coordinates[] = preg_split('/\s/', $fileArr[$i], -1, PREG_SPLIT_NO_EMPTY);      
    }
    for ($i = 0, $len = count($coordinates); $i < $len; $i++) {
        for ($n = 0, $j=count($coordinates[$i]); $n < $j; $n++) {
            $nbvalues++;
        }
    }
    if ($total != $nbvalues) {
        print("Number missing\n");
        return 1;
    }
    else {
        return $coordinates;
    }
}

function isFileEmpty($arr) {
    clearstatcache();
    if(filesize($arr)) {
        return 0;
    }
    return 1;
}

function delComms(&$arr) {
    $i = 0;
    $nbElem = count($arr);
    while ($i < $nbElem) {
        // $arr[$i] = preg_replace('/\s+/', '', $arr[$i]);
        if ($arr[$i][0] == '#' || $arr[$i] == NULL) {
            unset($arr[$i]);
        }
        else if (($pos = strpos($arr[$i], '#')) !== FALSE) {
            $arr[$i] = substr($arr[$i], 0 , $pos);
        }
        $i++;
    }
    $arr = array_values($arr);
}
 ?>
