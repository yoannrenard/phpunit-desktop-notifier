<?php

namespace PHPUnitDesktopNotifier\Counter;

/**
 * Class PHPUnitTestCounter
 *
 * @package PHPUnitDesktopNotifier\Counter
 */
class PHPUnitTestCounter implements PHPUnitTestCounterInterface
{
    /** @var int */
    private $nbStartedTest;

    /** @var int */
    private $nbErrorTest;

    /** @var int */
    private $nbFailureTest;

    /** @var int */
    private $nbStartedTestSuite;

    /** @var int */
    private $nbEndedTestSuite;

    public function __construct()
    {
        $this->nbStartedTest      = 0;
        $this->nbErrorTest        = 0;
        $this->nbFailureTest      = 0;
        $this->nbStartedTestSuite = 0;
        $this->nbEndedTestSuite   = 0;
    }

    public function incrementNbStartedTest()
    {
        $this->nbStartedTest++;
    }

    public function incrementNbErrorTest()
    {
        $this->nbErrorTest++;
    }

    public function incrementNbFailureTest()
    {
        $this->nbFailureTest++;
    }

    public function incrementNbStartedTestSuite()
    {
        $this->nbStartedTestSuite++;
    }

    public function incrementNbEndedTestSuite()
    {
        $this->nbEndedTestSuite++;
    }

    /**
     * @return bool
     */
    public function isEveryTestFinished()
    {
        return $this->nbStartedTestSuite > $this->nbEndedTestSuite;
    }

    /**
     * @return int
     */
    public function getNbStartedTest()
    {
        return $this->nbStartedTest;
    }

    /**
     * @return int
     */
    public function getNbFailure()
    {
        return $this->nbErrorTest + $this->nbFailureTest;
    }
}
