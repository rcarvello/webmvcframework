<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/BeanUser.php';

final class BeanUserTest extends TestCase
{
    public function testBeanUserInterfaceDefinesAccessors(): void
    {
        $reflection = new ReflectionClass(\framework\BeanUser::class);

        $this->assertTrue($reflection->isInterface());
        $expectedMethods = ['getId', 'getEmail', 'getPassword', 'getRole', 'getToken', 'getTokenTimeStamp'];

        foreach ($expectedMethods as $method) {
            $this->assertTrue($reflection->hasMethod($method));
        }
    }
}
