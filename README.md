# EntityRouteBundle

## Context

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

## Local development

We have some commands you can use, defined in a [Makefile](./Makefile). You can look there for anything you might need. All these commands set-up and use Docker containers. 
For more information see [cf-docs](https://github.com/Clearfacts/cf-docs/blob/66552172fedf8663a0d8a7d165d076565035218f/dev/LocalDevSetup.md).

### Installation

- Make sure you have composer installed globally and have php 7.3 or 7.4
- Clone the project from github
- `cd <folder-name>`
- `make init`
