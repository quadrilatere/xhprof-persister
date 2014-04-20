<?php

namespace XhProf\Storage;

use XhProf\Context\Context;

class StorageTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getTraceMock(array $data, Context $context, $token)
    {
        $trace = $this
            ->getMockBuilder('XhProf\Trace')
            ->disableOriginalConstructor()
            ->setMethods(array('getData', 'getToken', 'getContext', 'serialize'))
            ->getMock()
        ;

        $trace
            ->expects($this->any())
            ->method('getContext')
            ->will($this->returnValue($context))
        ;

        $trace
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue($token))
        ;

        return $trace;
    }
} 