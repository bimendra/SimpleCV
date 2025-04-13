<?php
defined('ABSPATH') || exit;

/**
 * Registers and handles the [simplecv_resume] shortcode.
 *
 * Renders a resume from the 'resume' post type using a template file.
 *
 * @since 1.0
 */
class SimpleCV_Resume_Shortcode {
    /**
     * The resume ID currently being rendered.
     *
     * @var int|null
     */
    private $rendered_resume_id = null;

    /**
     * Constructor. Registers the shortcode.
     *
     * @since 1.0
     */
    public function __construct() {
        add_shortcode('simplecv_resume', [$this, 'render_shortcode']);
        add_action('admin_bar_menu', [$this, 'add_admin_bar_link'], 100);
    }

    /**
     * Shortcode callback for [simplecv_resume].
     *
     * Renders the resume content using the resume-output.php template.
     * If no valid resume ID is provided, displays an error message.
     *
     * @since 1.0
     *
     * @param array $atts Shortcode attributes. Accepts 'id' (resume post ID).
     * @return string Rendered resume HTML or error message.
     */
    public function render_shortcode($atts) {
        $atts = shortcode_atts([
            'id' => get_the_ID(),
        ], $atts, 'simplecv_resume');

        $resume_id = intval($atts['id']);

        if (get_post_type($resume_id) !== 'resume') {
            return '<p>' . esc_html__('Invalid resume ID.', SIMPLECV_TEXTDOMAIN) . '</p>';
        }

        $this->rendered_resume_id = $resume_id;

        ob_start();

        $template_path = SIMPLECV_PATH . 'templates/resume-output.php';

        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo '<p>' . esc_html__('Resume template not found.', SIMPLECV_TEXTDOMAIN) . '</p>';
        }

        return ob_get_clean();
    }

    /**
     * Adds an "Edit Resume" link to the admin bar if a resume was rendered via shortcode.
     *
     * @since 1.0
     * @param WP_Admin_Bar $admin_bar The WordPress admin bar object.
     */
    public function add_admin_bar_link($admin_bar) {
        if (
            is_admin() ||
            !is_user_logged_in() ||
            !current_user_can('edit_posts') ||
            !$this->rendered_resume_id
        ) {
            return;
        }

        $resume_id = $this->rendered_resume_id;

        $admin_bar->add_node([
            'id'    => 'simplecv-edit-resume',
            'title' => __('Edit Resume', SIMPLECV_TEXTDOMAIN),
            'href'  => admin_url('post.php?post=' . $resume_id . '&action=edit'),
            'meta'  => [
                'title' => __('Edit this resume post', SIMPLECV_TEXTDOMAIN),
                'class' => 'simplecv-edit-resume-link',
            ],
        ]);
    }
}
