<?php
/**
 * Class SorterBootstrap
 *
 * @package framework
 * @filesource framework/components/bootstrap/SorterBootstrap.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\components\bootstrap;
use framework\components\Sorter;
use framework\Model;
use framework\View;

class SorterBootstrap extends Sorter
{
    /**
     * @var string The value to show for sorter direction when ASC
     */
    public $captionForDirectionUp   = '<i class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></i>';

    /**
     * @var string The value to show for sorter direction when DESC
     */
    public $captionForDirectionDown = '<i class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></i>';

    public function __construct()
    {
        parent::__construct();
        // $this->view->loadCustomTemplate("framework/resources/components/bootstrap/sorter");
    }
}