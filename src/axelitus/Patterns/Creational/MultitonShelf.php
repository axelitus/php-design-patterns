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
 * Class MultitonShelf
 *
 * Defines a MultitonShelf object.
 *
 * @package axelitus\Patterns\Creational
 */
abstract class MultitonShelf implements Interfaces\Forgeable
{
    /**
     * @type Factory $provider The Factory that handles the multiton instances creation.
     */
    protected $provider = null;

    /**
     * @type mixed $instances The multiton instances.
     */
    protected $instances = [];

    /**
     * Instantiates a new MultitonShelf with the given provider and arguments.
     *
     * @param Factory $provider The Factory that will handle the Multiton instances creation.
     * @param array   $args     The arguments to create the new MultitonShelf instance.
     *
     * @return MultitonShelf The newly created MultitonShelf instance.
     */
    final protected function __construct(Factory $provider, array $args)
    {
        if (is_null($provider)) {
            throw new \InvalidArgumentException("The \$provider cannot be null.");
        }

        // Initialize the shelf
        $this->init($provider, $args);

        // Set the provider after the init process to ensure we have a Factory regardless of what happened in init.
        $this->provider = $provider;
    }

    /**
     * Forges a new MultitonShelf instance.
     *
     * @param Factory $provider The Factory that handles the creation of the Multiton instances.
     *
     * @return MultitonShelf The new MultitonShelf instance.
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
     * Initializes the new MultitonShelf instance.
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
     * Grabs from the shelf the Multiton instance referenced by key.
     *
     * If no instance is on the shelf, the provider will be asked to make one.
     * (The instance is NOT removed from the shelf).
     *
     * @param string $key      The key of the Multiton instance to grab.
     * @param mixed  $args,... The arguments needed for the Factory to make the object.
     *
     * @return mixed The Multiton instance.
     */
    public function grab($key = 'default')
    {
        if (!is_string($key) and !empty($key)) {
            throw new \InvalidArgumentException("The \$key must be a non-empty string.");
        }

        if (!array_key_exists($key, $this->instances)) {
            $args = func_get_args();
            $this->instances[$key] = call_user_func_array(array($this->provider, 'make'), $args);
        }

        return $this->instances[$key];
    }

    /**
     * Removes the shelved Multiton instance referenced by key.
     *
     * @param string $key      The key of the Multiton instance to remove.
     */
    public function remove($key)
    {
        if (!is_string($key) and !empty($key)) {
            throw new \InvalidArgumentException("The \$key must be a non-empty string.");
        }

        unset($this->instances[$key]);
    }

    /**
     * Reshelves the Multiton instance referenced by key.
     *
     * Removes the existing singleton instance and asks the provider to make a new one.
     *
     * @param string $key      The key of the Multiton instance to reshelf.
     * @param mixed  $args,... The arguments needed for the Factory to make the object.
     *
     * @return mixed The singleton's instance.
     */
    public function reshelf($key = 'default')
    {
        if (!is_string($key) and !empty($key)) {
            throw new \InvalidArgumentException("The \$key must be a non-empty string.");
        }

        $class = get_called_class();
        $args = [$key] + func_get_args();

        $this->remove($key);
        return call_user_func_array([$class, 'grab'], $args);
    }
}
