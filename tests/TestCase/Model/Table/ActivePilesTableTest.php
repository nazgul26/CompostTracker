<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivePilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivePilesTable Test Case
 */
class ActivePilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivePilesTable
     */
    public $ActivePiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ActivePiles',
        'app.Piles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ActivePiles') ? [] : ['className' => ActivePilesTable::class];
        $this->ActivePiles = TableRegistry::getTableLocator()->get('ActivePiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ActivePiles);

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
