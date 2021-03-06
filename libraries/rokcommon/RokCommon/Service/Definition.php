<?php

/*
 * This file is part of the symfony framework.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * RokCommon_Service_Definition represents a service definition.
 *
 * @package    symfony
 * @subpackage dependency_injection
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: Definition.php 10831 2013-05-29 19:32:17Z btowles $
 */
class RokCommon_Service_Definition
{
  protected
    $class        = null,
    $file         = null,
    $constructor  = null,
    $shared       = true,
    $arguments    = array(),
    $calls        = array(),
    $configurator = null;

  /**
   * Constructor.
   *
   * @param string $class     The service class
   * @param array  $arguments An array of arguments to pass to the service constructor
   */
  public function __construct($class, array $arguments = array())
  {
    $this->class     = $class;
    $this->arguments = $arguments;
  }

  /**
   * Sets the constructor method.
   *
   * @param  string              $method The method name
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function setConstructor($method)
  {
    $this->constructor = $method;

    return $this;
  }

  /**
   * Gets the constructor method.
   *
   * @return RokCommon_Service_Definition The constructor method name
   */
  public function getConstructor()
  {
    return $this->constructor;
  }

  /**
   * Sets the service class.
   *
   * @param  string              $class The service class
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function setClass($class)
  {
    $this->class = $class;

    return $this;
  }

  /**
   * Sets the constructor method.
   *
   * @return string The service class
   */
  public function getClass()
  {
    return $this->class;
  }

  /**
   * Sets the constructor arguments to pass to the service constructor.
   *
   * @param  array               $arguments An array of arguments
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function setArguments(array $arguments)
  {
    $this->arguments = $arguments;

    return $this;
  }

  /**
   * Adds a constructor argument to pass to the service constructor.
   *
   * @param  mixed               $argument An argument
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function addArgument($argument)
  {
    $this->arguments[] = $argument;

    return $this;
  }

  /**
   * Gets the constructor arguments to pass to the service constructor.
   *
   * @return array The array of arguments
   */
  public function getArguments()
  {
    return $this->arguments;
  }

  /**
   * Sets the methods to call after service initialization.
   *
   * @param  array               $calls An array of method calls
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function setMethodCalls(array $calls = array())
  {
    $this->calls = array();
    foreach ($calls as $call)
    {
      $this->addMethodCall($call[0], $call[1]);
    }

    return $this;
  }

  /**
   * Adds a method to call after service initialization.
   *
   * @param  string              $method    The method name to call
   * @param  array               $arguments An array of arguments to pass to the method call
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function addMethodCall($method, array $arguments = array())
  {
    $this->calls[] = array($method, $arguments);

    return $this;
  }

  /**
   * Gets the methods to call after service initialization.
   *
   * @return  array An array of method calls
   */
  public function getMethodCalls()
  {
    return $this->calls;
  }

  /**
   * Sets a file to require before creating the service.
   *
   * @param  string              $file A full pathname to include
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function setFile($file)
  {
    $this->file = $file;

    return $this;
  }

  /**
   * Gets the file to require before creating the service.
   *
   * @return string The full pathname to include
   */
  public function getFile()
  {
    return $this->file;
  }

  /**
   * Sets if the service must be shared or not.
   *
   * @param  Boolean             $shared Whether the service must be shared or not
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function setShared($shared)
  {
    $this->shared = (Boolean) $shared;

    return $this;
  }

  /**
   * Returns true if the service must be shared.
   *
   * @return Boolean true if the service is shared, false otherwise
   */
  public function isShared()
  {
    return $this->shared;
  }

  /**
   * Sets a configurator to call after the service is fully initialized.
   *
   * @param  mixed               $callable A PHP callable
   *
   * @return RokCommon_Service_Definition The current instance
   */
  public function setConfigurator($callable)
  {
    $this->configurator = $callable;

    return $this;
  }

  /**
   * Gets the configurator to call after the service is fully initialized.
   *
   * @return mixed The PHP callable to call
   */
  public function getConfigurator()
  {
    return $this->configurator;
  }
}
