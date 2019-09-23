<?php

    $tmp = array("content" => "test", "pointeur" => "0");
    $tmp1 = array("content" => "test2", "pointeur" => &$tmp);

    print_r($tmp1["pointeur"]);
    $tmp1["pointeur"] = 2;
    print_r($tmp1);
    print_r($tmp);


?>