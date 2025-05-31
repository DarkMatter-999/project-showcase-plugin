<?php
/**
 * Singleton Trait
 *
 * @package DM_Project_Plugin
 **/

namespace DM_Project_Plugin\Traits;

trait Singleton
{
    /**
     * Instance of the object.
     */
    private static $instance = null;

    /**
     * Returns the instance of the object.
     *
     * @return self
     */
    public static function get_instance() : self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constuctor for singleton trait.
     */
    private function __construct()
    {
    }

    /**
     * __clone() method.
     */
    public function __clone()
    {
    }

    /**
     * __wakeup() method.
     */
    public function __wakeup()
    {
    }


}
