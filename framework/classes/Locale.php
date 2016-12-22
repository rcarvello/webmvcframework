<?php
/**
 * Class Locale
 *
 * Manages Localozation Files.
 *  A localization file contains a list of [Resource identifier] = translation strings.
 *  Translations can be applied to all placeholder having the format {RES:Variable}
 *  of a given text file or string.
 *
 * @package framework\classes
 * @filesource framework\classes\Locale.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @see framework/Record
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\classes;

class Locale
{
    const DEFAULT_LCID = "it-it";
    private $currentLocale = CURRENT_LOCALE;
    private $messages = array();
    private $frameworkLocaleFileName;
    private $applicationLocaleFileName;

    /**
     * Locale constructor.
     * @param string|constant:HTTP_ACCEPT_LANGUAGE $HHTPHeader
     *
     */
    public function __construct($HHTPHeader = HTTP_ACCEPT_LANGUAGE)
    {
        if (!isset($_REQUEST[LOCALE_REQUEST_PARAMETER])) {
            $this->setLocaleFromHttpHeader($HHTPHeader);
            $this->init();
        } else {
            $this->setLocale($_REQUEST[LOCALE_REQUEST_PARAMETER]);
        }
    }

    /**
     * Inizialize Framework and Application locale.
     * Default locale is class constant DEFAULT_LCID.
     *
     */
    private function init()
    {
        if (empty($this->currentLocale))
            $this->currentLocale = self::DEFAULT_LCID;

        $defaultFrameworkLocaleFileName = "framework" . DIRECTORY_SEPARATOR . APP_LOCALE_PATH . DIRECTORY_SEPARATOR . self::DEFAULT_LCID . DIRECTORY_SEPARATOR . FRAMEWORK_LOCALE_FILE_NAME . ".txt";
        $defaultApplicationLocaleFileName = APP_LOCALE_PATH . DIRECTORY_SEPARATOR . self::DEFAULT_LCID . DIRECTORY_SEPARATOR . APPLICATION_LOCALE_FILE_NAME . ".txt";

        if (!isset($_SESSION["LocaleMessages"]) || $_SESSION["LocaleMessages"] == "") {
            $this->frameworkLocaleFileName = "framework" . DIRECTORY_SEPARATOR . "locales" . DIRECTORY_SEPARATOR . $this->currentLocale . DIRECTORY_SEPARATOR . FRAMEWORK_LOCALE_FILE_NAME . ".txt";
            $this->applicationLocaleFileName = APP_LOCALE_PATH . DIRECTORY_SEPARATOR . $this->currentLocale . DIRECTORY_SEPARATOR . APPLICATION_LOCALE_FILE_NAME . ".txt";

            if (file_exists($this->frameworkLocaleFileName)) {
                $messages = $this->loadLocaleFiles($this->frameworkLocaleFileName);
                $this->messages = array_merge($messages, $this->messages);
            } else {
                if (file_exists($defaultFrameworkLocaleFileName)) {
                    $messages = $this->loadLocaleFiles($defaultFrameworkLocaleFileName);
                    $this->messages = array_merge($messages, $this->messages);
                    $this->currentLocale = self::DEFAULT_LCID;
                }
            }

            if (file_exists($this->applicationLocaleFileName)) {
                $messages = $this->loadLocaleFiles($this->applicationLocaleFileName);
                $this->messages = array_merge($messages, $this->messages);
            } else {
                if (file_exists($defaultApplicationLocaleFileName)) {
                    $messages = $this->loadLocaleFiles($defaultApplicationLocaleFileName);
                    $this->messages = array_merge($messages, $this->messages);
                    $this->currentLocale = self::DEFAULT_LCID;
                }
            }

            $_SESSION["CurrentLocale"] = $this->currentLocale;
            $_SESSION["LocaleMessages"] = serialize($this->messages);
        }
    }

    /**
     * Gets locale from currente HTTP Headers
     *
     * @param string|constant:HTTP_ACCEPT_LANGUAGE $HHTPHeader
     */
    private function setLocaleFromHttpHeader($HHTPHeader = HTTP_ACCEPT_LANGUAGE)
    {
        if (!empty($_SESSION["CurrentLocale"]))
            return;
        if (!empty($this->currentLocale))
            return;
        if (!isset($_SERVER[$HHTPHeader])) {
            $this->currentLocale = "it-it";
        }
        $localeInfo = explode(",", strtolower($_SERVER[$HHTPHeader]));
        $this->currentLocale = $localeInfo[0];
        $_SESSION["CurrentLocale"] = $this->currentLocale;
    }

    /**
     * Loads a files of locales.
     * It contains a list of [Resource identifier] = translation
     *
     * @param string $fileName Filename containing messages
     * @return array The array of messages
     */
    public function loadLocaleFiles($fileName)
    {
        $messages = array();
        if (file_exists($fileName)) {
            $file = fopen($fileName, "r");
            while (!feof($file)) {
                $line = fgets($file);
                if ((substr($line, 0, 6)) == "#Load:") {
                    $child = substr($line, 6);
                    $child = str_replace("/", DIRECTORY_SEPARATOR, $child);
                    $child = trim(preg_replace('/\s+/', ' ', $child));
                    $messages = array_merge($this->loadLocaleFiles($child), $messages);
                } elseif ((substr($line, 0, 9)) != "#Comment:") {
                    $infoLine = explode("=", $line);
                    if (isset($infoLine))
                        @$messages[$infoLine[0]] = $infoLine[1];
                }
            }
            fclose($file);
        }
        return $messages;
    }

    /**
     * Get value from the current locale messages.
     * If $optional is given the method merge it with current locale messages.
     *
     * @param string $keyName The key of the message from witch obtain  value
     * @param null|array $optiolnals An optional array containing optional messages
     *                               to merge with current locale messages
     * @return string The corresponding fetched value to the given $keyName
     */
    public static function getLocaleMessage($keyName, $optiolnals = null)
    {
        $messages = unserialize($_SESSION["LocaleMessages"]);
        if (!empty($optiolnals)) {
            $messages = array_merge($messages, $optiolnals);
        }
        return $messages[$keyName];
    }

    /**
     * Get value from the current RES:locale messages.
     * If $optional is given the method merge it with current locale messages.
     *
     * @param string $resName The resuorce key of the message from witch obtain  value
     * @param null|array $optiolnals An optional array containing optional messages
     *                               to merge with current locale messages
     * @return string The corresponding fetched value to the given $keyName
     */
    public function getResLocaleMessage($resName, $optiolnals = null)
    {
        $resName = str_replace("{RES:", "", $resName);
        $resName = str_replace("}", "", $resName);
        return $this->getLocaleMessage($resName, $optiolnals);
    }

    /**
     * Applies all message from the current locale messages to the given text.
     * If $optional is given the method merge it with current locale messages.
     *
     * @param string $text The text to applies messages
     * @param null|array $optiolnals An optional array containing optional messages
     *                               to merge with current locale messages
     * @return string The transletd text
     */
    public static function applyLocaleMessages($text, $optiolnals = null)
    {
        //$regex = "/{RES:([^}]*)}/s";
        $regex = "/{RES:(.*?)}/";
        @preg_match_all($regex, $text, $result);
        $resourceVars = $result[0];
        foreach ($resourceVars as $var) {
            $search = str_replace("{RES:", "", $var);
            $search = str_replace("}", "", $search);
            @$value = self::getLocaleMessage($search, $optiolnals);
            if (!empty($value)) {
                $value = trim(preg_replace('/\s+/', ' ', $value));
                $text = str_replace($var, $value, $text);
            }
        }
        // This obscure
        // $text = trim(preg_replace('/\s+/', ' ', $text));
        return $text;
    }

    /**
     * Set Locale Code.
     * @param string $locale The language code ID(LCID). Eg.:it-it, en etc.
     * @see http://www.science.co.il/Language/Locale-codes.php for valid values of LCID
     */
    public function setLocale($locale)
    {
        $_SESSION["CurrentLocale"] = null;
        $_SESSION["LocaleMessages"] = null;
        $this->currentLocale = $locale;
        $this->init();
    }

    /**
     * Gets the current Locale.
     *
     * @return string
     */
    public function getCurrenLocale()
    {
        return $_SESSION["CurrentLocale"];
    }
}
