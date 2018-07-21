<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/Test.php';

final class Shinka_Core_Test_Unit_Entity_TemplateGroupTest extends Shinka_Core_Test_Test
{
    protected $values;

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'asset_dir' => 'Test Name',
            'prefix' => 'Test prefix',
            'title' => 'Test title',
            'isdefault' => 1
        );
    }

    public function testCreate()
    {
        $v = $this->values;
        $entity = new Shinka_Core_Entity_TemplateGroup(
            $v['asset_dir'],
            $v['prefix'],
            $v['title'],
            $v['isdefault']
        );

        $this->assertInstanceOf(
            Shinka_Core_Entity_TemplateGroup::class,
            $entity
        );

        foreach ($v as $key => $value) {
            $this->assertEquals(
                $entity->$key,
                $value
            );
        }
    }

    public function testCreateSetsDefaults()
    {
        $v = $this->values;
        $entity = new Shinka_Core_Entity_TemplateGroup(
            $v['asset_dir'],
            $v['prefix'],
            $v['title'],
            null
        );

        $this->assertEquals(
            $entity->isdefault,
            Shinka_Core_Entity_TemplateGroup::DEFAULTS['isdefault']
        );
    }

    public function testFromArray()
    {
        $v = $this->values;
        $entity = Shinka_Core_Entity_TemplateGroup::fromArray($v);

        $this->assertInstanceOf(
            Shinka_Core_Entity_TemplateGroup::class,
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
        $entity = Shinka_Core_Entity_TemplateGroup::fromArray($v)->toArray();

        // asset_dir not included in array
        unset($v['asset_dir']);

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

