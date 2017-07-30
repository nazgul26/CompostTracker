<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PickupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PickupsTable Test Case
 */
class PickupsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PickupsTable
     */
    public $Pickups;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pickups',
        'app.users',
        'app.locations',
        'app.sites',
        'app.clients',
        'app.containers',
        'app.locations_containers',
        'app.pickups_containers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Pickups') ? [] : ['className' => PickupsTable::class];
        $this->Pickups = TableRegistry::get('Pickups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pickups);

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
