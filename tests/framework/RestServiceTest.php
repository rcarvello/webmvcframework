<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/View.php';
require_once RELATIVE_PATH . 'framework/Controller.php';
require_once RELATIVE_PATH . 'framework/RestService.php';

class ModelStub extends framework\Model
{
    public function __construct()
    {
        // Do not call parent constructor to avoid DB connection
    }
}

class ViewStub extends framework\View
{
    public function __construct()
    {
        $template = 'Template Stub';
        $this->replaceTpl($template);

    }
}
class RestServiceStub extends \framework\RestService
{

    public function __construct($view = null, $model = null)
    {
        parent::__construct(new ViewStub(), new ModelStub());
    }

}

final class RestServiceTest extends TestCase
{

    public function testAllowMethodTracksAllowedOperations(): void
    {
        $service = new RestServiceStub();
        $service->allowMethod('fetch');
        $allowed = $service->getAllowedMethods();
        $this->assertContains('fetch', $allowed);
    }

    public function testAddCorsStoresAllowedOrigins(): void
    {
        $service = new RestServiceStub();
        $service->addCORS('https://example.com');
        $origins = $service->getAccessControlAllowOrigins();
        $this->assertSame(['https://example.com'], $origins);
    }

    public function testHttpPostRequestReturnsCurrentResult(): void
    {
        $service = new RestServiceStub();
        $service->allowMethod('fetch');
        $resultProperty = $service->httpPostRequest('fetch', 1);
        $expected = ['message:' => 'Web MVC REST Service.', 'status:' => 'ok'];
        $this->assertSame($expected, $resultProperty['body_data:']);
    }

}
