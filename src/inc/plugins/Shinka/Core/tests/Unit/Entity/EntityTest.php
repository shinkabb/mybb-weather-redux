<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/Test.php';

final class Shinka_Core_Test_Unit_Entity_EntityTest extends Shinka_Core_Test_Test
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

