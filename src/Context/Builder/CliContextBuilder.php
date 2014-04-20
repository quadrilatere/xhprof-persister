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
 * Command-line strategy for storing the trace's context.
 */
final class CliContextBuilder implements ContextBuilderInterface
{
    public function build(Context $context)
    {
        $context->setBag('arguments', new Bag($GLOBALS['argv']));

        return $context;
    }
}
