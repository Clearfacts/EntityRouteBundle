<?php

namespace Tactics\Bundle\EntityRouteBundle\Annotation;

/**
 * @Annotation
 */
class EntityRoute extends Doctrine\Common\Annotations\Annotation
{
    /**
     * The route name
     */
    public $name;
}
