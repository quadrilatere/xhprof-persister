<?php

namespace XhProf;

class TraceTest extends \PHPUnit_Framework_TestCase
{
    private $traceData;

    protected function setUp()
    {
        $this->traceData = unserialize(file_get_contents(__DIR__.'/../fixtures/example.trace'));
        $this->context = $this->getMock('XhProf\Context\Context');
    }

    public function testTraceConstructorAndMutators()
    {
        $trace = new Trace('example', $this->traceData, $this->context);

        $this->assertEquals('example', $trace->getToken());
        $this->assertEquals($this->traceData, $trace->getData());
        $this->assertEquals($this->context, $trace->getContext());
        $this->assertInstanceof('XhProf\Trace', unserialize(serialize($trace)));
    }
}