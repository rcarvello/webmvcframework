<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/View.php';
require_once RELATIVE_PATH . 'framework/Controller.php';
require_once RELATIVE_PATH . 'framework/RestService.php';

class RestServiceStub extends \framework\RestService
{
    public function __construct()
    {
        // Skip parent constructor to avoid HTTP header operations during tests.
    }
}

final class RestServiceTest extends TestCase
{
    private function getProperty(object $object, string $property)
    {
        $reflection = new ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);

        return $prop;
    }

    private function callPrivate(object $object, string $method, array $args = [])
    {
        $reflection = new ReflectionClass($object);
        $methodRef = $reflection->getMethod($method);
        $methodRef->setAccessible(true);

        return $methodRef->invokeArgs($object, $args);
    }

    public function testAllowMethodTracksAllowedOperations(): void
    {
        $service = new RestServiceStub();

        $service->allowMethod('fetch');

        $allowed = $this->getProperty($service, 'allowedMethods')->getValue($service);
        $this->assertContains('fetch', $allowed);
    }

    public function testAddCorsStoresAllowedOrigins(): void
    {
        $service = new RestServiceStub();

        $service->addCORS('https://example.com');
        $origins = $this->getProperty($service, 'accessControlAllowOrigins')->getValue($service);

        $this->assertSame(['https://example.com'], $origins);
    }

    public function testHttpPostRequestReturnsCurrentResult(): void
    {
        $service = new RestServiceStub();
        $resultProperty = $this->getProperty($service, 'result');
        $resultProperty->setValue($service, ['status' => 'ok']);

        $this->assertSame(['status' => 'ok'], $service->httpPostRequest('method', []));
    }

    public function testSwitchActionMergesOperationResult(): void
    {
        $service = new RestServiceStub();
        $resultProperty = $this->getProperty($service, 'result');
        $resultProperty->setValue($service, ['status' => 'ok']);
        $methodProperty = $this->getProperty($service, 'HTTPRequestMethod');
        $methodProperty->setValue($service, 'DELETE');

        $this->callPrivate($service, 'switchAction', ['remove', ['id' => 10]]);

        $updated = $resultProperty->getValue($service);
        $this->assertSame('DELETE', $updated['rest_operation']);
        $this->assertSame('ok', $updated['status']);
    }
}
