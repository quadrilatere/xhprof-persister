<?php

namespace XhProf;

class TraceTest extends \PHPUnit_Framework_TestCase
{
    private $traceData;

    protected function setUp()
    {
        $this->traceData = unserialize(file_get_contents(__DIR__.'/../fixtures/example.trace'));
    }

    public function testTraceConstructorAndMutators()
    {
        $trace = new Trace('example', $this->traceData);

        $this->assertEquals('example', $trace->getToken());
        $this->assertEquals($this->traceData, $trace->getData());
    }
}