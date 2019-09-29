<?php 

    function findZero($grid) {
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

    function createNode($grid, $strParent, $g, $m) {
        $node["grid"] = $grid;
        $node["h"] = manhattan_state($grid);
        $node["pos0"] = findZero($grid);
        $node["parent"] = $strParent;
        $node["g"] =  $g + 1;
        $node["f"] = $node["g"] + $node["h"];
        // echo "valeur de move : " . $m . "\n";
        $node["move"] = $m;
        return $node;
    }

    function createChildren($node) {
        // $grid = $node["grid"];
        $strNode = gridToStr($node["grid"]);
        // print_r($node);
        $x0 = $node["pos0"]["x0"];
        $y0 = $node["pos0"]["y0"];
        $g = $node["g"];
        $children = array();
        // echo "valeur de x0 : " . $node["pos0"]["x0"]  . "\n";
        // echo "valeur de move : " . $node["move"] . "\n";

        if ($node["pos0"]["x0"] > 0 && $node["move"] != 'l') {
            // echo "test\n";
            $tmp = $node["grid"][$y0][$x0 - 1];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0][$x0 - 1] = 0;            
            $children[] = createNode($tmpGrid, $strNode, $g, 'r');
            unset($tmpGrid);
            // gauche
        }
        if ($node["pos0"]["x0"] < ($GLOBALS["nbN"] - 1) && $node["move"] != 'r') {
            $tmp = $node["grid"][$y0][$x0 + 1];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0][$x0 + 1] = 0;            
            $children[] = createNode($tmpGrid, $strNode, $g, 'l');
            unset($tmpGrid);
            // droite
        }
        if ($node["pos0"]["y0"] > 0 && $node["move"] != 't') {
            $tmp = $node["grid"][$y0 - 1][$x0];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0 - 1][$x0] = 0;            
            $children[] = createNode($tmpGrid, $strNode, $g, 'b');
            unset($tmpGrid);
            // haut
        }
        if ($node["pos0"]["y0"] < ($GLOBALS["nbN"] - 1) && $node["move"] != 'b') {
            $tmp = $node["grid"][$y0 + 1][$x0];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0 + 1][$x0] = 0;            
            $children[] = createNode($tmpGrid, $strNode, $g, 't');
            unset($tmpGrid);
            // bas
        }
        return $children;
    }

    function path($process, $closedList) {
        printGrid($process["grid"], $GLOBALS["nbN"]);
        echo "\n";
        $str = $process["parent"];
        $i = 0;
        while ($str != "start") {
            printGrid($closedList[$str]["grid"], $GLOBALS["nbN"]);
            echo "\n";
            $str = $closedList[$str]["parent"];
            $i++;
        }
        echo "Number of moves required : " . $i . "\n";
    }

    function checkInOpen($openList, $node) {
        $foundIt = -1;
        $openList->rewind();
        // echo "oh merde\n";
        while ($openList->valid()) {
            if ($openList->current()["grid"] == $node["grid"]) {
                // echo "ici\n";
                $foundIt = $openList->key();
                break;
            }
            $openList->next();
        }
        return $foundIt;
    }

    function algo($startNode) {
        $openList = new SplDoublyLinkedList();
        $openList->push($startNode);
        $closedList = array();

        while (!$openList->isEmpty()) {
            // print_r($openList) ;
            // echo "nb elem in openList : " . $openList->count() . "\n";
            $process = $openList->offsetGet(0);
            // print_r($process);
            if ($process["h"] == 0) {
                path($process, $closedList);
                echo "complexity in time : " . count($closedList);
                echo "\n";
                $tmp = count($closedList) + $openList->count();
                echo "complexity in size : " . $tmp . "\n";
                return;
            }
            $openList->offsetUnset(0);
            // print_r($openList) ;

            $closedList[gridToStr($process["grid"])] = $process;
            $children = createChildren($process);
            // print_r($children);
            // echo "//////////////////////////////////////////////////////////\n";
            foreach ($children as $child) {
                $tmpStr = gridToStr($child["grid"]);
                if (!array_key_exists($tmpStr, $closedList)) {
                            // break bug
                    if (($index = checkInOpen($openList, $child)) == -1) {
                        // echo "ici\n";
                        $openList->rewind();
                        while ($openList->current()["f"] < $child["f"] && $openList->valid()) {
                            // echo "/////////////////////////////////////////////////////\n";
                            $openList->next();
                        }
                        // echo "KEY IS : " . $openList->key() . "\n";
                        // while ($openList->current()["h"] < $child['h'] && $openList->current()["f"] == $child['f']) {
                        //     $openList->next();
                        // }
                        $openList->add($openList->key(), $child);
                        $openList->rewind();
                    } else {
                        if ($child["g"] < $openList->offsetGet($index)["g"]) {
                            print_r($openList);
                            printGrid($child["grid"], $GLOBALS["nbN"]);
                            echo "index = " . $index . "\n";
                            $openList->offsetUnset($index);
                            $openList->rewind();
                            // echo "child g = " . $child['g'] . "\n" . "current de g = " . $openList->offsetGet($index)["g"] . "\n";;
                            while ($openList->current()["f"] < $child["f"] && $openList->valid()) {
                                // echo "/////////////////////////////////////////////////////\n";
                                $openList->next();
                            }
                            echo "KEY IS : " . $openList->key() . "\n";
                            // while ($openList->current()["h"] < $child['h'] && $openList->current()["f"] == $child['f']) {
                            //     $openList->next();
                            // }
                            $openList->add($openList->key(), $child);
                            $openList->rewind();
                            print_r($openList);
                            sleep(100);
                        }
                    }
                }
            }
            unset($children);
            $openList->rewind();
        }
        echo "Not possible to reach goal\n";
        return;
    }
    4  2  3  10
    1  13 14 6
    8  11 12 5
    7  9  0  15
    
?>