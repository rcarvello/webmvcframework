<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Loader.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/View.php';
require_once RELATIVE_PATH . 'framework/Controller.php';
require_once RELATIVE_PATH . 'framework/Dispatcher.php';

final class DispatcherTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_GET = [];
        $_SESSION = [];
    }

    private function getPrivateProperty(object $object, string $property)
    {
        $reflection = new ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);

        return $prop->getValue($object);
    }

    private function invokePrivateMethod(object $object, string $method, array $args = [])
    {
        $reflection = new ReflectionClass($object);
        $methodRef = $reflection->getMethod($method);
        $methodRef->setAccessible(true);

        return $methodRef->invokeArgs($object, $args);
    }

    public function testDispatcherParsesUrlSegmentsIntoProperties(): void
    {
        $_GET['url'] = 'example/show/42';

        $dispatcher = new \framework\Dispatcher();

        $this->assertSame('controllers\\example', $this->getPrivateProperty($dispatcher, 'controllerClass'));
        $this->assertSame('show', $this->getPrivateProperty($dispatcher, 'method'));
        $this->assertSame(['42'], $this->getPrivateProperty($dispatcher, 'methodParameters'));
        $this->assertSame('example', $this->getPrivateProperty($dispatcher, 'controllerSEOClassName'));
        $this->assertSame('', $this->getPrivateProperty($dispatcher, 'currentSubSystem'));
        $this->assertArrayHasKey('example', $_SESSION);
    }

    public function testDispatcherSupportsSubsystems(): void
    {
        $_GET['url'] = 'sub/report/list';

        $dispatcher = new \framework\Dispatcher();

        $this->assertSame('controllers\\sub\\report', $this->getPrivateProperty($dispatcher, 'controllerClass'));
        $this->assertSame('list', $this->getPrivateProperty($dispatcher, 'method'));
        $this->assertSame([], $this->getPrivateProperty($dispatcher, 'methodParameters'));
        $this->assertSame('report', $this->getPrivateProperty($dispatcher, 'controllerSEOClassName'));
        $this->assertArrayHasKey('report', $_SESSION);
    }

    public function testUnderscoreToCamelCaseConvertsSeoNames(): void
    {
        unset($_GET['url']);
        $dispatcher = new \framework\Dispatcher();

        $result = $this->invokePrivateMethod($dispatcher, 'underscoreToCamelCase', ['user_profile']);

        $this->assertSame('userProfile', $result);
    }
}
