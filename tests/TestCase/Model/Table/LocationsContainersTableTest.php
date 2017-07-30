<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationsContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationsContainersTable Test Case
 */
class LocationsContainersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationsContainersTable
     */
    public $LocationsContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.locations_containers',
        'app.locations',
        'app.sites',
        'app.clients',
        'app.pickups',
        'app.users',
        'app.containers',
        'app.pickups_containers',
        'app.pickups_pickups_containers',
        'app.containers_pickups_containers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LocationsContainers') ? [] : ['className' => LocationsContainersTable::class];
        $this->LocationsContainers = TableRegistry::get('LocationsContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LocationsContainers);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
