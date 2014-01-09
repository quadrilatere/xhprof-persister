<?php

namespace XhProf\Graph\Visitor;

interface VisitableInterface
{
    /**
     * @param VisitorInterface $visitor
     */
    public function accept(VisitorInterface $visitor);
}
