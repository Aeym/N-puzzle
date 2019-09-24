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
        $node["g"] = $strParent == "start" ? $g : $g + 1;
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
        while ($str != "start") {
            printGrid($closedList[$str]["grid"], $GLOBALS["nbN"]);
            echo "\n";
            $str = $closedList[$str]["parent"];
        }
    }

    function algo($startNode) {
        $openList = new SplDoublyLinkedList();
        // $openListBis = array();
        $openList->push($startNode);
        $openListBis[gridToStr($startNode["grid"])] = $startNode;
        // $closedList = array();

        while (!$openList->isEmpty()) {
            // echo "ici\n";
            // echo "nb elem dans la liste : " . $openList->count() . "\n";
            // echo "test\n";
            $process = $openList->offsetGet(0);
            // echo "on est la \n";
            // print_r($process);
            if ($process["h"] == 0) {
                path($process, $closedList);
                return;
            }
            //echo count($openListBis) ."\n";
            //sleep(0.5);
            $openList->offsetUnset(0);
            unset($openListBis[gridToStr($process["grid"])]);
            $closedList[gridToStr($process["grid"])] = $process;
            $children = createChildren($process);
            foreach ($children as $child) {
                // echo "la\n";
                $tmpStr = gridToStr($child["grid"]);
                if (!array_key_exists($tmpStr, $closedList)) {
                            // break bug
                    if (!array_key_exists($tmpStr, $openListBis)) {
                        $openList->rewind();
                        $c = $openList->count();
                        while ($openList->current()["f"] < $child["f"] && $openList->key() < $c) {
                            $openList->next();
                        }
                        $openList->add($openList->key(), $child);
                        // $openList->push($child);
                        $openListBis[gridToStr($child["grid"])] = $child;
                    } else {
                        $actualNode = &$openListBis[$tmpStr]; // & adresse memoire
                        if ($child["g"] < $actualNode["g"]) {
                            $actualNode["g"] = $child["g"];
                            $actualNode["f"] = $child["f"];
                            $actualNode["parent"] = $child["parent"];
                        }
                    }
                }
              //  else{
                ///    foreach ($closedList as $node) {
                   //     printGrid($node["grid"], $GLOBALS["nbN"]);
                     //   echo "\n";
                   // }
                   // sleep(1);
                  //  break;
           //     }
                // print_r($child);
                // sleep(1);
            }
            unset($children);
        }
        echo "Not possible to reach goal\n";
        return;
    }

?>