<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pickups Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ContainersTable|\Cake\ORM\Association\BelongsToMany $Containers
 *
 * @method \App\Model\Entity\Pickup get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pickup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pickup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pickup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pickup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pickup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pickup findOrCreate($search, callable $callback = null, $options = [])
 */
class PickupsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('pickups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id'
        ]);
        $this->belongsTo('Dropoffs', [
            'foreignKey' => 'dropoff_id'
        ]);

        $this->belongsToMany('Containers', [
            'through' => 'PickupsContainers',
            'saveStrategy' => 'replace'
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
            ->numeric('pounds')
            ->requirePresence('pounds', 'create')
            ->notEmpty('pounds');

        $validator
            ->requirePresence('dropoff_id', 'create')
            ->notEmpty('dropoff_id');

        $validator
            ->dateTime('pickup_date')
            ->allowEmpty('pickup_date');

        $validator
            ->allowEmpty('note');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));

        return $rules;
    }
}
