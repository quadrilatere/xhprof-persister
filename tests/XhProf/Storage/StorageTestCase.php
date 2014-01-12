<?php

namespace XhProf\Storage;

class StorageTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getTraceMock($data, $token)
    {
        $trace = $this
            ->getMockBuilder('XhProf\Trace')
            ->disableOriginalConstructor()
            ->setMethods(array('getData', 'getToken'))
            ->getMock()
        ;

        $trace
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue($token))
        ;

        return $trace;
    }
} 