<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Collection Entity
 *
 * @property int $id
 * @property int $customer_user_id
 * @property int $worker_user_id
 * @property float $pounds
 * @property \Cake\I18n\FrozenTime $pickup_date
 * @property string $note
 *
 * @property \App\Model\Entity\CustomerUser $customer_user
 * @property \App\Model\Entity\WorkerUser $worker_user
 */
class Subscriber extends Entity
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
