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

use XhProf\Context\Context;

/**
 * Interface to implement for populating the context's metadata
 */
interface ContextBuilderInterface
{
    /**
     * Build the context
     * @param  Context $context The context to build
     * @return Context          The built context
     */
    public function build(Context $context);
}
