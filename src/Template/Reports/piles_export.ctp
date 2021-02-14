<?php
$this->layout('ajax');

echo "Date, Time, Action, Pile ID, Details, User\n";

foreach ($piles as $pile):
    echo $pile->created->format('m/d/Y') . "," .
         $pile->created->format('H:i') . ",".
         "Build," . 
         $pile->pile_location->name . "," .
         $pile->comments . "," .
         $pile->user->username;
    echo "\n";
    foreach ($pile->pile_temperatures as $temp) {
        echo $temp->created->format('m/d/Y') . "," .
        $temp->created->format('H:i') . ",".
        "Temperature Read," . 
        $pile->pile_location->name . "," .
        "Temps: $temp->temp1 -- $temp->temp2 -- $temp->temp3," . 
        $temp->user->username;
        echo "\n";
    }
    foreach ($pile->pile_turns as $turn) {
        echo $turn->created->format('m/d/Y') . "," .
        $turn->created->format('H:i') . ",".
        "Turned," . 
        $pile->pile_location->name . "," .
        "," . 
        $turn->user->username;
        echo "\n";
    }
endforeach; ?>