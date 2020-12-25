<?php
use Migrations\AbstractSeed;

/**
 * Container seed.
 */
class ContainerSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Bucket',
                'gallons' => '5',
                'weight' => '1',
            ],
            [
                'id' => '2',
                'name' => 'Bin',
                'gallons' => '17',
                'weight' => '2',
            ],
            [
                'id' => '3',
                'name' => 'Small Toter',
                'gallons' => '32',
                'weight' => '2',
            ],
            [
                'id' => '4',
                'name' => 'Toter',
                'gallons' => '64',
                'weight' => '3',
            ],
            [
                'id' => '5',
                'name' => 'Slim Jim',
                'gallons' => '22',
                'weight' => '2',
            ],
        ];

        $table = $this->table('containers');
        $table->insert($data)->save();
    }
}
