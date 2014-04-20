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

class ContextTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->context = new Context();
        $this->bag = $this->getMock('XhProf\Context\Bag');
    }

    protected function tearDown()
    {
        $this->context = null;
        $this->bag = null;
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testLoadingAnUnitializedBagThrowsAnException()
    {
        $this->context->getBag('server');
    }

    public function testTheBagNameShouldBeConvertedToLowercase()
    {
        $this->context->setBag('SerVer', $this->bag);
        $this->assertSame($this->bag, $this->context->getBag('serVER'));
        $this->assertSame(array('server'), $this->context->keys());
        $this->assertSame(array('server' => $this->bag), $this->context->all());

        $this->context->remove('SERVER');
        $this->assertEmpty($this->context->all());
    }

    public function testTheContextShouldBeCorrectlySerializedAndUnserialized()
    {
        $this->context->setBag('server', $this->bag);
        $context = unserialize(serialize($this->context));
        $this->assertArrayHasKey('server', $context->all());
    }
}
