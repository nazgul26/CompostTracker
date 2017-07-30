<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PickupsContainer Entity
 *
 * @property int $id
 * @property int $pickup_id
 * @property int $container_id
 * @property int $quantity
 *
 * @property \App\Model\Entity\Pickup $pickup
 * @property \App\Model\Entity\Container $container
 */
class PickupsContainer extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
