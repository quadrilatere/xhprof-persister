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

class RequestContextBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testContextContainsArguments()
    {
        $_SERVER = array(
            'HTTP_CONTENT_TYPE' => 'text/html',
            'DOCUMENT_ROOT'     => '/var/www',
            'REQUEST_URI'       => '/index.php',
        );

        $context = $this
            ->getMockBuilder('XhProf\Context\Context')
            ->setMethods(array('setBag'))
            ->getMock()
        ;

        $context
            ->expects($this->exactly(5))
            ->method('setBag')
            ->with($this->isType('string'), $this->isInstanceOf('XhProf\Context\Bag'))
        ;

        $builder = new RequestContextBuilder();
        $builder->build($context);
    }
}
