<?php

namespace XhProf\Storage;

class FileStorageTest extends StorageTestCase
{
    public function testStorageCanWriteFile()
    {
        $data = unserialize(file_get_contents(__DIR__.'/../../fixtures/example.trace'));
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $trace = $this->getTraceMock($data, $token);

        $trace
            ->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($data))
        ;

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

    public function testStorageCanFetchFile()
    {
        $token = 'example';
        $baseDir = __DIR__.'/../../fixtures';

        $storage = new FileStorage($baseDir);
        $this->assertInstanceOf('XhProf\Trace', $storage->fetch($token));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testStorageThrowsExceptionOnLoadingNonexistentFile()
    {
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $storage = new FileStorage();

        $storage->fetch($token);
    }
}
