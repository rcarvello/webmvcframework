<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/Bean.php';
require_once RELATIVE_PATH . 'framework/BeanAdapter.php';

class FakeBeanImplementation
{
    public $calls = [];

    public function select(...$args)
    {
        $this->calls[] = ['select', $args];
        return 'select:' . implode('-', $args);
    }

    public function insert()
    {
        $this->calls[] = ['insert', []];
        return 'inserted';
    }

    public function delete(...$args)
    {
        $this->calls[] = ['delete', $args];
        return 'delete:' . implode('-', $args);
    }

    public function update(...$args)
    {
        $this->calls[] = ['update', $args];
        return 'update:' . implode('-', $args);
    }

    public function updateCurrent()
    {
        $this->calls[] = ['updateCurrent', []];
        return 'update-current';
    }

    public function isSqlError()
    {
        $this->calls[] = ['isSqlError', []];
        return false;
    }

    public function lastSqlError()
    {
        $this->calls[] = ['lastSqlError', []];
        return '';
    }
}

final class BeanAdapterTest extends TestCase
{
    private function createAdapter(FakeBeanImplementation $bean): \framework\BeanAdapter
    {
        $reflection = new ReflectionClass(\framework\BeanAdapter::class);
        /** @var \framework\BeanAdapter $adapter */
        $adapter = $reflection->newInstanceWithoutConstructor();
        $property = $reflection->getProperty('bean');
        $property->setAccessible(true);
        $property->setValue($adapter, $bean);

        return $adapter;
    }

    public function testAdapterDelegatesCallsToUnderlyingBean(): void
    {
        $bean = new FakeBeanImplementation();
        $adapter = $this->createAdapter($bean);

        $this->assertSame('select:10', $adapter->select(10));
        $this->assertSame('select:10-20', $adapter->select([10, 20]));
        $this->assertSame('inserted', $adapter->insert());
        $this->assertSame('delete:5', $adapter->delete(5));
        $this->assertSame('delete:7-8', $adapter->delete([7, 8]));
        $this->assertSame('update:3', $adapter->update(3));
        $this->assertSame('update:4-5', $adapter->update([4, 5]));
        $this->assertSame('update-current', $adapter->updateCurrent());
        $this->assertFalse($adapter->isSqlError());
        $this->assertSame('', $adapter->lastSqlError());

        $recorded = array_column($bean->calls, 0);
        $this->assertContains('select', $recorded);
        $this->assertContains('insert', $recorded);
        $this->assertContains('delete', $recorded);
        $this->assertContains('update', $recorded);
        $this->assertContains('updateCurrent', $recorded);
        $this->assertContains('isSqlError', $recorded);
        $this->assertContains('lastSqlError', $recorded);
    }
}
