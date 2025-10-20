<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Loader.php';

final class LoaderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_SESSION = [];
    }

    public function testGetDirectoriesMergesSubsystemPaths(): void
    {
        $directories = \framework\Loader::getDirectories();

        $this->assertContains(APP_CONTROLLERS_PATH . DIRECTORY_SEPARATOR . 'sub', $directories);
        $this->assertContains(APP_VIEWS_PATH . DIRECTORY_SEPARATOR . 'sub', $directories);
        $this->assertContains(APP_MODELS_PATH . DIRECTORY_SEPARATOR . 'sub', $directories);
        $this->assertContains('framework', $directories);
    }

    public function testGetCurrentSubSystemDetectsLongestMatch(): void
    {
        $_SESSION = [];
        $sub = \framework\Loader::getCurrentSubSystem('sub/example');

        $this->assertSame('sub', $sub);
        $this->assertSame('sub', $_SESSION['current_subsystem']);
    }

    public function testListFoldersReturnsNestedDirectories(): void
    {
        $folders = \framework\Loader::listFolders(APP_CONTROLLERS_PATH);

        $this->assertContains('common', $folders);
        $this->assertContains('builders', $folders);
    }
}
