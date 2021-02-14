<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Pile extends Entity
{
    protected $_accessible = [
        'pile_location_id' => true,
        'comment' => true,
        'pile' => true,
        'user_id' => true,
        'created' => true,
        'pile_location_id' => true,
        'active' => true,
        'total_turns' => true,
        'turn_status' => true,
        'turn_last' => true,
        'temp_last' => true
    ];
}
