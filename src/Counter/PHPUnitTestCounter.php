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

    /** @var int */
    private $nbAssert;

    /**
     * PHPUnitTestCounter constructor.
     */
    public function __construct()
    {
        $this->nbStartedTest      = 0;
        $this->nbErrorTest        = 0;
        $this->nbFailureTest      = 0;
        $this->nbStartedTestSuite = 0;
        $this->nbEndedTestSuite   = 0;
        $this->nbAssert           = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementNbStartedTest()
    {
        $this->nbStartedTest++;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementNbErrorTest()
    {
        $this->nbErrorTest++;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementNbFailureTest()
    {
        $this->nbFailureTest++;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementNbStartedTestSuite()
    {
        $this->nbStartedTestSuite++;
    }

    /**
     * {@inheritdoc}
     */
    public function incrementNbEndedTestSuite()
    {
        $this->nbEndedTestSuite++;
    }

    /**
     * {@inheritdoc}
     */
    public function isEveryTestFinished()
    {
        return $this->nbStartedTestSuite > $this->nbEndedTestSuite;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbStartedTest()
    {
        return $this->nbStartedTest;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbFailure()
    {
        return $this->nbErrorTest + $this->nbFailureTest;
    }

    /**
     * {@inheritdoc}
     */
    public function addAssert($nbAssert)
    {
        $this->nbAssert += $nbAssert;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbAssert()
    {
        return $this->nbAssert;
    }
}
