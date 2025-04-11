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
     * Constructor. Registers the shortcode.
     *
     * @since 1.0
     */
    public function __construct() {
        add_shortcode('simplecv_resume', [$this, 'render_shortcode']);
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
            return '<p>' . esc_html__('Invalid resume ID.', SIMPLECV_CLASSIC_TEXTDOMAIN) . '</p>';
        }

        ob_start();

        $template_path = SIMPLECV_CLASSIC_PATH . 'templates/resume-output.php';

        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo '<p>' . esc_html__('Resume template not found.', SIMPLECV_CLASSIC_TEXTDOMAIN) . '</p>';
        }

        return ob_get_clean();
    }
}
