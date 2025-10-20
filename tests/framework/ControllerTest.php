<?php

use PHPUnit\Framework\TestCase;
use framework\Controller;
use framework\Model;
use framework\View;

// Define minimal configuration constants required by the framework.
$rootPath = realpath(__DIR__ . '/tests');
$projectRoot = dirname($rootPath);

if (!defined('RELATIVE_PATH')) {
    define('RELATIVE_PATH', $projectRoot . DIRECTORY_SEPARATOR);
}
if (!defined('SECURING_OUTSIDE_HTTP_FOLDER')) {
    define('SECURING_OUTSIDE_HTTP_FOLDER', '');
}
if (!defined('APP_CONTROLLERS_PATH')) {
    define('APP_CONTROLLERS_PATH', $projectRoot . DIRECTORY_SEPARATOR . 'controllers');
}
if (!defined('APP_LOCALE_PATH')) {
    define('APP_LOCALE_PATH', $projectRoot . DIRECTORY_SEPARATOR . 'locales');
}
if (!defined('JSFRAMEWORK')) {
    define('JSFRAMEWORK', 'framework/js');
}
if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost');
}
if (!defined('SERVER_OS_ENCODING')) {
    define('SERVER_OS_ENCODING', 'Linux');
}
if (!defined('DEFAULT_LOGIN_PAGE')) {
    define('DEFAULT_LOGIN_PAGE', 'common/login');
}
if (!defined('LoginRBACWarningMessage')) {
    define('LoginRBACWarningMessage', 'login-rbac-warning');
}
if (!defined('LoginAuthWarningMessage')) {
    define('LoginAuthWarningMessage', 'login-auth-warning');
}
if (!defined('COMPRESS_OUTPUT')) {
    define('COMPRESS_OUTPUT', false);
}
if (!defined('CHARSET')) {
    define('CHARSET', 'UTF-8');
}
if (!defined('SUBSYSTEMS')) {
    define('SUBSYSTEMS', serialize(['sub']));
}

require_once $projectRoot . '/framework/Loader.php';
require_once $projectRoot . '/framework/Model.php';
require_once $projectRoot . '/framework/View.php';
require_once $projectRoot . '/framework/Controller.php';

class FakeModel extends Model
{
    public function __construct()
    {
        // Avoid opening a database connection during tests.
    }
}

class FakeView extends View
{
    private $content;

    public function __construct($content)
    {
        parent::__construct(null);
        $this->content = $content;
        $this->tpl = $content;
    }

    public function parse()
    {
        return $this->content;
    }
}

class TestableController extends Controller
{
    public $autorunCalled = false;

    protected function autorun($parameters = null)
    {
        $this->autorunCalled = true;
    }
}

final class ControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_GET = [];
        $_SESSION = [];
    }

    public function testGetNameReturnsFullyQualifiedClassName(): void
    {
        $view = new FakeView('<div id="all">content</div>');
        $model = new FakeModel();
        $controller = new TestableController($view, $model);

        $this->assertSame(TestableController::class, $controller->getName());
    }

    public function testSetViewUpdatesCurrentView(): void
    {
        $initialView = new FakeView('<div>initial</div>');
        $replacementView = new FakeView('<div>replacement</div>');
        $controller = new TestableController($initialView, new FakeModel());

        $controller->setView($replacementView);

        $this->assertSame($replacementView, $controller->getView());
    }

    public function testSetModelUpdatesCurrentModel(): void
    {
        $initialModel = new FakeModel();
        $replacementModel = new FakeModel();
        $controller = new TestableController(new FakeView('<div>test</div>'), $initialModel);

        $controller->setModel($replacementModel);

        $this->assertSame($replacementModel, $controller->getModel());
    }

    public function testSetObserverPollingIntervalChangesOnlyWhenUnset(): void
    {
        $controller = new TestableController(new FakeView('<div>test</div>'), new FakeModel());

        $controller->setObserverPollingInterval(1500);
        $controller->setObserverPollingInterval(2500);

        $reflection = new ReflectionClass($controller);
        $property = $reflection->getProperty('observerPollingInterval');
        $property->setAccessible(true);

        $this->assertSame(1500, $property->getValue($controller));
    }

    public function testResetObserversClearsInternalCounters(): void
    {
        $controller = new TestableController(new FakeView('<div>test</div>'), new FakeModel());

        $reflection = new ReflectionClass($controller);
        $counterProperty = $reflection->getProperty('observersCounter');
        $counterProperty->setAccessible(true);
        $counterProperty->setValue($controller, 3);

        $intervalProperty = $reflection->getProperty('observerPollingInterval');
        $intervalProperty->setAccessible(true);
        $intervalProperty->setValue($controller, 1500);

        $controller->resetObservers();

        $this->assertSame(0, $counterProperty->getValue($controller));
        $this->assertSame(0, $intervalProperty->getValue($controller));
    }

    public function testGetReturnsFullContentWhenAllRequested(): void
    {
        $content = '<html><body><div id="content">Hello</div></body></html>';
        $controller = new TestableController(new FakeView($content), new FakeModel());

        $this->assertSame($content, $controller->get('all'));
    }

    public function testGetReturnsSpecificSectionWhenRequested(): void
    {
        $controller = new TestableController(
            new FakeView('<html><body><div id="content">Hello</div></body></html>'),
            new FakeModel()
        );

        $section = $controller->get('content');

        $this->assertStringContainsString('<div id="content">Hello</div>', $section);
    }

    public function testAutorunIsInvokedForMainController(): void
    {
        $controller = new TestableController(new FakeView('<div>test</div>'), new FakeModel());

        $this->assertTrue($controller->autorunCalled);
    }

    public function testGetSubSystemDetectsCurrentSubsystem(): void
    {
        $_GET['url'] = 'sub/example';

        $controller = new TestableController(new FakeView('<div>test</div>'), new FakeModel());

        $this->assertSame('sub', $controller->getSubSystem());
    }

    public function testSetAsChildControllerSwitchesRootFlag(): void
    {
        $controller = new TestableController(new FakeView('<div>test</div>'), new FakeModel());

        $this->assertTrue($controller->isRootController());
        $this->assertFalse($controller->isChildController());

        $controller->setAsChildController();

        $this->assertFalse($controller->isRootController());
        $this->assertTrue($controller->isChildController());
    }
}