<?php
defined('ABSPATH') || exit;

/**
 * Registers the "resume" custom post type used by the SimpleCV Classic plugin.
 *
 * @since 1.0
 */
class SimpleCV_Resume_CPT {

    /**
     * Hooks into the WordPress 'init' action to register the CPT.
     *
     * @since 1.0
     */
    public function __construct() {
        add_action('init', [$this, 'register_resume_cpt']);
    }

    /**
     * Registers the 'resume' custom post type.
     *
     * This CPT is used to store and manage resume content created via CMB2 metaboxes.
     *
     * @since 1.0
     * @return void
     */
    public function register_resume_cpt() {
        $labels = [
            'name'                  => __('Resumes', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'singular_name'         => __('Resume', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'add_new'               => __('Add New', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'add_new_item'          => __('Add New Resume', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'edit_item'             => __('Edit Resume', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'new_item'              => __('New Resume', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'view_item'             => __('View Resume', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'search_items'          => __('Search Resumes', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'not_found'             => __('No resumes found', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'not_found_in_trash'    => __('No resumes found in trash', SIMPLECV_CLASSIC_TEXTDOMAIN),
            'menu_name'             => __('Resumes', SIMPLECV_CLASSIC_TEXTDOMAIN),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'has_archive'        => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'supports'           => ['title'],
            'menu_icon'          => 'dashicons-id-alt',
            'show_in_rest'       => false,
        ];

        register_post_type('resume', $args);
    }
}
