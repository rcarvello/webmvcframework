<?php
/**
 * Class Component
 *
 * The MVC Component class is an abstraction for a set of specialized components.
 * A component is an entity that implements some common and generalized behaviours
 * recurring during web application development. Sometimes these behaviours are well
 * known as "aspects".
 * For example, some of this behavior are: record pagination, table sorting and so on.
 * Components may also have (or not) a GUI interface defined into an HTML template
 * managed by a View object. User can bind the component's GUI to a special placeholder
 * of the template. This placeholder has the following format:
 *        {ComponentType:ComponentInstanceName}.
 * By default many components are provided with a predefined GUI HTML template. User
 * can replace a default template with a custom implementation of it and use it's own
 * graphic design.  By replacing a default HTML template of a component with a custom
 * one, user must only take care to reproduce all BLOCKS and PLACEHOLDERS designed into
 * the default one.
 *
 * @package framework
 * @filesource framework/Component.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.0.0
 * @note none
 * @copyright (c) 2016 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD Public License.
 */
namespace framework;

abstract class Component extends Controller{

    /**
     * Stores istance name
     * @var string
     */
    private $name;

    /**
     * Defines if user is enabled to bind component to an HTML placeholder
     * @var bool Default is true
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
     * Inizialize the component.
     * User must call this method after settings component's proprieties.
     *
     * @throws NotInitializedComponent If component's instance has no name.
     */
    protected function init()
    {
      if (empty($this->name))
          throw new NotInitializedComponent("Nome " . get_class($this) . " non inizializzato",102);
    }

    /**
     * Reuturn true  if user can bind component to an HTML placeholder
     * @return bool
     */
    public function hasBinding()
    {
        return $this->enableBinding;
    }
}