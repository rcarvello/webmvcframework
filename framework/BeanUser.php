<?php
/**
 * Interface BeanUser
 *
 * @package framework
 * @filesource framework/BeanUser.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

/**
 * Interface BeanUser
 * Defines public method for application's user
 *
 * @package framework
 */
interface BeanUser
{

    /**
     * Returns user's email.
     * @return mixed User email
     */
    public function getId();

    /**
     * Returns user's email.
     * @return mixed User email
     */
    public function getEmail();

    /**
     * Returns user's password
     * @return mixed User password
     */
    public function getPassword();

    /**
     * Returns user's role.
     * @return mixed User Role
     */
    public function getRole();
}