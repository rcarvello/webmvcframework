<?php

/**
 * Class Component
 *
 * The MVC Component class is an abstraction for a set of specialized components.
 * A component is an entity that implements some common and generalized behaviours
 * recurring during web application development. Sometimes these behaviours are well
 * known as "aspects" and, for example, some of these are: record pagination, table sorting,
 * record submission and so on.
 * Components may also have a GUI interface which is designed into an external HTML file
 * (that acts as template for the user interface) which is itself managed by a View object.
 * By default many graphic components are provided with a predefined GUI HTML template. User
 * can also replace a predefined template with a custom one that codes a custom graphic
 * experience.* It's important that a User, by replacing a default HTML template, must take
 * care to reproduce all BLOCKS and PLACEHOLDERS designed into the default one.
 * Finally User can bind the component's GUI into a special placeholder placed inside a View
 * template. This placeholder has the following format:
 *              {ComponentType:ComponentInstanceName}
 *
 * @package framework
 * @filesource framework/Component.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

namespace framework\components;
use framework\Controller;
use framework\Model;
use framework\View;
use framework\exceptions\NotInitializedComponent;

abstract class Component extends Controller
{

    /**
     * @var string $name Stores instance name
     */
    private $name;

    /**
     * @var bool $enableBinding Defines if user is enabled to bind component to an HTML placeholder
     * Default is true
     */
    protected $enableBinding = true;

    /**
     * Returns the name of component instance.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of component instance.
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets instance component type
     * @return string
     */
    protected function getType()
    {
        return get_class($this);
    }

    /**
     * Initializes the component with the previously given components settings.
     * You must necessary call this method after setting all needed component's proprieties.
     * @param Model|null $model
     * @param View|null $view
     * @throws NotInitializedComponent If component's instance has no name.
     */

    protected function init(Model $model = null, View $view = null)
    {
        if (empty($this->name))
            throw new NotInitializedComponent("Component " . get_class($this) . " is not initialized.", 102);

        if (!empty($model)) {
            $this->model = $model;
            $this->model->updateResultSet();
        }
        if (!empty($view))
            $this->view = $view;

    }

    /**
     * Return true  if user can bind component to an HTML placeholder
     * @return bool
     */
    public function hasBinding()
    {
        return $this->enableBinding;
    }
}