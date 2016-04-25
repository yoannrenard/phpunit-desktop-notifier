<?php

namespace PHPUnitDesktopNotifier\Listener;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_BaseTestListener;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;
use PHPUnitDesktopNotifier\Counter\PHPUnitTestCounter;
use PHPUnitDesktopNotifier\Counter\PHPUnitTestCounterInterface;

/**
 * Class PHPUnitDesktopNotifierListener
 *
 * @package PHPUnitDesktopNotifier
 */
class PHPUnitDesktopNotifierListener extends PHPUnit_Framework_BaseTestListener
{
    /** @var PHPUnitTestCounterInterface $phpUnitTestCounter */
    protected $phpUnitTestCounter;

    /**
     * PHPUnitDesktopNotifierListener constructor.
     *
     * @param PHPUnitTestCounterInterface $phpUnitTestCounter
     */
    public function __construct(PHPUnitTestCounterInterface $phpUnitTestCounter)
    {
        $this->phpUnitTestCounter = ($phpUnitTestCounter) ?: new PHPUnitTestCounter();
    }

    /**
     * {@inheritdoc}
     */
    public function startTest(PHPUnit_Framework_Test $test)
    {
        $this->phpUnitTestCounter->incrementNbStartedTest();
    }

    /**
     * {@inheritdoc}
     */
    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        $this->phpUnitTestCounter->addAssert(\PHPUnit_Framework_Assert::getCount());
    }

    /**
     * {@inheritdoc}
     */
    public function addError(PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        $this->phpUnitTestCounter->incrementNbErrorTest();
    }

    /**
     * {@inheritdoc}
     */
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        $this->phpUnitTestCounter->incrementNbFailureTest();
    }

    /**
     * {@inheritdoc}
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        $this->phpUnitTestCounter->incrementNbStartedTestSuite();
    }

    /**
     * {@inheritdoc}
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        $this->phpUnitTestCounter->incrementNbEndedTestSuite();

        if ($this->phpUnitTestCounter->isEveryTestFinished()) {
            $this->notifyDesktopUser();
        }
    }

    /**
     * Notifier desktop user
     */
    private function notifyDesktopUser()
    {
        $icon  = __DIR__.'/../../resources/icons/';
        if ($this->phpUnitTestCounter->getNbFailure()) {
            $title = 'FAILURES!';
            $body  = sprintf(
                'Tests: %d, Assertions: %d, Failures: %d.',
                $this->phpUnitTestCounter->getNbStartedTest(),
                $this->phpUnitTestCounter->getNbAssert(),
                $this->phpUnitTestCounter->getNbFailure()
            );
            $icon .= 'failure-64.png';
        } else {
            $title = 'Success!';
            $body  = sprintf(
                '%d tests, %d assertions',
                $this->phpUnitTestCounter->getNbStartedTest(),
                $this->phpUnitTestCounter->getNbAssert()
            );
            $icon .= 'success-64.png';
        }

        $notifier = NotifierFactory::create();
        if ($notifier) {
            $notification = (new Notification())
                ->setTitle($title)
                ->setBody($body)
                ->setIcon($icon)
            ;

            $notifier->send($notification);
        }
    }
}
