<?php
/**
 * Class ACE
 *
 * @todo Class implementation
 * @package framework
 * @filesource framework/Ace.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

class Ace
{
    private $role;
    private $permission;

    /**
     * Acl constructor.
     * @param string $role
     * @param string $permission
     */
    public function __construct($role, $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Sets role
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Sets permission
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

}