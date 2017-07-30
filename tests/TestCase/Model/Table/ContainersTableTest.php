<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContainersTable Test Case
 */
class ContainersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContainersTable
     */
    public $Containers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.containers',
        'app.locations',
        'app.sites',
        'app.clients',
        'app.pickups',
        'app.users',
        'app.pickups_containers',
        'app.pickups_pickups_containers',
        'app.containers_pickups_containers',
        'app.locations_containers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Containers') ? [] : ['className' => ContainersTable::class];
        $this->Containers = TableRegistry::get('Containers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Containers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
