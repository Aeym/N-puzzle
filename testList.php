<?php

/*
* Examples of DoublyLinkedList
*/

$obj = new SplDoublyLinkedList();
// Check wither linked list is empty
if ($obj->isEmpty())
{
    echo "Adding nodes to Linked List<br>";
    $obj->push(2);
    $obj->push(3);
    echo "Adding the node at beginning of doubly linked list <br>";
    $obj->unshift(10);
}

echo "<br>Our Linked List:";
print_r($obj);

$curr = $obj->current(); // this will return NULL as we have not set initial node.

echo "<br> Rewinding the position so that current node points to first node ";
$obj->rewind();

echo "<br>Current node of the linked list:";
echo  $obj->current(); // this will print first node of the linked list.

echo "<br>Moving to Next node:";
$obj->next();

echo "<br>Printing the next node:";
echo $obj->current();

?>
