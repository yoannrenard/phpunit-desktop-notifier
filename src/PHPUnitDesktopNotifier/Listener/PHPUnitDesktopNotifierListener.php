<?php

namespace PHPUnitDesktopNotifier\Listener;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_BaseTestListener;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;
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
        $this->phpUnitTestCounter = $phpUnitTestCounter;
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

        if (!$this->phpUnitTestCounter->isEveryTestFinished()) {
            return;
        }

        if ($this->phpUnitTestCounter->getNbFailure()) {
            $title = 'FAILURES!';
            $body  = sprintf(
                'Tests: %d, Assertions: %d, Failures: %d.',
                $this->phpUnitTestCounter->getNbStartedTest(),
                $this->phpUnitTestCounter->getNbAssert(),
                $this->phpUnitTestCounter->getNbFailure()
            );
            $icon  = __DIR__.'/../../../resources/icons/failure-64.png';
        } else {
            $title = 'Success!';
            $body  = sprintf(
                '%d tests, %d assertions',
                $this->phpUnitTestCounter->getNbStartedTest(),
                $this->phpUnitTestCounter->getNbAssert()
            );
            $icon  = __DIR__.'/../../../resources/icons/success-64.png';
        }

        $notification = (new Notification())
            ->setTitle($title)
            ->setBody($body)
            ->setIcon($icon)
        ;

        $notifier = NotifierFactory::create();
        if ($notifier) {
            $notifier->send($notification);
        }
    }
}
