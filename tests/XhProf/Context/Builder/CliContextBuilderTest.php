<?php

/*
 * This file is part of the XhProf package
 *
 * (c) Charles Sarrazin <charles@sarraz.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace XhProf\Context\Builder;

class CliContextBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testContextContainsArguments()
    {
        $context = $this
            ->getMockBuilder('XhProf\Context\Context')
            ->setMethods(array('setBag'))
            ->getMock()
        ;

        $context
            ->expects($this->once())
            ->method('setBag')
            ->with($this->equalTo('arguments'), $this->isInstanceOf('XhProf\Context\Bag'))
        ;

        $builder = new CliContextBuilder();
        $builder->build($context);
    }
}
