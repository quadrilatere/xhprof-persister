<?php

namespace XhProf;

class ProfilerTest extends \PHPUnit_Framework_TestCase
{
    private $storage;
    private $profiler;

    protected function setUp()
    {
        if (!extension_loaded('xhprof')) {
            $this->markTestSkipped('The xhprof extension must be loaded first');
        }

        $this->storage = $this->getMock('XhProf\\Storage\\StorageInterface');
        $this->profiler = new Profiler($this->storage);
    }

    protected function tearDown()
    {
	    if (!extension_loaded('xhprof')) {
            return;
        }

        if ($this->profiler->isRunning()) {
            $this->profiler->stop();
        }
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

    public function testProfiler()
    {
        $this->storage->expects($this->once())->method('store');

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
}
 
