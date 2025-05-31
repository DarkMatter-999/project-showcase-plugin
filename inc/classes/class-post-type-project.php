<?php
/**
 * Main class file for the Project Post type.
 *
 * @package DM_Project_Plugin
 */

namespace DM_Project_Plugin;

use DM_Project_Plugin\Traits\Singleton;

class Post_Type_Project
{
    use Singleton;

    const POST_TYPE_PROJECT = 'dm_project';
    const PROJECT_LINK_META = 'dm_project_link';

    /**
     * Constructor for the Project CPT.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', array($this, 'register'));
        add_action('init', array($this, 'register_meta'));
    }

    /**
     * Register Project post type.
     *
     * @return void
     */
    public function register()
    {
        register_post_type(
            self::POST_TYPE_PROJECT,
            array(
            'labels'      => array(
                'name'          => __('Projects', 'dm-project-plugin'),
                'singular_name' => __('Project', 'dm-project-plugin'),
            ),
            'public'      => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'revisions', 'author', 'excerpt', 'thumbnail', 'custom-fields'),
            )
        );
    }

    /**
     * Register the Project link meta.
     *
     * @return void
     */
    public function register_meta()
    {
        register_post_meta(
            self::POST_TYPE_PROJECT,
            self::PROJECT_LINK_META,
            array(
                'type'              => 'string',
                'label'             => __('Project Link', 'dm-project-plugin'),
                'description'       => __('Link of the project repository', 'dm-project-plugin'),
                'single'            => true,
                'sanitize_callback' => 'sanitize_url',
                'show_in_rest'      => true,
            )
        );
    }
}
