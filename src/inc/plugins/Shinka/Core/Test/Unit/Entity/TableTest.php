<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @coversDefaultClass Shinka_Core_Entity_Table
 * @see     Shinka_Core_Entity_Table
 * @package Shinka\Core\Test\Unit\Entity
 */
final class Shinka_Core_Test_Unit_Entity_TableTest extends Shinka_Core_Test_Test
{
    protected $values;

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'name' => 'Test Name',
            'definitions' => array(
                'definition 1',
                'definition 2'
            )
        );
    }

    /**
     * Should set class properties correctly.
     * 
     * @test
     * @covers ::create
     */
    public function create()
    {
        $v = $this->values;
        $entity = new Shinka_Core_Entity_Table(
            $v['name'],
            $v['definitions']
        );

        $this->assertInstanceOf(
            Shinka_Core_Entity_Table::class,
            $entity
        );

        foreach ($v as $key => $value) {
            $this->assertEquals(
                $entity->$key,
                $value
            );
        }
    }

    /**
     * Should correctly set class properties from array of properties.
     * 
     * @test
     * @covers ::fromArray
     */
    public function createFromArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_Table::fromArray($v);

        $this->assertInstanceOf(
            Shinka_Core_Entity_Table::class,
            $entity
        );

        foreach ($v as $key => $value) {
            $this->assertEquals(
                $entity->$key,
                $value
            );
        }
    }

    /**
     * Should return class properties as array.
     * 
     * @test
     * @covers ::toArray
     */
    public function convertToArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_Table::fromArray($v)->toArray();

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

