<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PickupsContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PickupsContainersTable Test Case
 */
class PickupsContainersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PickupsContainersTable
     */
    public $PickupsContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pickups_containers',
        'app.pickups',
        'app.users',
        'app.locations',
        'app.sites',
        'app.clients',
        'app.containers',
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
        $config = TableRegistry::exists('PickupsContainers') ? [] : ['className' => PickupsContainersTable::class];
        $this->PickupsContainers = TableRegistry::get('PickupsContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PickupsContainers);

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
