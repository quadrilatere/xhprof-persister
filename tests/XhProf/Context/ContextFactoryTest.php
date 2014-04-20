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

class ContextFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateCliContextInCliEnvironment()
    {
        $context = ContextFactory::create();
        $this->assertInstanceof('XhProf\Context\Context', $context);
        $this->assertContains('arguments', $context->keys());
    }

    /**
     * @requires extension runkit
     * @runInSeparateProcess
     */
    public function testCanCreateRequestContextInCgiEnvironment()
    {
        if (!ini_get('runkit.internal_override')) {
            $this->markTestSkipped('runkit.internal_override should be set to true.');
        }

        runkit_function_redefine('php_sapi_name', '', 'return "cgi-fcgi";');

        $context = ContextFactory::create();
        $this->assertContains('server', $context->keys());
        $this->assertContains('headers', $context->keys());
        $this->assertContains('query', $context->keys());
        $this->assertContains('request', $context->keys());
        $this->assertContains('cookies', $context->keys());

        runkit_function_redefine('php_sapi_name', '', 'return "cli";');
    }
}
