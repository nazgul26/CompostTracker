<?php namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubscribersTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->addBehavior('Timestamp');
        $this->setTable('subscribers');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('username', 'A username is required')
            ->notEmpty('password', 'A password is required');
    }

}