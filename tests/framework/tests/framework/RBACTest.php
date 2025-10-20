<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/MySqlRecord.php';
require_once RELATIVE_PATH . 'framework/RBAC.php';

class RecordStub extends \framework\MySqlRecord
{
    public $allowAdd = false;

    public function __construct()
    {
        // Skip parent constructor.
    }
}

final class RBACTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \framework\RBAC::$permissions = [];
    }

    public function testSetRecordPermissionGrantsAddWhenPermissionPresent(): void
    {
        \framework\RBAC::$permissions = [\framework\RBAC::ADD => true];
        $record = new RecordStub();

        \framework\RBAC::setRecordPermission($record, 1);

        $this->assertTrue($record->allowAdd);
    }

    public function testSetRecordPermissionLeavesFlagFalseWhenPermissionMissing(): void
    {
        $record = new RecordStub();

        \framework\RBAC::setRecordPermission($record, 1);

        $this->assertFalse($record->allowAdd);
    }
}
