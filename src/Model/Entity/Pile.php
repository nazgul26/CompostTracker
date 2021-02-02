<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Pile extends Entity
{
    protected $_accessible = [
        'pile_location_id' => true,
        'comment' => true,
        'pile' => true,
    ];
}
