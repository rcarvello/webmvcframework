<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Model.php';
require_once RELATIVE_PATH . 'framework/MySqlRecord.php';
require_once RELATIVE_PATH . 'framework/BeanUser.php';
require_once RELATIVE_PATH . 'framework/User.php';


class UserStub extends \framework\User
{
    private $id;
    private $email;
    private $password;
    private $role;
    private $token;
    private $tokenTimeStamp;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getTokenTimeStamp()
    {
        return $this->tokenTimeStamp;
    }

    public function isLogged(): bool
    {
        return $this->id !== null && $this->email !== null && $this->password !== null;
    }

    public function validateToken(int $expirationHours = 8): bool
    {
        if ($this->token === null || $this->tokenTimeStamp === null) {
            return false;
        }
        $tokenTime = strtotime($this->tokenTimeStamp);
        $currentTime = time();
        return ($currentTime - $tokenTime) <= ($expirationHours * 3600);
    }

    public function __construct()
    {
        // Skip parent constructor to avoid database connection and session dependencies.
    }
}

final class UserTest extends TestCase
{
    private function setPrivateProperty(object $object, string $property, $value): void
    {
        $reflection = new ReflectionClass($object);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);
        $prop->setValue($object, $value);
    }

    public function testGettersReturnAssignedValues(): void
    {
        $user = new UserStub();
        $this->setPrivateProperty($user, 'id', 5);
        $this->setPrivateProperty($user, 'email', 'test@example.com');
        $this->setPrivateProperty($user, 'password', 'secret');
        $this->setPrivateProperty($user, 'role', 'admin');
        $this->setPrivateProperty($user, 'token', 'abc');
        $this->setPrivateProperty($user, 'tokenTimeStamp', '2024-01-01 00:00:00');

        $this->assertSame(5, $user->getId());
        $this->assertSame('test@example.com', $user->getEmail());
        $this->assertSame('secret', $user->getPassword());
        $this->assertSame('admin', $user->getRole());
        $this->assertSame('abc', $user->getToken());
        $this->assertSame('2024-01-01 00:00:00', $user->getTokenTimeStamp());
    }

    public function testIsLoggedChecksMandatoryFields(): void
    {
        $user = new UserStub();
        $this->setPrivateProperty($user, 'id', 1);
        $this->setPrivateProperty($user, 'email', 'user@example.com');
        $this->setPrivateProperty($user, 'password', 'pass');

        $this->assertTrue($user->isLogged());

        $this->setPrivateProperty($user, 'password', null);
        $this->assertFalse($user->isLogged());
    }

    public function testValidateTokenHonorsExpirationWindow(): void
    {
        $user = new UserStub();
        $this->setPrivateProperty($user, 'token', 'token');
        $this->setPrivateProperty($user, 'tokenTimeStamp', date('Y-m-d H:i:s', strtotime('+1 hour')));

        $this->assertTrue($user->validateToken());

        $this->setPrivateProperty($user, 'tokenTimeStamp', date('Y-m-d H:i:s', strtotime('-10 hours')));
        $this->assertFalse($user->validateToken());
    }
}
