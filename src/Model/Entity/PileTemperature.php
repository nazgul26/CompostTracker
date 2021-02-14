<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PileTemperature Entity
 *
 * @property int $id
 * @property int|null $pile_id
 * @property int|null $temp1
 * @property int|null $temp2
 * @property int|null $temp3
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\Pile $pile
 */
class PileTemperature extends Entity
{
    protected $_accessible = [
        'pile_id' => true,
        'temp1' => true,
        'temp2' => true,
        'temp3' => true,
        'comment' => true,
        'created' => true,
        'pile' => true,
        'user_id' => true
    ];
}
