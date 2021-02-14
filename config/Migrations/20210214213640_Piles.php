<?php
use Migrations\AbstractMigration;

class Piles extends AbstractMigration
{
    public function up()
    {
        $this->table('pile_locations')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('pile_temperatures')
            ->addColumn('pile_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('temp1', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('temp2', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('temp3', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('comment', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('pile_turns')
            ->addColumn('pile_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('piles')
            ->addColumn('pile_location_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('comment', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('active', 'string', [
                'default' => 'b\'1\'',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('turn_status', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('total_turns', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('turned_last', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('temp_last', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('done_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();


    }

    public function down()
    {
        $this->table('pile_locations')->drop()->save();
        $this->table('pile_temperatures')->drop()->save();
        $this->table('pile_turns')->drop()->save();
        $this->table('piles')->drop()->save();
    }
}
