<?php

use Phinx\Seed\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;

class UsersSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'username'    => 'admin',
                'email'  => 'admin@yourcompany.com',
                'access_level' => 90,
                'password' => (new DefaultPasswordHasher)->hash("passwd")
            ]
        ];

        $posts = $this->table('users');
        $posts->insert($data)
              ->save();
    }
}