<?php
/**
 * Block Class file for Project Plugin.
 *
 * @package DM_Project_Plugin
 */

namespace DM_Project_Plugin;

use DM_Project_Plugin\Traits\Singleton;

class Blocks
{
    use Singleton;

    public function __construct()
    {
        add_action('init', array($this, 'register'));
    }

    public function register()
    {
        register_block_type(DMPP_PLUGIN_PATH . 'assets/build/blocks/project-block');
    }
}
