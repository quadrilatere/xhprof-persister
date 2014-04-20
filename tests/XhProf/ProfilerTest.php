<?php

namespace XhProf;

/**
 * @requires extension xhprof
 */
class ProfilerTest extends \PHPUnit_Framework_TestCase
{
    private $profiler;

    protected function setUp()
    {
        $this->profiler = new Profiler();
    }

    protected function tearDown()
    {
        if (!extension_loaded('xhprof')) {
            return;
        }

        if ($this->profiler->isRunning()) {
            $this->profiler->stop();
        }

        $this->profiler = null;
    }

    /**
     * @expectedException \LogicException
     */
    public function testProfilerCannotStartTwice()
    {
        $this->profiler->start();
        $this->profiler->start();
    }

    /**
     * @expectedException \LogicException
     */
    public function testProfilerCannotBeStoppedBeforeBeingStarted()
    {
        $this->profiler->stop();
    }

    public function testProfilerOnlyReturnsTraceOnFirstStop()
    {
        $this->profiler->start();
        $this->assertNotNull($this->profiler->stop());
        $this->assertNull($this->profiler->stop());
    }

    /**
     * @dataProvider provideCorrectCallbacks
     */
    public function testShutdownFunctionSetterDoesntThrowExceptionWhenGivenCorrectCallback($callback)
    {
        $this->profiler->setShutdownFunction($callback);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider provideBadCallbacks
     */
    public function testShutdownFunctionSetterThrowsExceptionWhenGivenInvalidCallback($callback)
    {
        $this->profiler->setShutdownFunction($callback);
    }

    public function testProfiler()
    {
        $this->profiler->start();

        for ($i = 0; $i < 10; $i++) {
            call_user_func_array(
                function($arr1, $arr2) {
                    return array_merge($arr1, $arr2);
                },
                array(array("hello"), array("world"))
            );
        }

        $trace = $this->profiler->stop();

        $this->assertInstanceOf('XhProf\\Trace', $trace);
    }

    public function testCallShutdownFunction()
    {
        $shutdownMock = $this
            ->getMockBuilder('DateTime')
            ->setMethods(array('getTimestamp'))
            ->getMock();

        $shutdownMock
            ->expects($this->once())
            ->method('getTimestamp')
        ;

        $this->profiler->setShutdownFunction(array($shutdownMock, 'getTimestamp'));
        $this->profiler->start();
        $this->profiler->executeShutDown();
    }

    public function provideCorrectCallbacks()
    {
        return array(
            array('mysql_connect'),
            array(array('DateTime', 'createFromFormat')),
        );
    }

    public function provideBadCallbacks()
    {
        return array(
            array('hello'),
            array(12),
            array(array('hello', 'world')),
            array(array('DateTime', 'echo')),
        );
    }
}
 