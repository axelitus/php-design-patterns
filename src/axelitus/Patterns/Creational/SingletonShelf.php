<?php
/**
 * Part of composer package: axelitus/patterns
 *
 * @package     axelitus\Patterns
 * @version     0.2
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/axelitus/patterns
 */

namespace axelitus\Patterns\Creational;

use axelitus\Patterns\Interfaces;

/**
 * Class SingletonShelf
 *
 * Defines a SingletonShelf object.
 *
 * @package axelitus\Patterns\Creational
 */
abstract class SingletonShelf implements Interfaces\Forgeable
{
    /**
     * @type Factory $provider The Factory that handles the Singleton instance creation.
     */
    protected $provider = null;

    /**
     * @type mixed $instance The Singleton instance.
     */
    protected $instance = null;

    /**
     * Instantiates a new SingletonShelf with the given provider and arguments.
     *
     * @param Factory $provider The Factory that will handle the Singleton instance creation.
     * @param array   $args     The arguments to create the new SingletonShelf instance.
     *
     * @return SingletonShelf The newly created SingletonShelf instance.
     */
    final protected function __construct(Factory $provider, array $args)
    {
        if (is_null($provider)) {
            throw new \InvalidArgumentException("The \$provider cannot be null.");
        }

        // Initialize the shelf.
        $this->init($provider, $args);

        // Set the provider after the init process to ensure we have a Factory regardless of what happened in init.
        $this->provider = $provider;
    }

    /**
     * Forges a new SingletonShelf instance.
     *
     * @param Factory $provider The Factory that handles the creation of the Singleton instance.
     *
     * @return SingletonShelf The new SingletonShelf instance.
     */
    public static function forge()
    {
        $provider = func_get_arg(0);
        if (!($provider instanceof Factory)) {
            throw new \InvalidArgumentException("The first argument must be of type axelitus\\Patterns\\Factory.");
        }

        $args = array_slice(func_get_args(), 1);
        return new static($provider, $args);
    }

    /**
     * Initializes the new SingletonShelf instance.
     *
     * This function should be overriden in the derivable classes for specific initialization logic.
     *
     * @param mixed $args,... The arguments to initialize the object (taken from the arguments of the forge() call).
     */
    protected function init()
    {
        // we do nothing in the base abstract class.
    }

    /**
     * Grabs the Singleton instance from the shelf.
     *
     * If no instance is on the shelf, the provider will be asked to make one.
     * (The instance is NOT removed from the shelf).
     *
     * @param mixed $args,... The arguments needed for the Factory to make the object.
     *
     * @return mixed The Singleton instance.
     */
    public function grab()
    {
        if (is_null($this->instance)) {
            $args = func_get_args();
            $this->instance = call_user_func_array(array($this->provider, 'make'), $args);
        }

        return $this->instance;
    }

    /**
     * Removes the shelved Singleton instance.
     */
    public function remove()
    {
        $this->instance = null;
    }

    /**
     * Reshelves the Singleton's instance.
     *
     * Removes the existing Singleton instance and asks the provider to make a new one.
     *
     * @param mixed $args,... The arguments needed for the Factory to make the object.
     *
     * @return mixed The Singleton instance.
     */
    public function reshelf()
    {
        $class = get_called_class();
        $args = func_get_args();

        $this->remove();
        return call_user_func_array([$class, 'grab'], $args);
    }
}
