<?php
use Migrations\AbstractMigration;

class AlterUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {        
        $users = $this->table('users');
        
               $users->addColumn('title', 'integer', [
                    'default' => null,
                    'limit' => 11,
                    'null' => true
               ])
                ->save();

    }
}
