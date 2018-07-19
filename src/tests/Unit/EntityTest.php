<?php

use PHPUnit\Framework\TestCase;

require_once 'UnitTest.php';

final class EntityTest extends UnitTest
{
    public function testCreate()
    {

        $entity = new Shinka_Core_Entity_Entity();
        $this->assertInstanceOf(
            Shinka_Core_Entity_Entity::class,
            $entity
        );
    }

    public function testSetsDefaults()
    {
        $defaults = array(
            "one" => 1,
            "two" => "2"
        );

        $entity = new Shinka_Core_Entity_Entity();
        $entity->setDefaults($defaults);

        foreach ($defaults as $key => $value)
        {
            $this->assertEquals(
                $entity->$key,
                $value
            );
        }
    }
}

