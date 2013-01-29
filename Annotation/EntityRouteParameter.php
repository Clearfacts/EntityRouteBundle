<?php

namespace Tactics\Bundle\EntityRouteBundle\Annotation;

/**
 * @Annotation
 *
 * @author Aaron Muylaert <aaron@tactics.be>
 */
class EntityRouteParameter
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * Constructs a new instance of EntityRouteParameter.
     *
     * @param array $options The options.
     */
    public function __construct(array $options = array())
    {
        if (isset($options['name'])) {
            $this->name = $options['name'];
        }
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
