<?php
/**
 * Class User
 *
 * Manages users object, session and the user authentication.
 *
 * @package framework
 * @filesource framework/User.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License.
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

use framework\classes\ChiperService;

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
     *
     * Create a  Session User object using the given credentials.
     * - If credentials were null and a user was previously logged in, it gets user
     * data from a Session variable or Cookies.
     * - If no user is previously logged in and any credential were given it returns
     * an empty object.
     *
     * @param string|null $email User email
     * @param string|null $password User Password
     * @param bool|true $useMd5Password Default use md5 password to check against
     *                                  db stored credentials
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

        // If email and password are null try to set
        // them with cookie values.
        // $this->autoLoginFromCookies();

        if (isset($_SESSION["user"])) {
            $this->unserializeUser();
        } elseif ($email != null && $password != null) {
            $this->login($email, $password);
        }
    }

    /**
     * Login user
     *
     * @param string $mail User email
     * @param string $password User password
     * @return bool True if login oke, else false
     */
    public function login($email, $password)
    {
        $email = $this::real_escape_string($email);
        $password = $this::real_escape_string($password);
        // TODO use  PHP 5.4 password() crypt algo
        if ($this->useMd5Password)
            $password = md5($password);
        $sql = "SELECT * FROM {$this->userTable} WHERE {$this->fieldUserEmail}={$this->parseValue($email,'string')} AND {$this->fieldUserPassword}={$this->parseValue($password,'string')}";
        if (USER_ENABLED != "")
            $sql .=  " AND ". USER_ENABLED . "=1";
        $this->resetLastSqlError();
        $result = $this->query($sql);
        $this->resultSet = $result;
        $this->lastSql = $sql;
        if ($result && $result->num_rows === 1 ) {
            $rowObject = $result->fetch_object();
            $this->id = $rowObject->{$this->fieldUserId};
            $this->email = $rowObject->{$this->fieldUserEmail};
            $this->password = $rowObject->{$this->fieldUserPassword};
            $this->role = $rowObject->{$this->fieldUserRole};
            $this->serializeUser();
            return true;
        } else {
            $this->logout();
            $this->lastSqlError = $this->sqlstate . " - " . $this->error;
            return false;
        }
    }

    /**
     * Logout user
     *
     * @return bool always true
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
        $chiper = new ChiperService();
        $secured = isset($_SERVER["HTTPS"]);
        setcookie($chiper::CREDENTIALS_COOKIE_NAME,"",time() - 3600, "/",null,$secured,true);
        session_destroy();
        return true;
    }

    /**
     * Checks if user is logged
     *
     * @return bool True or False
     */
    public function isLogged()
    {
        if (!empty($this->id) && !empty($this->email) && !empty($this->password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if user is logged in. If none it redirects.
     *
     * @param string $redirect The Controller url path to redirecting if user is not logged in.
     *                         If null it redirects to the default login page.
     * @param null|string $returnLink The return link after loggin in with the the dafault
     *                    login page
     * @param null|string $LoginWarningMessage  A custom warning message to show
     *
     */
    public function checkForLogin($redirect = null, $returnLink= null, $LoginWarningMessage=null)
    {
        $this->autoLoginFromCookies();
        $returnLink = (!empty($returnLink)) ? "?return_link=$returnLink": "";
        $LoginWarningMessage=(!empty($LoginWarningMessage)) ? "&login_warning_message=$LoginWarningMessage": "";
        if (empty($redirect))
            $redirect = SITEURL . "/" . DEFAULT_LOGIN_PAGE;
        if (!$this->isLogged()) {
            header('Location: ' . $redirect . $returnLink . $LoginWarningMessage);
        }
    }

    /**
     * Auto login by using Cookies
     * Note:
     * It uses ChiperService class to decrypt Cookie
     *
     *@uses ChiperService
     *
     */
    public function autoLoginFromCookies()
    {
        if (!$this->isLogged()){
            $chiper = new ChiperService();
            $parts = $chiper->parseCredentialsCookie($chiper::CREDENTIALS_COOKIE_NAME);
            if (isset($parts) && (count($parts) > 2))
                list($username, $password, $expirationDate) = $parts;
            if ( !empty($expirationDate) && $expirationDate > time()) {
                if (!empty($username) && !empty($password)) {
                    $this->login($username, $password);
                    if ($this->isLogged())
                        $chiper->refreshCredentialsCookie($expirationDate);
                }
            }
        }
    }

    /**
     * Serializes User
     *
     * @return bool
     */
    private function serializeUser()
    {
        $_SESSION["user"] = serialize($this);
        return true;
    }

    /**
     * Unserializes user.
     *
     * @return bool
     */
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
