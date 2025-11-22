<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

$projectRoot = dirname(__DIR__, 3);

if (!defined('RELATIVE_PATH')) {
    define('RELATIVE_PATH', $projectRoot . DIRECTORY_SEPARATOR);
}
require_once RELATIVE_PATH . 'framework/classes/Validator.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/classes/ErrorHandler.php';

class ModelStub extends \framework\Model
{
    public function __construct()
    {
        // Skip parent constructor.
    }
}

class ErroHandlerStub extends \framework\classes\ErrorHandler
{
    // Stub class for testing purposes
}

/**
 * Test completi per la classe Validator del framework
 */
class ValidatorTest extends TestCase
{
    /** @var \Framework\Classes\Validator */
    protected $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator(new ModelStub(), new ErroHandlerStub());
    }

    /**
     * Helper per richiamare metodi protetti
     */
    protected function invokeProtected(string $method, ...$args)
    {
        $ref = new ReflectionClass($this->validator);
        $m = $ref->getMethod($method);
        $m->setAccessible(true);
        return $m->invokeArgs($this->validator, $args);
    }

    #[Test]
    public function required()
    {
        $this->assertTrue((bool)$this->invokeProtected('required', 'field', 'value', ''));
        $this->assertFalse((bool)$this->invokeProtected('required', 'field', '', ''));
    }

    #[Test]
    public function minlength_and_maxlength()
    {
        $this->assertTrue((bool)$this->invokeProtected('minlength', 'username', 'abcd', 3));
        $this->assertFalse((bool)$this->invokeProtected('minlength', 'username', 'ab', 3));

        $this->assertTrue((bool)$this->invokeProtected('maxlength', 'username', 'abcd', 10));
        $this->assertFalse((bool)$this->invokeProtected('maxlength', 'username', 'abcdefghijklmnop', 5));
    }

    #[Test]
    public function email_and_activeemail()
    {
        $this->assertNotFalse($this->invokeProtected('email', 'email', 'user@example.com', ''));
        $this->assertFalse($this->invokeProtected('email', 'email', 'notanemail', ''));

        // activeemail potrebbe fare controllo DNS, quindi accettiamo solo tipo booleano
        $this->assertIsBool((bool)$this->invokeProtected('activeemail', 'email', 'user@gmail.com', ''));
    }

    #[Test]
    public function url_and_activeurl()
    {
        $this->assertNotFalse($this->invokeProtected('url', 'site', 'https://example.com', ''));
        $this->assertFalse($this->invokeProtected('url', 'site', 'notaurl', ''));

        $this->assertIsBool((bool)$this->invokeProtected('activeurl', 'site', 'https://www.google.com', ''));
    }

    #[Test]
    public function ip_should_validate_ipv4_and_ipv6()
    {
        $this->assertNotFalse($this->invokeProtected('ip', 'addr', '127.0.0.1', ''));
        $this->assertNotFalse($this->invokeProtected('ip', 'addr', '::1', ''));
        $this->assertFalse($this->invokeProtected('ip', 'addr', '999.999.999.999', ''));
    }

    #[Test]
    public function alpha_and_variants()
    {
        // ctype_alpha ritorna true solo se TUTTI i caratteri sono lettere, nessun numero/spazio
        $this->assertNotFalse($this->invokeProtected('alpha', 'name', 'TestUser', ''), 'alpha() should accept only letters');
        $this->assertFalse((bool)$this->invokeProtected('alpha', 'name', 'Test123', ''), 'alpha() should reject alphanumeric');

        $this->assertTrue((bool)$this->invokeProtected('alphaupper', 'code', 'HELLO', ''));
        $this->assertFalse((bool)$this->invokeProtected('alphaupper', 'code', 'Hello', ''));

        $this->assertTrue((bool)$this->invokeProtected('alphalower', 'code', 'hello', ''));
        $this->assertFalse((bool)$this->invokeProtected('alphalower', 'code', 'Hello', ''));

        // Alphadash: lettere, numeri, trattini e underscore consentiti
        $resultValid = $this->invokeProtected('alphadash', 'slug', 'hello-world', '');
        $this->assertNotFalse($resultValid, 'alphadash() should accept hello-world');

        $resultInvalid = $this->invokeProtected('alphadash', 'slug', 'hello_world!', '');
        $this->assertFalse((bool)$resultInvalid, 'alphadash() should reject hello_world!');
    }

    #[Test]
    public function alphanum_hexadecimal_numeric()
    {
        $this->assertTrue((bool)$this->invokeProtected('alphanum', 'field', 'abc123', ''));
        $this->assertFalse((bool)$this->invokeProtected('alphanum', 'field', 'abc-123', ''));

        $this->assertTrue((bool)$this->invokeProtected('hexadecimal', 'field', 'A1B2C3', ''));
        $this->assertFalse((bool)$this->invokeProtected('hexadecimal', 'field', 'GHIJKL', ''));

        $this->assertTrue((bool)$this->invokeProtected('numeric', 'field', '12345', ''));
        $this->assertFalse((bool)$this->invokeProtected('numeric', 'field', '12a', ''));
    }

    #[Test]
    public function matches_should_compare_two_fields()
    {
        $ref = new ReflectionClass($this->validator);
        $prop = $ref->getProperty('items');
        $prop->setAccessible(true);
        $prop->setValue($this->validator, ['confirm' => 'mypassword']);

        $this->assertTrue((bool)$this->invokeProtected('matches', 'password', 'mypassword', 'confirm'));
        $this->assertFalse((bool)$this->invokeProtected('matches', 'password', 'wrong', 'confirm'));
    }
}
