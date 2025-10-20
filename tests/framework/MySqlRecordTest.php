<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/MySqlRecord.php';

class TestableMySqlRecord extends \framework\MySqlRecord
{
    public function __construct()
    {
        // Skip parent constructor to avoid opening a database connection.
    }

    public function real_escape_string($string)
    {
        return addslashes($string);
    }
}

final class MySqlRecordTest extends TestCase
{
    private function getProtectedProperty(object $object, string $property)
    {
        $reflection = new ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);

        return $prop;
    }

    public function testLastSqlAndErrorAccessorsWork(): void
    {
        $record = new TestableMySqlRecord();
        $lastSqlProp = $this->getProtectedProperty($record, 'lastSql');
        $lastErrorProp = $this->getProtectedProperty($record, 'lastSqlError');

        $lastSqlProp->setValue($record, 'SELECT 1');
        $lastErrorProp->setValue($record, 'error');

        $this->assertSame('SELECT 1', $record->lastSql());
        $this->assertSame('error', $record->lastSqlError());
        $this->assertTrue($record->isSqlError());

        $resetMethod = (new ReflectionClass($record))->getMethod('resetLastSqlError');
        $resetMethod->setAccessible(true);
        $resetMethod->invoke($record);

        $this->assertFalse($record->isSqlError());
    }

    public function testParseValueCastsAndFormatsData(): void
    {
        $record = new TestableMySqlRecord();
        $reflection = new ReflectionClass($record);
        $method = $reflection->getMethod('parseValue');
        $method->setAccessible(true);

        $this->assertSame(10, $method->invoke($record, '10', 'int'));
        $this->assertSame("'abc'", $method->invoke($record, 'abc', 'string'));
        $this->assertSame("STR_TO_DATE('2024-01-01','" . STORED_DATE_FORMAT . "')", $method->invoke($record, '2024-01-01', 'date'));
        $this->assertSame('NULL', $method->invoke($record, null, 'string'));
    }

    public function testReplaceAposBackSlashAndSuccessLast(): void
    {
        $record = new TestableMySqlRecord();
        $reflection = new ReflectionClass($record);
        $method = $reflection->getMethod('replaceAposBackSlash');
        $method->setAccessible(true);

        $this->assertSame("O'Reilly", $method->invoke($record, "O\\'Reilly"));
        $this->assertSame('path\\file', $method->invoke($record, 'path\\\\file'));

        $record->affected_rows = 2;
        $this->assertTrue($record->successLast());
        $record->affected_rows = 0;
        $this->assertFalse($record->successLast());
    }
}
