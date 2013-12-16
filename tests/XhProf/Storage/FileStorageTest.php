<?php

namespace XhProf\Storage;

class FileStorageTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {

    }

    protected function tearDown()
    {
        $this->trace = null;
    }

    public function testPersisterCanWriteFile()
    {
        $data = unserialize(file_get_contents(__DIR__.'/../../fixtures/example.trace'));
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $trace = $this->getTraceMock($data, $token);
        $expectedFile = sprintf('%s/xhprof/%s.trace', sys_get_temp_dir(), $token);
        $dir = dirname($expectedFile);
        $directoryExists = file_exists($dir);

        $storage = new FileStorage();
        $this->assertNull($storage->store($trace));
        $this->assertFileExists($expectedFile);
        unlink($expectedFile);
        if (!$directoryExists) {
            rmdir(dirname($expectedFile));
        }
    }

    public function testPersisterCanFetchFile()
    {
        $token = 'example';
        $baseDir = __DIR__.'/../../fixtures';

        $storage = new FileStorage($baseDir);
        $this->assertInstanceOf('XhProf\Trace', $storage->fetch($token));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testPersisterThrowsExceptionOnLoadingNonexistentFile()
    {
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $storage = new FileStorage();

        $storage->fetch($token);
    }

    private function getTraceMock($data, $token)
    {
        $trace = $this
            ->getMockBuilder('XhProf\Trace')
            ->disableOriginalConstructor()
            ->setMethods(array('getData', 'getToken'))
            ->getMock()
        ;

        $trace
            ->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($data))
        ;

        $trace
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue($token))
        ;

        return $trace;
    }
}
