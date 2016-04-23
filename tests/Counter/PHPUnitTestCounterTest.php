<?php

namespace PHPUnitDesktopNotifier\Counter;

class PHPUnitTestCounterTest extends \PHPUnit_Framework_TestCase
{
    /** @var PHPUnitTestCounter $phpUnitTestCounter */
    protected $phpUnitTestCounter;

    /** @var \ReflectionProperty */
    private $nbStartedTestReflectionProperty;

    /** @var \ReflectionProperty */
    private $nbErrorTestReflectionProperty;

    /** @var \ReflectionProperty */
    private $nbFailureTestReflectionProperty;

    /** @var \ReflectionProperty */
    private $nbStartedTestSuiteReflectionProperty;

    /** @var \ReflectionProperty */
    private $nbEndedTestSuiteReflectionProperty;

    /** @var \ReflectionProperty */
    private $nbAssertReflectionProperty;

    /**
     * setUp
     */
    protected function setUp()
    {
        parent::setUp();

        $class = new \ReflectionClass('PHPUnitDesktopNotifier\Counter\PHPUnitTestCounter');

        $this->nbStartedTestReflectionProperty = $class->getProperty('nbStartedTest');
        $this->nbStartedTestReflectionProperty->setAccessible(true);

        $this->nbErrorTestReflectionProperty = $class->getProperty('nbErrorTest');
        $this->nbErrorTestReflectionProperty->setAccessible(true);

        $this->nbFailureTestReflectionProperty = $class->getProperty('nbFailureTest');
        $this->nbFailureTestReflectionProperty->setAccessible(true);

        $this->nbStartedTestSuiteReflectionProperty = $class->getProperty('nbStartedTestSuite');
        $this->nbStartedTestSuiteReflectionProperty->setAccessible(true);

        $this->nbEndedTestSuiteReflectionProperty = $class->getProperty('nbEndedTestSuite');
        $this->nbEndedTestSuiteReflectionProperty->setAccessible(true);

        $this->nbAssertReflectionProperty = $class->getProperty('nbAssert');
        $this->nbAssertReflectionProperty->setAccessible(true);

        $this->phpUnitTestCounter = new PHPUnitTestCounter();
    }

    /** @test */
    public function it_should_increment_the_number_of_started_test()
    {
        $this->phpUnitTestCounter->incrementNbStartedTest();

        $this->assertEquals(1, $this->nbStartedTestReflectionProperty->getValue($this->phpUnitTestCounter));
    }

    /** @test */
    public function it_should_increment_the_number_of_error_test()
    {
        $this->phpUnitTestCounter->incrementNbErrorTest();

        $this->assertEquals(1, $this->nbErrorTestReflectionProperty->getValue($this->phpUnitTestCounter));
    }

    /** @test */
    public function it_should_increment_the_number_of_failed_test()
    {
        $this->phpUnitTestCounter->incrementNbFailureTest();

        $this->assertEquals(1, $this->nbFailureTestReflectionProperty->getValue($this->phpUnitTestCounter));
    }

    /** @test */
    public function it_should_increment_the_number_of_started_test_suite()
    {
        $this->phpUnitTestCounter->incrementNbStartedTestSuite();

        $this->assertEquals(1, $this->nbStartedTestSuiteReflectionProperty->getValue($this->phpUnitTestCounter));
    }

    /** @test */
    public function it_should_increment_the_number_of_ended_test_suite()
    {
        $this->phpUnitTestCounter->incrementNbEndedTestSuite();

        $this->assertEquals(1, $this->nbEndedTestSuiteReflectionProperty->getValue($this->phpUnitTestCounter));
    }

    /** @test */
    public function it_should_return_false_as_nbEndedTestSuite_is_smaller_than_nbStartedTestSuite()
    {
        $this->nbStartedTestSuiteReflectionProperty->setValue($this->phpUnitTestCounter, 3);
        $this->nbEndedTestSuiteReflectionProperty->setValue($this->phpUnitTestCounter, 2);

        $this->assertFalse($this->phpUnitTestCounter->isEveryTestFinished());
    }

    /** @test */
    public function it_should_return_true_as_nbEndedTestSuite_is_bigger_than_nbStartedTestSuite()
    {
        $this->nbStartedTestSuiteReflectionProperty->setValue($this->phpUnitTestCounter, 2);
        $this->nbEndedTestSuiteReflectionProperty->setValue($this->phpUnitTestCounter, 3);

        $this->assertTrue($this->phpUnitTestCounter->isEveryTestFinished());
    }

    /** @test */
    public function it_should_return_the_sum_of_nbErrorTest_and_nbFailureTest()
    {
        $this->nbErrorTestReflectionProperty->setValue($this->phpUnitTestCounter, 2);
        $this->nbFailureTestReflectionProperty->setValue($this->phpUnitTestCounter, 3);

        $this->assertSame(5, $this->phpUnitTestCounter->getNbFailure());
    }

    /** @test */
    public function it_should_add_some_assert()
    {
        $this->phpUnitTestCounter->addAssert(2);
        $this->assertSame(2, $this->nbAssertReflectionProperty->getValue($this->phpUnitTestCounter));

        $this->phpUnitTestCounter->addAssert(3);
        $this->assertSame(5, $this->nbAssertReflectionProperty->getValue($this->phpUnitTestCounter));
    }
}
