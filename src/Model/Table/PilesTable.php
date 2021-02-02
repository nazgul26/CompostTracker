<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivePiles Model
 *
 * @property \App\Model\Table\PilesTable&\Cake\ORM\Association\BelongsTo $Piles
 *
 * @method \App\Model\Entity\ActivePile get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivePile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActivePile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivePile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivePile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivePile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivePile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivePile findOrCreate($search, callable $callback = null, $options = [])
 */
class PilesTable extends Table
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

        $this->setTable('piles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PileLocations', [
            'foreignKey' => 'pile_location_id',
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
