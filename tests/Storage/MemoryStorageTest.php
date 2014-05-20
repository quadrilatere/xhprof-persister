<?php

namespace XhProf\Storage;

class MemoryStorageTest extends StorageTestCase
{
    public function testStorageCanWriteInMemory()
    {
        $data = unserialize(file_get_contents(__DIR__.'/../fixtures/example.trace'));
        $context = $this->getMock('XhProf\Context\Context');
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $trace = $this->getTraceMock($data, $context, $token);

        $storage = new MemoryStorage();

        $this->assertEmpty($storage->getTokens());
        $storage->store($trace);
        $this->assertEquals(array($token), $storage->getTokens());

        $this->assertInstanceOf('XhProf\Trace', $storage->fetch($token));
        $this->assertSame($trace, $storage->fetch($token));
    }

    /**
     * @expectedException \XhProf\Storage\StorageException
     */
    public function testFetchingInvalidTokenThrowsException()
    {
        $storage = new MemoryStorage();
        $storage->fetch('abcdef');
    }
}
