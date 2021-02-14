<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PileTemperaturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PileTemperaturesTable Test Case
 */
class PileTemperaturesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PileTemperaturesTable
     */
    public $PileTemperatures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PileTemperatures',
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
        $config = TableRegistry::getTableLocator()->exists('PileTemperatures') ? [] : ['className' => PileTemperaturesTable::class];
        $this->PileTemperatures = TableRegistry::getTableLocator()->get('PileTemperatures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PileTemperatures);

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
