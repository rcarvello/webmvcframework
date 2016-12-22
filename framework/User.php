<?php
/**
 * Class User
 *
 * @package framework
 * @filesource framework/User.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

class User extends MySqlRecord implements BeanUser
{
    private $userTable;
    private $fieldUserId;
    private $fieldUserEmail;
    private $fieldUserPassword;
    private $fieldUserRole;
    private $id;
    private $email;
    private $password;
    private $role;
    private $useMd5Password;

    /**
     * Gets user id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets user email
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Gets user password
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets user role
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * User constructor.
     * Create a  Session User object using the given credentials. If credentials were null
     * and a user was previously logged in, it gets user data from a Session variable.
     * If no user is previously logged in and any credential were given it returns an empty
     * object.
     *
     * @param string|null $email User email
     * @param string|null $password User Password
     * @param bool|true $useMd5Password Default use md5 password to check credentials
     */
    public function __construct($email = null, $password = null, $useMd5Password = true)
    {
        parent::__construct();
        $this->userTable = USER_TABLE;
        $this->fieldUserId = USER_ID;
        $this->fieldUserEmail = USER_EMAIL;
        $this->fieldUserPassword = USER_PASSWORD;
        $this->fieldUserRole = USER_ROLE;
        $this->useMd5Password = $useMd5Password;
        if (isset($_SESSION["user"])) {
            $this->unserializeUser();
        } elseif ($email != null && $password != null) {
            $this->login($email, $password);
        }
    }

    /**
     * Login user
     * @param string $mail User email
     * @param string $password User password
     * @return bool
     */
    public function login($email, $password)
    {
        $email = $this::real_escape_string($email);
        $password = $this::real_escape_string($password);
        if ($this->useMd5Password)
            $password = md5($password);
        $sql = "SELECT * FROM {$this->userTable} WHERE {$this->fieldUserEmail}={$this->parseValue($email,'string')} AND {$this->fieldUserPassword}={$this->parseValue($password,'string')}";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->resultSet = $result;
        $this->lastSql = $sql;
        if ($result) {
            $rowObject = $result->fetch_object();;
            $this->id = $rowObject->{$this->fieldUserId};
            $this->email = $rowObject->{$this->fieldUserEmail};
            $this->password = $rowObject->{$this->fieldUserPassword};
            $this->role = $rowObject->{$this->fieldUserRole};
            $this->serializeUser();
            return true;
        } else {
            $this->lastSqlError = $this->sqlstate . " - " . $this->error;
            return false;
        }
    }

    /**
     * @return bool
     */
    public function logout()
    {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            $this->id = null;
            $this->email = null;
            $this->password = null;
            $this->role = null;
        }
        return true;
    }

    public function isLogged()
    {
        if (!empty($this->id) && !empty($this->email) && !empty($this->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkForLogin()
    {
        if (!$this->isLogged()) {
            header('Location: ' . DEFAULT_LOGIN_PAGE);
        }
    }

    private function serializeUser()
    {
        $_SESSION["user"] = serialize($this);
        return true;
    }

    private function unserializeUser()
    {
        $user = unserialize($_SESSION["user"]);
        $this->id = $user->getId();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
        $this->role = $user->getRole();
        return true;
    }

}