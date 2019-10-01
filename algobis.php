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
        $node["f"] =  $node["h"]; // + $node["g"]
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
            printGrid(json_decode($closedList[$str], TRUE)["grid"], $GLOBALS["nbN"]);
            echo "\n";
            $str = json_decode($closedList[$str], TRUE)["parent"];
            $i++;
            // break;
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
        $openListBis[$gridStr] = json_encode($startNode);
        $closedList = array();
        // $GLOBALS["maxInt"] = 

        while (!$openList->isEmpty()) {
            $c = $openList->count();
            // echo "nb elem in openList : " . $c . "\n";
            // echo "nb elem in openListBis : " . count($openListBis) . "\n";
            
            $str = $openList->extract();
            while (!array_key_exists($str, $openListBis)) {
                $str = $openList->extract();
            }
            // echo $str . "\n"; 
            // print_r($openListBis);
            $process = json_decode($openListBis[$str], TRUE);
            // echo "valeur de f recuperee : " . $process["f"] . "\n";
            // echo "valeur de g recuperee : " . $process["g"] . "\n";
            if ($process["h"] == 0) {
                path($process, $closedList);
                echo "complexity in time : " . count($closedList);
                echo "\n";
                $tmp = count($closedList) + $openList->count();
                echo "complexity in size : " . $tmp . "\n";
                return;
            }
            unset($openListBis[$str]);

            $closedList[$str] = json_encode($process);
            $children = createChildren($process);
            // print_r($children);
            foreach ($children as $child) {
                $tmpStr = gridToStr($child["grid"]);
                if (!array_key_exists($tmpStr, $closedList)) {
                            // break bug
                    if (!array_key_exists($tmpStr, $openListBis)) {
                        // $openList->insert($tmpStr, array(-1 * $child['f'], -1 * $child['h']));
                        $openList->insert($tmpStr, -1 * $child['f']);
                        $openListBis[$tmpStr] =  json_encode($child);
                    } else {
                        $actualNode = json_decode($openListBis[$tmpStr], TRUE);
                        if ($child["g"] < $actualNode["g"]) {
                            // echo "child g = " . $child['g'] . "\n" . "current de g = " . json_decode($openListBis[$tmpStr], TRUE)["g"] . "\n";;
                            // $openList = test($openList, $tmpStr);
                            // $openList->setExtractFlags(SplPriorityQueue::EXTR_DATA);
                            $openList->insert($tmpStr, -1 * $child['f']);

                            // unset($openListBis[$tmpStr]);
                            $openListBis[$tmpStr] =  json_encode($child);
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

    // function test($list, $gridStr) {
    //     $newList = new PQtest;
    //     $list->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
    //     while (!$list->isEmpty()) {
    //         $tmp = $list->extract();
    //         if ($tmp["data"] != $gridStr) {
    //             $newList->insert($tmp["data"], $tmp["priority"]);
    //         }
    //     }
    //     return $newList;
    // }

    // function idaAlgo($startNode) {
    //     $threshold = manhattan_state($startNode["grid"]);
    //     while (1) {

    //     }
    // }

?>