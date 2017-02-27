<?php
/**
 * locale.config.php
 *
 * Main application language configuration parameters.
 * Optionally you can change those values according to your environment.
 *
 * @filesource locale.config.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

/**
 *  Application path where are located resource files for localization
 */
define("APP_LOCALE_PATH", RELATIVE_PATH . "locales");

/**
 *  Locale file name for the application (without extension, default is .txt)
 *  It contains a list of [Resource Identifier] = translation
 */
define("APPLICATION_LOCALE_FILE_NAME","application");

/**
 *  Locale file name for framework (without extension, default is .txt)
 *  It contains a list of pairs [Resource identifier]=translation strings.
 */
define("FRAMEWORK_LOCALE_FILE_NAME","framework");

/**
 * Default LCID locale, if null it look at client browser language
 * @see http://www.science.co.il/Language/Locale-codes.php for valid values of LCID
 */
define("CURRENT_LOCALE","en");

/**
 * Define the locale REQUEST parameter to handle localization files
 */
define("LOCALE_REQUEST_PARAMETER","locale");

/**
 *  Browser verb identifying language
 */
define("HTTP_ACCEPT_LANGUAGE","HTTP_ACCEPT_LANGUAGE");



