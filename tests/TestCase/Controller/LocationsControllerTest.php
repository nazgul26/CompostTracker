<?php
namespace App\Test\TestCase\Controller;

use App\Controller\LocationsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\LocationsController Test Case
 */
class LocationsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.locations',
        'app.sites',
        'app.clients',
        'app.pickups',
        'app.users',
        'app.containers',
        'app.locations_containers',
        'app.pickups_containers',
        'app.pickups_pickups_containers',
        'app.containers_pickups_containers'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
