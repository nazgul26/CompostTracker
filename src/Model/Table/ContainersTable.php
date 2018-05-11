<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Containers Model
 *
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsToMany $Locations
 * @property \App\Model\Table\PickupsTable|\Cake\ORM\Association\BelongsToMany $Pickups
 *
 * @method \App\Model\Entity\Container get($primaryKey, $options = [])
 * @method \App\Model\Entity\Container newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Container[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Container|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Container patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Container[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Container findOrCreate($search, callable $callback = null, $options = [])
 */
class ContainersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('containers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Locations', [
            'foreignKey' => 'container_id',
            'targetForeignKey' => 'location_id',
            'joinTable' => 'locations_containers'
        ]);
        $this->belongsToMany('Pickups', [
            'foreignKey' => 'container_id',
            'targetForeignKey' => 'pickup_id',
            'through' => 'PickupsContainers'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('gallons')
            ->requirePresence('gallons', 'create')
            ->notEmpty('gallons');

        return $validator;
    }
}
