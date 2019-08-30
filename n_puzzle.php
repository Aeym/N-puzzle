<?php

$nbN = 0;

if (!file_exists($argv[1])) {
    echo "File doesn't exist\n";
    return 1;
}
if (!preg_match("/.txt/", $argv[1])) {
    echo "Wrong file extension\n";
    return 1;
}
if (isFileEmpty($argv[1]) != 0) {
    $fileArr = file($argv[1]);
    delComms($fileArr);
    $arrData = parse($fileArr);
    print_r($arrData);
    echo "nbN = " . $GLOBALS["nbN"] . "\n";
} else {
  echo "File is empty\n";
}


function isFileEmpty($arr) {
    clearstatcache();
    if(filesize($arr)) {
        return 1;
    }
    return 0;
}

function parse($arr) {
  $tmpArr = array();

  foreach ($arr as $value) {
    $tmp = explode(' ', $value);
    if (count($tmp) > 1) {
      $tmpArr[] = $tmp;
    } else {
      $GLOBALS["nbN"] = $value;
    }
  }
  return $tmpArr;
}

function delComms(& $arr) {
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
