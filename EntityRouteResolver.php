<?php

namespace Tactics\Bundle\EntityRouteResolerBundle;

use Doctrine\Common\Annotations\AnnotationReader;
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
    public function __construct(RouterInterface $router, AnnotationReader $annotationReader)
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

        if (false === $annotation) {
        }

        return $this->router->generate(
            $this->getRouteName($reflection),
            $this->getRouteParameters($reflection, $entity),
            $absolute,
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
        $annotation = $this->reader()->getClassAnnotation($class, 'Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute');

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
            $propertyAnnotation = $this->reader->getPropertyAnnotation($property, 'Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute');

            if (null !== $propertyAnnotation) {
                $parameters[$property->getName()] = $property->getValue($entity);
            }
        }
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
