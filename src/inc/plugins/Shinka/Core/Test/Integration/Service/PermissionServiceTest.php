<?php

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/IntegrationTest.php';
require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Fixture/Fixture.php';

/**
 * @coversDefaultClass Shinka_Core_Service_PermissionService
 * @see     Shinka_Core_Service_PermissionService
 * @package Shinka\Core\Test\Integration\Service
 */
final class Shinka_Core_Test_Integration_PermissionServiceTest extends Shinka_Core_Test_IntegrationTest
{
    protected $user;
    protected $usergroups;

    /** @var string Permission key to check against */
    protected static $settingKey = "testing";

    /** @var string Permission value to check against */
    protected $settingValue;

    protected function seedUserGroups()
    {
        global $db;

        $this->usergroups = array(
            Shinka_Core_Test_Fixture_Fixture::usergroup(array(
                "canview" => 1,
                "canpostthreads" => 0,
                "modposts" => 1
            )),
            Shinka_Core_Test_Fixture_Fixture::usergroup(array(
                "canviewthreads" => 0,
                "canpostreplys" => 1,
                "modposts" => 0
            )),
        );

        foreach ($this->usergroups as $ndx => &$ugroup) {
            $ugroup['title'] = "Usergroup $ndx";
            $ugroup['gid'] = $db->insert_query("usergroups", $ugroup);
        }
    }

    protected function seedUser()
    {
        global $db;

        $this->user = Shinka_Core_Test_Fixture_Fixture::user(array(
                'usergroup' => $this->usergroups[0]['gid'],
                'additionalgroups' => $this->usergroups[1]['gid']
        ));

        $this->user['uid'] = $db->insert_query("users", $this->user);
    }

    protected function updateCache()
    {
        global $cache, $groupscache;

        $cache->update_usergroups();
        $groupscache = $cache->read("usergroups");
    }

    /**
     * @see Shinka_Core_Test_IntegrationTest::seedSettings
     */
    protected function seedSettings($settings = array())
    {
        parent::seedSettings(array(self::$settingKey => $this->settingValue));
    }

    protected function setUp()
    {
        parent::setUp();
        
        $this->settingValue = "1,2,3";

        $this->seedUserGroups();
        $this->seedUser();
        $this->seedSettings();
        $this->updateCache();
    }

    protected function tearDown()
    {
        global $db;
        
        $db->delete_query("users", "");
        $db->delete_query("usergroups", "");
    }

    /**
     * Sanity check for seed persistence.
     * 
     * @test
     */
    public function testSeed()
    {
        $count = $this->countEntities("users");
        $this->assertEquals(1, $count);

        $count = $this->countEntities("usergroups");
        $this->assertEquals(count($this->usergroups), $count);
    }

    /**
     * Should have permission with given user.
     * 
     * @test
     * @covers ::can
     */
    public function canWithUser()
    {
        $can = Shinka_Core_Service_PermissionService::can("canview", $this->user);
        
        $this->assertTrue($can);
    }

    /**
     * Should have permission with MyBB user.
     * 
     * @test
     * @covers ::can
     */
    public function canWithoutUser()
    {
        global $mybb;
        require_once MYBB_ROOT . '/inc/functions.php';

        $mybb->user = $this->user;
        $mybb->usergroup = usergroup_permissions($mybb->user['usergroup'] . "," . $mybb->user['additionalgroups']);
        
        $can = Shinka_Core_Service_PermissionService::can("canview");
        
        $this->assertTrue($can);
    }

    /**
     * Should not have permission with given user.
     * 
     * @test
     * @covers ::can
     */
    public function cannot()
    {
        $can = Shinka_Core_Service_PermissionService::can("canpostthreads", $this->user);

        $this->assertFalse($can);
    }

    /**
     * Should not have permission with MyBB user.
     * 
     * @test
     * @covers ::can
     */
    public function cannotWithoutUser()
    {
        global $mybb;
        require_once MYBB_ROOT . '/inc/functions.php';

        $mybb->user = $this->user;
        $mybb->usergroup = usergroup_permissions($mybb->user['usergroup'] . "," . $mybb->user['additionalgroups']);
        
        $can = Shinka_Core_Service_PermissionService::can("canpostthreads");
        
        $this->assertFalse($can);
    }

    /**
     * Should have permission if a subset of the user's groups do.
     * 
     * @test
     * @covers ::can
     */
    public function canWithOverridingPerm()
    {
        $can = Shinka_Core_Service_PermissionService::can("modposts", $this->user);

        $this->assertTrue($can);
    }

    /**
     * Should have permission if a subset of the user's additional groups do.
     * 
     * @test
     * @covers ::can
     */
    public function canWithAdditionalUsergroup()
    {
        $can = Shinka_Core_Service_PermissionService::can("canpostreplys", $this->user);

        $this->assertTrue($can);
    }

    /**
     * Should return an error if permission does not exist.
     * 
     * @test
     * @covers ::can
     */
    public function errorWithInvalidPerm()
    {
        $can = Shinka_Core_Service_PermissionService::can("not_a_real_perm", $this->user, false);

        $this->assertEquals(-1, $can);
    }

    /**
     * Should have permission if value is -1.
     * 
     * @test
     * @covers ::canSetting
     */
    public function canWithAll()
    {
        $this->settingValue = "-1";
        $this->seedSettings();

        $can = Shinka_Core_Service_PermissionService::can(self::$settingKey, $this->user);

        $this->assertTrue($can);
    }

    /**
     * Should use settings if permission does not exist.
     * 
     * @test
     * @covers ::canSetting
     */
    public function canWithSetting()
    {
        $this->settingValue = implode(",", array_map(function ($group) {
            return $group['gid'];
        }, $this->usergroups));
        $this->seedSettings();

        $can = Shinka_Core_Service_PermissionService::can(self::$settingKey, $this->user);

        $this->assertTrue($can);
    }

    /**
     * Should not have permission from setting.
     * 
     * @test
     * @covers ::canSetting
     */
    public function cannotWithSetting()
    {
        $this->settingValue = "a,b,c";
        $this->seedSettings();

        $can = Shinka_Core_Service_PermissionService::can(self::$settingKey, $this->user);

        $this->assertFalse($can);
    }

    /**
     * Should not have permission with empty setting value.
     * 
     * @test
     * @covers ::canSetting
     */
    public function cannotWithEmptySetting()
    {
        $this->settingValue = "";
        $this->seedSettings();

        $can = Shinka_Core_Service_PermissionService::can(self::$settingKey, $this->user);

        $this->assertFalse($can);
    }

    /**
     * Should return error if key is neither a permission or a setting.
     * 
     * @test
     * @covers ::canSetting
     */
    public function cannotWithUndefinedSetting()
    {
        $can = Shinka_Core_Service_PermissionService::can("not_a_real_setting", $this->user);

        $this->assertEquals(-1, $can);
    }
}
