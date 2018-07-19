<?php

use PHPUnit\Framework\TestCase;

require_once 'UnitTest.php';

final class TableTest extends UnitTest
{
    protected $values;

    protected function setUp()
    {
        $this->values = array(
            'name' => 'Test Name',
            'definitions' => array(
                'definition 1',
                'definition 2'
            )
        );
    }

    public function testCreate()
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

    public function testFromArray()
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

    public function testToArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_Table::fromArray($v)->toArray();

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

