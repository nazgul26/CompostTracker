<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PileTemperatures Model
 *
 * @property \App\Model\Table\PilesTable&\Cake\ORM\Association\BelongsTo $Piles
 *
 * @method \App\Model\Entity\PileTemperature get($primaryKey, $options = [])
 * @method \App\Model\Entity\PileTemperature newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PileTemperature[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PileTemperature|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PileTemperature saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PileTemperature patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PileTemperature[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PileTemperature findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PileTemperaturesTable extends Table
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

        $this->setTable('pile_temperatures');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Piles', [
            'foreignKey' => 'pile_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('temp1')
            ->allowEmptyString('temp1');

        $validator
            ->integer('temp2')
            ->allowEmptyString('temp2');

        $validator
            ->integer('temp3')
            ->allowEmptyString('temp3');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 255)
            ->allowEmptyString('comment');

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
        $rules->add($rules->existsIn(['pile_id'], 'Piles'));

        return $rules;
    }
}
