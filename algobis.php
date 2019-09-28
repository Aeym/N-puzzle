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
            // json_decode(gzdecode($openListBis[$tmpStr]), TRUE)["g"]
            printGrid(json_decode(gzdecode($closedList[$str]), TRUE)["grid"], $GLOBALS["nbN"]);
            echo "\n";
            $str = json_decode(gzdecode($closedList[$str]), TRUE)["parent"];
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

    class PQtest extends SplPriorityQueue 
{ 
    protected $serial = PHP_INT_MAX;

    public function insert($value, $priority) {
        parent::insert($value, array($priority, $this->serial--));
    }

    public function compare($priority1, $priority2) 
    { 
        if ($priority1 === $priority2) return 0; 
        return $priority1 < $priority2 ? -1 : 1; 
    } 
} 

    function algo($startNode) {
        $openList = new PQtest();
        $openList->setExtractFlags(SplPriorityQueue::EXTR_DATA);
        $gridStr = gridToStr($startNode["grid"]);
        // $openList->insert($gridStr, array(-1 * $startNode['f'], -1 * $startNode['h']));
        $openList->insert($gridStr, -1 * $startNode['f']);
        $openListBis[$gridStr] = gzencode(json_encode($startNode));
        $closedList = array();
        // $GLOBALS["maxInt"] = 

        while (!$openList->isEmpty()) {
            // $openList->rewind();
            // print_r($openList);
            $c = $openList->count();
            // echo "nb elem in openList : " . $c . "\n";
            // if ($c % 10000 == 0) {
            //     print_r(json_decode(gzdecode($openListBis[$openList->current()])));
            //     sleep(5);
            // }
            // echo "nb elem in openListBis : " . count($openListBis) . "\n";
            $str = $openList->extract();
            $process = json_decode(gzdecode($openListBis[$str]), TRUE);
            // print_r($process);
            // break;
            unset($openListBis[$str]);
            // print_r($process);
            if ($process["h"] == 0) {
                // echo "la";
                // break;
                path($process, $closedList);
                echo "complexity in time : " . count($closedList);
                echo "\n";
                $tmp = count($closedList) + $openList->count();
                echo "complexity in size : " . $tmp . "\n";
                return;
            }
            $closedList[$str] = gzencode(json_encode($process));
            $children = createChildren($process);
            // print_r($children);
            // echo "//////////////////////////////////////////////////////////\n";
            foreach ($children as $child) {
                $tmpStr = gridToStr($child["grid"]);
                if (!array_key_exists($tmpStr, $closedList)) {
                            // break bug
                    if (!array_key_exists($tmpStr, $openListBis)) {
                        // echo "ici\n";
                        // $openList->rewind();
                        // while ($openList->current()["f"] <= $child["f"] && $openList->current()["h"] < $child['h'] && $openList->valid()) {
                        //     // echo "la";
                        //     $openList->next();
                        // }
                        // $openList->insert($tmpStr, array(-1 * $child['f'], -1 * $child['h']));
                        $openList->insert($tmpStr, -1 * $child['f']);
                        $openListBis[$tmpStr] =  gzencode(json_encode($child));
                    } else {
                        if ($child["g"] < json_decode(gzdecode($openListBis[$tmpStr]), TRUE)["g"]) {
                            // echo "child g = " . $child['g'] . "\n" . "current de g = " . $openListBis[$tmpStr]["g"] . "\n";;
                            $openListBis[$tmpStr] =  gzencode(json_encode($child));
                        }
                    }
                }
            }
            unset($children);
            // $openList->rewind();
        }
        echo "Not possible to reach goal\n";
        return;
    }

    // function idaAlgo($startNode) {
    //     $threshold = manhattan_state($startNode["grid"]);
    //     while (1) {

    //     }
    // }

?>