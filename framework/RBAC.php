<?php

/**
 * Class RBAC
 *
 * @todo Class Implemetation
 * @package framework
 * @filesource framework/RBAC.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework;

use framework\Record;
class RBAC
{
    const ADD       = 'record_add';
    const UPDATE    = 'record_update';
    const DELETE    = 'record_delete';
    const CLOSE     = 'record_close';
    const RESET     = 'record_reset';

    public static $restricted = false;
    public static $roles = array();
    public static $permissions = array();


    public static function setRecordPermission(Record $record, $role)
    {
        if (isset(self::$permissions[self::ADD]))
            $record->allowAdd = true;
    }

}