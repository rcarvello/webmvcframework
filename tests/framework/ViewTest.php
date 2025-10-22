<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/View.php';
require_once RELATIVE_PATH . 'framework/exceptions/MVCException.php';
require_once RELATIVE_PATH . 'framework/exceptions/NotInitializedViewException.php';
require_once RELATIVE_PATH . 'framework/exceptions/TemplateNotFoundException.php';
require_once RELATIVE_PATH . 'framework/exceptions/VariableNotFoundException.php';

class TestableView extends \framework\View
{
    public function __construct($content)
    {
        parent::__construct();
        $this->replaceTpl($content);
    }

}

final class ViewTest extends TestCase
{
    public function testSetVarReplacesPlaceholderInTemplate(): void
    {
        $template = 'Hello {NAME}';
        $view = new TestableView('Hello {NAME}');
        $view->setVar('NAME', 'World');

        $this->assertSame('Hello World', $view->parse());
    }

    public function testHideRemovesSpecificBlock(): void
    {
        $template = '<!-- BEGIN content --> Visible <!-- END content -->More Content';
        $view = new TestableView($template);
        $view->hide('content');
        $this->assertStringNotContainsString('Visible', $view->parse());
    }

    public function testReplaceTplOverridesContent(): void
    {
        $view = new TestableView('Original');
        $view->replaceTpl('New Content');

        $this->assertSame('New Content', $view->parse());
    }

    public function testOpenBlockThenParseThenCloseThenShow(): void
    {

        $users = array(
            array('UserName' => 'Mark', 'UserEmail' => 'mark@email.com'),
            array('UserName' => 'Elen', 'UserEmail' => 'elen@email.com'),
            array('UserName' => 'John', 'UserEmail' => 'john@email.com')
        );
        $template = '<!-- BEGIN Users -->[{UserName} {UserEmail}]<!-- END Users -->';
        $expected = '<!-- BEGIN Users -->[Mark mark@email.com][Elen elen@email.com][John john@email.com]<!-- END Users -->';
        $view = new TestableView($template);
        $view->openBlock("Users");
        foreach ($users as $user) {
            $view->setVar("UserName", $user["UserName"]);
            $view->setVar("UserEmail", $user["UserEmail"]);
            $view->parseCurrentBlock();
        }
        $view->setBlock();
        $this->assertSame($expected, $view->parse());
    }

}
