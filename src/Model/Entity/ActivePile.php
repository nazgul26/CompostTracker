<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActivePile Entity
 *
 * @property int $id
 * @property int|null $pile_id
 * @property string|null $comment
 *
 * @property \App\Model\Entity\Pile $pile
 */
class ActivePile extends Entity
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
        'pile_id' => true,
        'comment' => true,
        'pile' => true,
    ];
}
