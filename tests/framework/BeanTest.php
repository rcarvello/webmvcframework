<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Bean.php';

final class BeanTest extends TestCase
{
    public function testBeanInterfaceDefinesExpectedMethods(): void
    {
        $reflection = new ReflectionClass(\framework\Bean::class);

        $this->assertTrue($reflection->isInterface());
        $expectedMethods = ['select', 'insert', 'delete', 'update', 'updateCurrent', 'isSqlError', 'lastSqlError'];

        foreach ($expectedMethods as $method) {
            $this->assertTrue($reflection->hasMethod($method));
        }
    }
}
