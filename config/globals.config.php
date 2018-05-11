<?php
/**
 * gobal.config.php
 *
 * Main application global placeholders.
 * Scope and use:
 * A global placeholder can be used inside a template with the following
 * notation:{GLOBAL:PLACEHOLDER_NAME}. Template engine will replace it
 * automatically with its corresponding value.
 * Define:
 * A global placeholder is a common PHP defined constant that must be prefixed
 * with GLOBAL_.
 *
 * @filesource global.config.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

define("GLOBAL_SITEURL",SITEURL);
define("GLOBAL_LOGIN_PAGE",DEFAULT_LOGIN_PAGE);
