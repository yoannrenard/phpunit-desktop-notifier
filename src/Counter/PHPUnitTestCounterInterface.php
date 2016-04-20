<?php

namespace PHPUnitDesktopNotifier\Counter;

interface PHPUnitTestCounterInterface
{
    public function incrementNbStartedTest();

    public function incrementNbErrorTest();

    public function incrementNbFailureTest();

    public function incrementNbStartedTestSuite();

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
