<?php

use PHPUnit\Framework\TestCase;

require_once getcwd() . '/inc/plugins/Shinka/Core/Test/Test.php';

/**
 * @coversDefaultClass Shinka_Core_Service_PermissionService
 * @see     Shinka_Core_Service_PermissionService
 * @package Shinka\Core\Test\Unit\Entity
 */
final class Shinka_Core_Test_Unit_Service_PermissionServiceTest extends Shinka_Core_Test_Test
{
    /**
     * Should match usergroup.
     * 
     * @test
     * @covers ::hasGroup
     */
    public function matchUserGroup()
    {
        $user = array('usergroup' => '1', 'additionalgroups' => '2,3');
        $groups = '1,4';

        $hasGroup = Shinka_Core_Service_PermissionService::hasGroup($groups, $user);

        $this->assertTrue($hasGroup);
    }

    /**
     * Should match additionalgroups.
     * 
     * @test
     * @covers ::hasGroup
     */
    public function matchAdditionalGroups()
    {
        $user = array('usergroup' => '1', 'additionalgroups' => '2,3');
        $groups = '3,4';

        $hasGroup = Shinka_Core_Service_PermissionService::hasGroup($groups, $user);

        $this->assertTrue($hasGroup);
    }

    /**
     * Should accept groups as array.
     * 
     * @test
     * @covers ::hasGroup
     */
    public function matchArrayOfGroups()
    {
        $user = array('usergroup' => '1', 'additionalgroups' => '2,3');
        $groups = array(3, 4);

        $hasGroup = Shinka_Core_Service_PermissionService::hasGroup($groups, $user);

        $this->assertTrue($hasGroup);
    }
    
    /**
     * Should not match groups.
     * 
     * @test
     * @covers ::hasGroup
     */
    public function notHaveGroup()
    {
        $user = array('usergroup' => '1', 'additionalgroups' => '2,3');
        $groups = '4,5,6';

        $hasGroup = Shinka_Core_Service_PermissionService::hasGroup($groups, $user);

        $this->assertFalse($hasGroup);
    }
    
    /**
     * Should assume false for empty groups.
     *
     * @test
     * @covers ::hasGroup
     */
    public function acceptEmptyGroups()
    {
        $user = array('usergroup' => '1', 'additionalgroups' => '2,3');
        $groups = '';

        $hasGroup = Shinka_Core_Service_PermissionService::hasGroup($groups, $user);

        $this->assertFalse($hasGroup);
    }
    
    /**
     * Should handle empty additionalgroups.
     * 
     * @test
     * @covers ::hasGroup
     */
    public function acceptEmptyAdditionalGroups()
    {
        $user = array('usergroup' => '1', 'additionalgroups' => '');
        $groups = '4,5,6';

        $hasGroup = Shinka_Core_Service_PermissionService::hasGroup($groups, $user);

        $this->assertFalse($hasGroup);
    }
    
    /**
     * Should match group against setting value.
     * 
     * @test
     * @covers ::canSetting
     */
    public function haveGroupFromSetting()
    {
        $setting = '1,2,3';
        $user = array('usergroup' => 1, 'additionalgroups' => '2,3');
        $can = Shinka_Core_Service_PermissionService::canSetting($setting, $user);

        $this->assertTrue($can);
    }
    
    /**
     * Should not match group against setting value.
     * 
     * @test
     * @covers ::canSetting
     */
    public function notHaveGroupFromSetting()
    {
        $setting = '4,5,6';
        $user = array('usergroup' => 1, 'additionalgroups' => '2,3');
        $can = Shinka_Core_Service_PermissionService::canSetting($setting, $user);

        $this->assertFalse($can);
    }
    
    /**
     * Should assume false when empty setting value.
     * 
     * @test
     * @covers ::canSetting
     */
    public function acceptEmptySettingValue()
    {
        $setting = '';
        $can = Shinka_Core_Service_PermissionService::canSetting($setting, $user);

        $this->assertFalse($can);
    }
    
    /**
     * Should assume true when setting value is `-1`.
     * 
     * @test
     * @covers ::canSetting
     */
    public function matchOnAll()
    {
        $setting = '-1';
        $can = Shinka_Core_Service_PermissionService::canSetting($setting, $user);

        $this->assertTrue($can);
    }
}

