<?php

namespace PHPUnitDesktopNotifier\Counter;

interface PHPUnitTestCounterInterface
{
    /**
     * Increment nbStartedTest
     */
    public function incrementNbStartedTest();

    /**
     * Increment nbErrorTest
     */
    public function incrementNbErrorTest();

    /**
     * Increment nbFailureTest
     */
    public function incrementNbFailureTest();

    /**
     * Increment nbStartedTestSuite
     */
    public function incrementNbStartedTestSuite();

    /**
     * Increment nbEndedTestSuite
     */
    public function incrementNbEndedTestSuite();

    /**
     * @return bool
     */
    public function isEveryTestFinished();

    /**
     * @return int
     */
    public function getNbStartedTest();

    /**
     * @return int
     */
    public function getNbFailure();
}
