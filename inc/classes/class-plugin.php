<?php
/**
 * Main Plugin File for Project Showcase Plugin.
 *
 * @package DM_Project_Plugin
 */

namespace DM_Project_Plugin;

use DM_Project_Plugin\Traits\Singleton;

class Plugin
{
    use Singleton;

    /**
     * Constructor for the Plugin.
     *
     * @return void
     */
    public function __construct()
    {
        Post_Type_Project::get_instance();
    }

}
