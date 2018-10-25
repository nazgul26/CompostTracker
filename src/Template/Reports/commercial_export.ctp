<?php
$this->layout('ajax');

echo "Client, Site, Pickup Location, Pickup Date, Drop Off Location, Pounds, Lbs. Co2 Diverted ";

foreach ($containers as $container=>$key) {
    echo "," . $key;
}
echo ", Notes\n";

foreach ($pickups as $pickup):
    echo $pickup->location->site->client->name . ", ";
    echo $pickup->location->site->name . ", ";
    echo $pickup->location->name . ", ";
    echo $pickup->pickup_date->i18nFormat('yyyy-MM-dd') . ", ";
    echo (isset($pickup->dropoff->name) ?  $pickup->dropoff->name : 'N/A') . ", ";
    echo $pickup->pounds . ", ";
    echo ($pickup->pounds * .72) . ",";
    foreach ($containers as $container=>$key) {
        $quantity = "";
        foreach ($pickup->containers as $container) {
            if ($container->name == $key)
                $quantity = $container["_joinData"]->quantity;
        }
        echo $quantity . ",";
    }
    echo $pickup->note . ", ";
    echo "\n";
endforeach; ?>


