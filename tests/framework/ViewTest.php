<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/View.php';

class TestableView extends \framework\View
{
    public function __construct($content)
    {
        $this->tpl = $content;
        $this->blocks = [];
        $this->currentBlock = '';
    }
}

final class ViewTest extends TestCase
{
    public function testSetVarReplacesPlaceholderInTemplate(): void
    {
        $view = new TestableView('Hello {NAME}');
        $view->setVar('NAME', 'World');

        $this->assertSame('Hello World', $view->parse());
    }

    public function testHideRemovesSpecificBlock(): void
    {
        $template = '<!-- BEGIN content -->Visible<!-- END content -->';
        $view = new TestableView($template);

        $view->hide('content');

        $this->assertStringNotContainsString('Visible', $view->parse());
    }

    public function testSetVarTemplatePathInjectsSiteUrl(): void
    {
        $view = new TestableView('Path: {TEMPLATE_PATH}');

        $view->setVarTemplatePath();

        $this->assertSame('Path: ' . SITEURL . '/', $view->parse());
    }

    public function testReplaceTplOverridesContent(): void
    {
        $view = new TestableView('Original');
        $view->replaceTpl('New Content');

        $this->assertSame('New Content', $view->parse());
    }
}
