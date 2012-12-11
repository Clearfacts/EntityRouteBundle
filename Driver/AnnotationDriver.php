<?php

namespace Tactics\Bundle\EntityRouteBundle\Driver;

class AnnotationDriver
{
    /**
     * @var Doctrine\Common\Annotations\Reader $reader The annotation reader.
     */
    protected $reader;

    /**
     * Constructor
     */
    public function __construct(\Doctrine\Common\Annotations\Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Attempts to read the entity route annotation.
     *
     * @param \ReflectionClass $class The reflection class.
     * @return Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute|null The annotation.
     */
    public function readEntityRoute(\ReflectionClass $class)
    {
        return $this->reader->getClassAnnotation(
            $this->getReflectionClass($class),
            'Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute'
        );

    }

    /**
     * Attempts to read the RouteParameter field annotations.
     *
     * @param \ReflectionClass $class The reflection class.
     * @return array                  An array of RouteParameterField annotations.
     */
    public function readEntityRouteParameterFields(\ReflectionClass $class)
    {
        $fields = array();

        foreach ($class->getProperties() as $property) {
            $propertyAnnotation = $this->reader->getPropertyAnnotation($property, 'Tactics\Bundle\EntityRouteBundle\Annotation\EntityRouteParameter');

            if (null !== $propertyAnnotation) {
                $propertyAnnotation->setPropertyName($property->getName());
                $fields[] = $propertyAnnotation;
            }
        }

        return $fields;
    }
}
