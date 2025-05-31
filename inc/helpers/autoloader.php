<?php
/**
 * Autoloader
 *
 * This file provides the autoloader for the Project Showcase Plugin.
 *
 * @package DM_Proejct_Plugin
 **/
namespace DM_Project_Plugin\Helpers;

spl_autoload_register(
    function ( $what ) {
        $split = explode('\\', $what);
        if ('DM_Project_Plugin' !== $split[0]) {
            return;
        }
        $base_dir = 'inc/';

        if (isset($split[1]) && ('Traits' === $split[1])) {
            $base_dir .= 'traits/trait-';
            $split[1] = '';
        } else {
            $base_dir .= 'classes/class-';
        }

        $split[ count($split) - 1] = str_replace('_', '-', strtolower($split[count($split) - 1]) . '.php');

        $split[0] = $base_dir;

        $file_path = implode('', $split);

        if (file_exists(DMPP_PLUGIN_PATH . $file_path)) {
            include_once DMPP_PLUGIN_PATH . $file_path;
        }
    }
);
