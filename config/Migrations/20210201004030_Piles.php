<?php
use Migrations\AbstractMigration;

class Piles extends AbstractMigration
{

    public function up()
    {

        $this->table('piles')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();
    }

    public function down()
    {

        $this->table('piles')->drop()->save();
    }
}

