<?php

namespace Tactics\Bundle\EntityRouteBundle\Tests\Annotation;

use Tactics\Bundle\EntityRouteBundle\Annotation\EntityRouteParameter;

/**
 * EntityRouteParameterTest
 *
 * @author Aaron Muylaert <aaron@tactics.be>
 */
class EntityRouteParameterTests extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the default value of the name property and the getter for the name 
     * property.
     *
     * @covers Tactics\Bundle\EntityRouteBundle\Annotation\EntityRouteParameter::getName
     */
    public function testNameIsDefaultNull()
    {
        $annotation = new EntityRouteParameter();

        $this->assertNull($annotation->getName());
    }

    /**
     * Tests whether name property gets set in constructor.
     *
     * @covers Tactics\Bundle\EntityRouteBundle\Annotation\EntityRouteParameter::getName
     */
    public function testSetName()
    {
        $annotation = new EntityRouteParameter(array('name' => 'foo_id'));

        $this->assertEquals('foo_id', $annotation->getName());
    }
}
