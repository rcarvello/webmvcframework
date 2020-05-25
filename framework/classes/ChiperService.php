<?php
/**
 * Class ChiperService
 * Crypt/Encrypt for user credentials cookie.
 *
 * @package framework
 * @filesource framework/User.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\classes;


class ChiperService
{
    const CREDENTIALS_COOKIE_SALT = CHIPER_CREDENTIALS_COOKIE_SALT;
    const CREDENTIALS_COOKIE_EXPIRATION_DATE = CHIPER_CREDENTIALS_COOKIE_EXPIRATION_DATE;
    const CREDENTIALS_COOKIE_SLIDING_EXPIRATION = CHIPER_CREDENTIALS_COOKIE_SLIDING_EXPIRATION;
    const CREDENTIALS_COOKIE_NAME = CHIPER_CREDENTIALS_COOKIE_NAME;

    private function cipherInit($key) {
        global $CipherBox, $CipherKey;
        $temp = '';
        $idx1 = 0;
        $idx2 = 0;
        $keyLength = strlen($key);
        for ($idx1 = 0; $idx1 < 256; $idx1++) {
            $CipherBox[$idx1] = $idx1;
            $CipherKey[$idx1] = ord($key[$idx1 % $keyLength]);
        }
        for ($idx1 = 0; $idx1 < 256; $idx1++) {
            $idx2 = ($idx2 + $CipherBox[$idx1] + $CipherKey[$idx1]) % 256;
            $temp = $CipherBox[$idx1];
            $CipherBox[$idx1] = $CipherBox[$idx2];
            $CipherBox[$idx2] = $temp;
        }
    }

    private function encryptString($inputStr, $key) {
        return strtoupper($this->bytesToHex($this->cipherEnDeCrypt($inputStr, $key)));
    }

    private function decryptString($inputStr, $key) {
        return $this->bytesToString($this->cipherEnDeCrypt($this->hexToBytes($inputStr), $key));
    }

    public function encryptDBPassword($password) {
        return md5($password);
    }

    private function cipherEnDeCrypt($inputStr, $key) {
        global $CipherBox;
        $result = array();
        $i = 0;
        $j = 0;
        $this->cipherInit($key);
        for ($a = 0; $a < strlen($inputStr); $a++) {
            $i = ($i + 1) % 256;
            $j = ($j + $CipherBox[$i]) % 256;
            $temp = $CipherBox[$i];
            $CipherBox[$i] = $CipherBox[$j];
            $CipherBox[$j] = $temp;
            $k = $CipherBox[(($CipherBox[$i] + $CipherBox[$j]) % 256)];
            $crypted = ord($inputStr[$a]) ^ $k;
            $result[$a] = $crypted;
        }
        return $result;
    }

    private function bytesToString($bytesArray) {
        $result = '';
        foreach ($bytesArray as $byte) {
            $result .= chr($byte);
        }
        return $result;
    }

    private function bytesToHex($bytesArray) {
        $result = '';
        foreach ($bytesArray as $byte) {
            $tmp = dechex($byte);
            $result .= str_repeat("0", 2 - strlen($tmp)) . $tmp;
        }
        return $result;
    }

    private function hexToBytes($hexstr) {
        $result = '';
        $num = 0;
        for ($i = 0; $i < strlen($hexstr); $i += 2) {
            $num = hexdec(substr($hexstr, $i, 1)) * 16;
            $num += hexdec(substr($hexstr, $i + 1, 1));
            $result .= chr($num);
        }
        return $result;
    }

    private function chiperSetCookie($parameter_name, $param_value, $expired = -1, $path = "/", $domain = "", $secured = false, $http_only = true)
    {
        $secured = isset($_SERVER["HTTPS"]);
        if ($expired == -1)
            $expired = time() + 3600 * 24 * 366;
        elseif ($expired && $expired < time())
            $expired = time() + $expired;
        setcookie ($parameter_name, $param_value, $expired, $path, $domain, $secured, $http_only);
    }

    private function chiperGetCookie($parameter_name)
    {
        return isset($_COOKIE[$parameter_name]) ? $_COOKIE[$parameter_name] : "";
    }

    /**
     * Creates Encrypted Cookie for user access credentials
     * @param $login
     * @param $password
     *
     */
    public function setCredentialsCookie($login, $password) {
        $login    = $this->encryptString($login, $this::CREDENTIALS_COOKIE_SALT);
        $password = $this->encryptString($password, $this::CREDENTIALS_COOKIE_SALT);
        $result   = $this->encryptString($login . ":" . $password . ":" . (time() + $this::CREDENTIALS_COOKIE_EXPIRATION_DATE), $this::CREDENTIALS_COOKIE_SALT);
        $this->chiperSetCookie($this:: CREDENTIALS_COOKIE_NAME, $result, time() + $this::CREDENTIALS_COOKIE_EXPIRATION_DATE, "/", "", false,true);
    }

    /**
     * Refreshes user credentials cookie expiration date
     *
     * @param $expirationDate
     */
    public function refreshCredentialsCookie($expirationDate) {
        if ($this::CREDENTIALS_COOKIE_SLIDING_EXPIRATION) {
            if (($expirationDate - ($this::CREDENTIALS_COOKIE_EXPIRATION_DATE / 2)) > time()) {
                list($login, $password, $expDate) = $this->parseCredentialsCookie($this:: CREDENTIALS_COOKIE_NAME);
                $this->setCredentialsCookie($login, $password);
            }
        }
    }

    /**
     * Parses user credentials cookie.
     *
     * @param $cookieName
     * @return array
     */
    public function parseCredentialsCookie($cookieName) {
        $cookieValue = $this->chiperGetCookie($cookieName);
        $decryptedCookieValue = (strlen($cookieValue)) ?  $this->decryptString($cookieValue, $this::CREDENTIALS_COOKIE_SALT) : "";
        $pos = strpos($decryptedCookieValue, ':');
        $parts = array();
        if ($pos) {
            $parts = explode(":", $decryptedCookieValue);
            $parts[0] = $this::decryptString($parts[0], $this::CREDENTIALS_COOKIE_SALT);
            $parts[1] = $this::decryptString($parts[1], $this::CREDENTIALS_COOKIE_SALT);
        }
        return $parts;
    }



}
