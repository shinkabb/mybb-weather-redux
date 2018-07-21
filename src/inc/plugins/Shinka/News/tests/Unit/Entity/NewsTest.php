<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/tests/Test.php';

final class Shinka_News_Test_Unit_Entity_NewsTest extends Shinka_Core_Test_Test
{
    protected $values;

    protected function setUp()
    {
        parent::setUp();
        $this->values = array(
            'headline' => 'Test Headline',
            'text' => 'Test Text',
            'pinned' => true,
            'created_at' => 123,
            'user' => array(
                'uid' => 456,
                'username' => 'Test Username'
            ),
            'thread' => array(
                'tid' => 789,
                'subject' => 'Test Subject'
            ),
            'status' => Shinka_News_Constant_Status::APPROVED,
            'nid' => 10
        );
    }

    public function testCreate()
    {
        $v = $this->values;
        $entity = new Shinka_News_Entity_News(
            $v['headline'],
            $v['text'],
            $v['pinned'],            
            $v['status'],
            $v['created_at'],
            $v['user'],
            $v['thread'],
            $v['nid']
        );

        $this->assertInstanceOf(
            Shinka_News_Entity_News::class,
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

        $entity = new Shinka_News_Entity_News(
            $v['headline'],
            $v['text']
        );

        foreach (Shinka_News_Entity_News::DEFAULTS as $key => $value) {
            $this->assertEquals($entity->$key, $value);
        }
    }

    public function testFromArray()
    {
        $v = $this->values;
        $entity = Shinka_News_Entity_News::fromArray($v);

        $this->assertInstanceOf(
            Shinka_News_Entity_News::class,
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
        $entity = Shinka_News_Entity_News::fromArray($v)->toArray();

        $this->assertEquals(
            $entity,
            $v
        );
    }

    public function testForInsert()
    {
        $v = $this->values;
        $entity = Shinka_News_Entity_News::fromArray($v)->forInsert();

        $v['uid'] = $v['user']['uid'];
        $v['tid'] = $v['thread']['tid'];
        unset($v['thread']);
        unset($v['user']);
        unset($v['created_at']);
        unset($v['nid']);

        $this->assertEquals(
            $entity,
            $v
        );
    }
}

