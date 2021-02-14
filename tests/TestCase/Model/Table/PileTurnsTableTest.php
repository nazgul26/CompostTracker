<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PileTurnsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PileTurnsTable Test Case
 */
class PileTurnsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PileTurnsTable
     */
    public $PileTurns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PileTurns',
        'app.Piles',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PileTurns') ? [] : ['className' => PileTurnsTable::class];
        $this->PileTurns = TableRegistry::getTableLocator()->get('PileTurns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PileTurns);

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
