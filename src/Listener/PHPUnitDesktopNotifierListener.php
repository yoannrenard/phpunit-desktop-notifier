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
//        $this->phpUnitTestCounter = new PHPUnitTestCounter();
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
            $title = 'Failed';
            $body  = sprintf(
                '%d/%d tests failed',
                $this->phpUnitTestCounter->getNbFailure(),
                $this->phpUnitTestCounter->getNbStartedTest()
            );
            $icon  = __DIR__.'/Resources/icons/success.png';
        } else {
            $title = 'Success';
            $body  = sprintf(
                '%d/%d tests passed',
                $this->phpUnitTestCounter->getNbStartedTest(),
                $this->phpUnitTestCounter->getNbStartedTest()
            );
            $icon  = __DIR__.'/Resources/icons/success.png';
        }

        $notification = (new Notification())
            ->setTitle($title)
            ->setBody($body)
//            ->setIcon($icon)
        ;

        $notifier = NotifierFactory::create();
        if ($notifier) {
            $notifier->send($notification);
        }
    }
}
