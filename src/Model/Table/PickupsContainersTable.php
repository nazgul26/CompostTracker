<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PickupsContainers Model
 *
 * @property \App\Model\Table\PickupsTable|\Cake\ORM\Association\BelongsTo $Pickups
 * @property \App\Model\Table\ContainersTable|\Cake\ORM\Association\BelongsTo $Containers
 *
 * @method \App\Model\Entity\PickupsContainer get($primaryKey, $options = [])
 * @method \App\Model\Entity\PickupsContainer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PickupsContainer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PickupsContainer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PickupsContainer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PickupsContainer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PickupsContainer findOrCreate($search, callable $callback = null, $options = [])
 */
class PickupsContainersTable extends Table
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

        $this->setTable('pickups_containers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Pickups', [
            'saveStrategy' => 'replace'
        ]);
        $this->belongsToMany('Containers');
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
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

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
        $rules->add($rules->existsIn(['pickup_id'], 'Pickups'));
        $rules->add($rules->existsIn(['container_id'], 'Containers'));

        return $rules;
    }
}
