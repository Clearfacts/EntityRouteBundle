EntityRouteBundle
=================

Define default routes for entities

Define the route name

```
<?php

namespace Acme\Bundle\FooBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tactics\Bundle\EntityRouteBundle\Annotation\EntityRoute;
use Tactics\Bundle\EntityRouteBundle\Annotation\EntityRouteParameter;

/**
 * @ORM\Entity()
 * @EntityRoute(name="foo_show")
 */
class Foo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
```

Define parameters

```
/**
 * @ORM\Id
 * @ORM\Column(type="integer")
 * @ORM\GeneratedValue(strategy="AUTO")
 * @EntityRouteParameter
 */
protected $id;
```

Resolve the route using the EntityRouteResolver service

```
$this->get('tactics.entity_route_resolver')->generateUrl($foo);
```