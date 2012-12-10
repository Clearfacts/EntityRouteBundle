<?php

namespace Tactics\Bundle\EntityRouteBundle;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\AnnotationException;
use Symfony\Component\Routing\RouterInterface;

class EntityRouteResolver 
{
    /**
     * @var $reader Doctrine\Common\Annotations\AnnotationReader
     */
    protected $reader;

    /**
     * @var $router Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * Constructor, sets router and annotationReader.
     *
     * @param Symfony\Component\Routing\RouterInterface $router
     * @param Doctrine\Common\Annotations\AnnotationReader $annotationReader
     */
    public function __construct(RouterInterface $router, Reader $annotationReader)
    {
        $this->router = $router;
        $this->reader = $annotationReader;
    }

    /**
     * Generate default URL for entity.
     *
     * @param Object $entity A Doctrine entity
     * @return string The generated URL
     */
    public function generateUrl($entity, $absolute = false)
    {
        $reflection = $this->getReflectionClass($entity);

        return $this->router->generate(
            $this->getRouteName($reflection),
            $this->getRouteParameters($reflection, $entity),
            $absolute
        );
    }

    /**
     * Check whether or not entity has EntityRoute annotation defined.
     *
     * @return boolean
     */
    public function hasEntityRoute($entity)
    {
        return null !== $this->reader->getClassAnnotation(
            $this->getReflectionClass($entity),
            'Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute'
        );
    }

    /**
     * Retrieve route name.
     *
     * @param \ReflectionClass $reflection
     * @return string
     */
    protected function getRouteName(\ReflectionClass $reflection)
    {
        $annotation = $this->reader->getClassAnnotation($reflection, 'Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute');

        if (null === $annotation) {
            throw new AnnotationException('Class annotation Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute not found.');
        }

        return $annotation->name;
    }


    /**
     * Retrieve route parameters.
     *
     * @param \ReflectionClass $reflection
     * @return array $parameters
     */
    protected function getRouteParameters(\ReflectionClass $reflection, $entity)
    {
        $parameters = array();

        foreach ($reflection->getProperties() as $property) {
            $propertyAnnotation = $this->reader->getPropertyAnnotation($property, 'Tactics\Bundle\EntityRouteBundle\Annotation\EntityRouteParameter');

            if (null !== $propertyAnnotation) {
                $property->setAccessible(true);
                $parameters[$property->getName()] = $property->getValue($entity);
            }
        }

        return $parameters;
    }

    /**
     * Create instance of a \ReflectionClass for Doctrine entity.
     *
     * @param Object $entity
     * @return \ReflectionClass $reflection
     */
    protected function getReflectionClass($entity)
    {
        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy) {
            $reflection = new \ReflectionClass(get_parent_class($entity));
        } else {
            $reflection = new \ReflectionClass($entity);
        }

        return $reflection;
    }
}
