<?php
defined('ABSPATH') || exit;

/**
 * Adds a metabox to display a copyable resume shortcode in the editor.
 *
 * This class handles both the display of the shortcode UI and enqueuing
 * a JavaScript file for clipboard copy interaction.
 *
 * @since 1.0
 */
class SimpleCV_Resume_Shortcode_Box {

    /**
     * Constructor. Hooks into meta box and admin script actions.
     *
     * @since 1.0
     */
    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_shortcode_metabox']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    /**
     * Adds a sidebar meta box to the Resume post type.
     *
     * @since 1.0
     * @return void
     */
    public function add_shortcode_metabox() {
        add_meta_box(
            'simplecv_resume_shortcode_box',
            __('Resume Shortcode', SIMPLECV_TEXTDOMAIN),
            [$this, 'render_shortcode_metabox'],
            'resume',
            'side',
            'high'
        );
    }

    /**
     * Outputs the HTML for the shortcode metabox.
     *
     * Only shows if the resume is published. Includes a copy button and success message.
     *
     * @since 1.0
     * @param WP_Post $post The current post object.
     * @return void
     */
    public function render_shortcode_metabox($post) {
        if ($post->post_status !== 'publish') {
            echo '<p>' . esc_html__('This resume must be published to generate a shortcode.', SIMPLECV_TEXTDOMAIN) . '</p>';
            return;
        }

        $shortcode = sprintf('[simplecv_resume id="%d"]', $post->ID);
        ?>
        <p><?php _e('To display this resume on a page or post, copy and paste the shortcode below:', SIMPLECV_TEXTDOMAIN); ?></p>

        <div style="margin-bottom: 10px;">
            <input type="text" readonly value="<?php echo esc_attr($shortcode); ?>" id="simplecv-shortcode" style="width: 100%; font-family: monospace;">
        </div>

        <button type="button" class="button button-small" id="simplecv-copy-button">
            <?php _e('Copy Shortcode', SIMPLECV_TEXTDOMAIN); ?>
        </button>

        <span id="simplecv-copy-success" style="margin-left: 10px; display: none; color: green;">
            <?php _e('Copied!', SIMPLECV_TEXTDOMAIN); ?>
        </span>
        <p style="margin-top: 10px;">
            <a href="https://bimendra.me/wordpress/plugins/simplecv" target="_blank">
                <?php _e('View plugin documentation ↗', SIMPLECV_TEXTDOMAIN); ?>
            </a>
        </p>
        <?php
    }

    /**
     * Enqueues admin JavaScript for the copy-to-clipboard functionality.
     *
     * Only enqueued on the single post edit screen for resumes.
     *
     * @since 1.0
     * @param string $hook The current admin page hook suffix.
     * @return void
     */
    public function enqueue_admin_scripts($hook) {
        global $post;
        if ($hook === 'post.php' && $post && $post->post_type === 'resume') {
            wp_enqueue_script(
                'simplecv-shortcode-copy',
                SIMPLECV_URL . 'js/admin-shortcode-copy.js',
                [],
                SIMPLECV_VERSION,
                true
            );
        }
    }
}
