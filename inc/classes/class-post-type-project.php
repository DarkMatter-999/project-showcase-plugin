<?php
/**
 * Main class file for the Project Post type.
 *
 * @package DM_Project_Plugin
 */

namespace DM_Project_Plugin;

use DM_Project_Plugin\Traits\Singleton;
use WP_Post;

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
        add_action('add_meta_boxes', array($this, 'project_meta_boxes'));
        add_action('save_post_' . $this::POST_TYPE_PROJECT, array($this, 'save_meta_boxes'));
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

    /**
     * Meta boxes for Project metadata
     *
     * @return void
     */
    public function project_meta_boxes()
    {
        add_meta_box(
            'dm_project_link',
            __('External Project Link', 'dm-project-plugin'),
            array($this, 'project_link_meta_box_html'),
            $this::POST_TYPE_PROJECT,
            'side'
        );
    }

    /**
     * HTML for Project link meta field.
     *
     * @param  WP_Post $post Current Post.
     * @return void
     */
    public function project_link_meta_box_html( WP_Post $post )
    {
        wp_nonce_field('dm_project_link_meta_nonce_action', 'dm_project_link_meta_nonce');

        ?>
        <div>
            <label for="dm_project_link_field"><?php esc_html_e('External Link to Project repo', 'dm-project-plugin'); ?></label>
            <input type="text" name="dm_project_link" id="dm_project_link_field" value="<?php echo esc_url(get_post_meta($post->ID, $this::PROJECT_LINK_META, true)); ?>">
        </div>
        <?php
    }

    /**
     * Save all metaboxes for project CPT.
     *
     * @param  int $post Curren Post.
     * @return void
     */
    public function save_meta_boxes(int $post)
    {
        if (isset($_POST['dm_project_link_meta_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['dm_project_link_meta_nonce']), 'dm_project_link_meta_nonce_action')) {
            $link = sanitize_url($_POST['dm_project_link']);
            if($link) {
                update_post_meta($post, $this::PROJECT_LINK_META, $link);
            } else {
                update_post_meta($post, $this::PROJECT_LINK_META, '');
            }
        }
    }

}
