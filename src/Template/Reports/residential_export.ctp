<?php
$this->layout('ajax');

echo "Name, Street 1, Street 2, City, State, Zip, New\n";

foreach ($users as $user):
    echo $user->first_name .  " " . $user->last_name . ", " . 
        $user->address->street1 . ", " . $user->address->street2 . ", " . 
        $user->address->city . ", " . $user->address->state . ", " . $user->address->zip . ", ";
    // New User
    if (strtotime($user->created) > strtotime('-7 day')) {
        echo "Yes";
    } else {
        echo "No";
    }
    echo "\n";
endforeach; ?>