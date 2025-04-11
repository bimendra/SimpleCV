<?php
defined('ABSPATH') || exit;

/**
 * Handles frontend asset loading for the SimpleCV Classic plugin.
 *
 * Enqueues styles for rendering resume posts on the frontend.
 *
 * @since 1.0
 */
class SimpleCV_Resume_Frontend {

    /**
     * Constructor. Hooks into WordPress to enqueue styles on the frontend.
     *
     * @since 1.0
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    }

    /**
     * Enqueues the plugin's resume styles only when viewing a single resume post.
     *
     * @since 1.0
     * @return void
     */
    public function enqueue_styles() {
        if (is_singular('resume')) {
            wp_enqueue_style(
                'simplecv-resume-style',
                SIMPLECV_CLASSIC_URL . 'css/resume.css',
                [],
                SIMPLECV_CLASSIC_VERSION
            );
        }
    }
}
