<?php

/*
 * This file is part of the XhProf package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Context;

class BagTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->bag = new Bag();
    }

    protected function tearDown()
    {
        $this->bag = null;
    }

    public function testInitialization()
    {
        $bag = new Bag(array('DOCUMENT_ROOT' => '/var/www'));
        $this->assertArrayHasKey('DOCUMENT_ROOT', $bag->all());
        $this->assertSame('/var/www', $bag->get('DOCUMENT_ROOT'));
    }

    public function testIterator()
    {
        $this->bag->set('DOCUMENT_ROOT', '/var/www');
        $this->bag->set('REQUEST_URI', '/index.php');

        $this->assertInstanceOf('ArrayIterator', $this->bag->getIterator());
        $this->assertCount(2, $this->bag);
        $this->assertSame(array('DOCUMENT_ROOT', 'REQUEST_URI'), $this->bag->keys());

        $this->assertEquals('bar', $this->bag->get('foo', 'bar'));
        $this->bag->remove('DOCUMENT_ROOT');
        $this->assertCount(1, $this->bag);
    }

    public function testTheContextShouldBeCorrectlySerializedAndUnserialized()
    {
        $this->bag->set('DOCUMENT_ROOT', '/var/www');
        $this->bag->set('REQUEST_URI', '/index.php');

        $bag = unserialize(serialize($this->bag));
        $this->assertEquals($this->bag, $bag);
    }
}
