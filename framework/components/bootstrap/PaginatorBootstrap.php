<?php
/**
 * Class PaginatorBootstrap
 *
 * @package framework
 * @filesource framework/components/bootstrap/PaginatorBootstrap.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */
namespace framework\components\bootstrap;
use framework\components\Paginator;
use framework\Model;
use framework\View;

class PaginatorBootstrap extends Paginator
{
    public function __construct(View $view = null, Model $model = null)
    {
        if ($view == null) {
            $tpl = "framework/resources/components/bootstrap/paginator";
            $view = new View();
            $view->loadCustomTemplate($tpl);
        }

        parent::__construct($view,$model);

        // Bootstrap customizations
        $this->previous =   "glyphicon glyphicon-step-backward";
        $this->next =       "glyphicon glyphicon-step-forward";
        $this->first =      "glyphicon glyphicon-fast-backward";
        $this->last =       "glyphicon glyphicon-fast-forward";
        $this->offModeHidden = true;
        $this->offValue = "nav-item hidden";
        $this->activeFlag = "nav-item active";
        // $this->offModeHidden = false;
        // $this->offValue = "nav-item disabled";
    }

}