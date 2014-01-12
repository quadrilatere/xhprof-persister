<?php

namespace XhProf\Storage;

class MemoryStorageTest extends StorageTestCase
{
    private $storage;

    protected function setUp()
    {
        $this->storage = new MemoryStorage();
    }

    protected function tearDown()
    {
        $this->storage = null;
    }

    public function testStorageCanWriteInMemory()
    {
        $data = unserialize(file_get_contents(__DIR__.'/../../fixtures/example.trace'));
        $token = '03a208c1140e2dd9ad953bfe5db9e7835e7a035a';
        $trace = $this->getTraceMock($data, $token);
        $this->storage->store($trace);

        $this->assertInstanceOf('XhProf\Trace', $this->storage->fetch($token));
        $this->assertSame($trace, $this->storage->fetch($token));
    }

    /**
     * @expectedException \XhProf\Storage\StorageException
     */
    public function testFetchingInvalidTokenThrowsException()
    {
        $this->storage->fetch('abcdef');
    }
} 