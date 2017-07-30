<?php
$this->layout('ajax');
echo "Client, Site, Location, Pickup Date, Pounds, Containers\n";

foreach ($pickups as $pickup):
    echo $pickup->location->site->client->name . ", ";
    echo $pickup->location->site->name . ", ";
    echo $pickup->location->name . ", ";
    echo $pickup->pickup_date->i18nFormat('yyyy-MM-dd') . ", ";
    echo $pickup->pounds . ", ";
    foreach ($pickup->containers as $container) {
        echo $container->name . " - ";
    }
    echo "\n";
endforeach; ?>


