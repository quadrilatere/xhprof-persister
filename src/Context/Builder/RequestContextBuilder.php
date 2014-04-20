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

use XhProf\Context\Bag;
use XhProf\Context\Context;

/**
 * Request strategy for storing the trace's context.
 */
class RequestContextBuilder implements ContextBuilderInterface
{
    public function build(Context $context)
    {
        list($server, $headers) = $this->parseServerDirectives();

        $context->setBag('query', new Bag($_GET));
        $context->setBag('request', new Bag($_POST));
        $context->setBag('cookies', new Bag($_COOKIE));
        $context->setBag('headers', $headers);
        $context->setBag('server', $server);

        return $context;
    }

    private function parseServerDirectives()
    {
        $server = new Bag();
        $headers = new Bag();

        foreach ($_SERVER as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $headers->set(strtolower(substr($key, 4)), $value);
            } else {
                $server->set(strtolower($key), $value);
            }
        }

        return array($server, $headers);
    }
}
