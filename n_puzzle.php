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
        if (!parse_file($argv[1])) {
            ;
        }
        else {
            echo "Parsing error\n";
            return 1;
        }
    }
    else {
        echo "File is empty\n";
        return 1;
    }


function parse_file($argv) {
    $fileArr = file($argv);
    delComms($fileArr);
    $total = $fileArr[0];
    unset($fileArr[0]);
    $str = implode("", $fileArr);
    $str = preg_replace('/\s+/', '', $str);
    if ($total != strlen($str)) {
        print("Number missing\n");
        return 1;
    }
    else {
        return 0;
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
