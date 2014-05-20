<?php

namespace XhProf\Storage;

class FileStorageTest extends StorageTestCase
{
    public function testStorageCanWriteFile()
    {
        $data = unserialize(file_get_contents(__DIR__.'/../fixtures/example.trace'));
        $context = $this->getMock('XhProf\Context\Context');
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $trace = $this->getTraceMock($data, $context, $token);

        $trace
            ->expects($this->once())
            ->method('serialize')
            ->will($this->returnValue(serialize(array($token, $data))))
        ;

        $expectedFile = sprintf('%s/xhprof/tests/%s.trace', sys_get_temp_dir(), $token);
        $dir = dirname($expectedFile);
        $this->assertFileNotExists($expectedFile);

        $storage = new FileStorage($dir);

        $this->assertEmpty($storage->getTokens());
        $this->assertNull($storage->store($trace));
        $this->assertEquals(array($token), $storage->getTokens());
        $this->assertFileExists($expectedFile);

        unlink($expectedFile);
        rmdir($dir);
    }

    public function testStorageCanFetchFile()
    {
        $token = 'example';
        $baseDir = __DIR__.'/../fixtures';

        $storage = new FileStorage($baseDir);
        $this->assertInstanceOf('XhProf\Trace', $storage->fetch($token));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testStorageThrowsExceptionOnLoadingNonexistentFile()
    {
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $storage = new FileStorage(sprintf('%s/xhprof/tests/', sys_get_temp_dir()));

        $storage->fetch($token);
    }
}
