<?php
/**
 * security.config.php
 *
 * Main application security configuration parameters.
 * You can change those values according to your security MySQL environment.
 *
 * @filesource security.config.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

/**
 * Defines the constants for MySQL database User table.
 * Class User uses these information.
 */

/**
 *  Constant for the User MySQL Table
 */
define("USER_TABLE","user");

/**
 *  Defines a constant for INT Primary Key field of the User MySQL Table
 */
define("USER_ID","id");

/**
 *  Defines a constant for the UNIQUE email field of the User MySQL Table
 *  Email is used as credential
 */
define("USER_EMAIL","email");

/**
 *  Defines a constant for the password field of the User MySQL Table
 *  Password is used as credential
 */
define("USER_PASSWORD","password");

/**
 *  Defines a constant for the role field of the User MySQL Table
 *  User role defines access levels criteria managed by RBAC Engine
 */
define('USER_ROLE', 'role');