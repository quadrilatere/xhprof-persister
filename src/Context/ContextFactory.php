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

use XhProf\Context\Builder;

/**
 * A set of metadata bags containing the execution environment's information.
 */
final class ContextFactory
{
    public static function create()
    {
        $context = new Context();

        $strategy = self::isCommandLineInterface()
            ? new Builder\CliContextBuilder()
            : new Builder\RequestContextBuilder();

        return $strategy->build($context);
    }

    private static function isCommandLineInterface()
    {
        return 'cli' === php_sapi_name();
    }
}
