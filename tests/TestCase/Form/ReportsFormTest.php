<?php
namespace App\Test\TestCase\Form;

use App\Form\ReportsForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\ReportsForm Test Case
 */
class ReportsFormTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Form\ReportsForm
     */
    public $Reports;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Reports = new ReportsForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Reports);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
