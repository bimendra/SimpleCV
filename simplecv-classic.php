<?php
/**
 * Plugin Name: SimpleCV Classic
 * Plugin URI: https://bimendra.me/wordpress/plugins/simplecv
 * Description: Allows non-technical professionals to create an effective resume for their personal website. Requires the CMB2 plugin.
 * Version: 1.0
 * Author: Bimen B.
 * Author URI: https://bimendra.me
 * Text Domain: simplecv
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

define('SIMPLECV_CLASSIC_VERSION', '1.0');
define('SIMPLECV_CLASSIC_PATH', plugin_dir_path(__FILE__));
define('SIMPLECV_CLASSIC_URL', plugin_dir_url(__FILE__));
define('SIMPLECV_CLASSIC_TEXTDOMAIN', 'simplecv');
define('SIMPLECV_REQUIRED_CMB2_VERSION', '2.10.1');

/**
 * Check if CMB2 is unavailable (missing or outdated).
 *
 * @return bool
 */
function simplecv_is_cmb2_unavailable() {
    return (
        !defined('CMB2_LOADED') ||
        !defined('CMB2_VERSION') ||
        version_compare(CMB2_VERSION, SIMPLECV_REQUIRED_CMB2_VERSION, '<')
    );
}

/**
 * Activation hook: check if CMB2 is missing and schedule a redirect.
 */
function simplecv_check_cmb2_on_activation() {
    if (simplecv_is_cmb2_unavailable()) {
        set_transient('_simplecv_cmb2_missing', true, 30);
    }
}
register_activation_hook(__FILE__, 'simplecv_check_cmb2_on_activation');

/**
 * Admin init: redirect after activation if CMB2 is missing,
 * and apply unmet dependency flag.
 */
add_action('admin_init', function () {
    if (get_transient('_simplecv_cmb2_missing')) {
        delete_transient('_simplecv_cmb2_missing');
        wp_redirect(admin_url('plugins.php?simplecv_cmb2_missing=1'));
        exit;
    }

    if (simplecv_is_cmb2_unavailable()) {
        add_filter('simplecv_cmb2_unmet', '__return_true');
    }
});

/**
 * Display admin notice if CMB2 is missing or inactive.
 */
add_action('admin_notices', function () {
    if (
        isset($_GET['simplecv_cmb2_missing']) ||
        apply_filters('simplecv_cmb2_unmet', false)
    ) {
        $plugin_file = 'cmb2/cmb2.php';
        $plugin_installed = file_exists(WP_PLUGIN_DIR . '/' . $plugin_file);
        $plugin_inactive = $plugin_installed && is_plugin_inactive($plugin_file);

        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>' . esc_html__('SimpleCV Classic requires the CMB2 plugin.', 'simplecv') . '</strong></p>';

        if ($plugin_inactive) {
            echo '<p>' . esc_html__('The CMB2 plugin is installed but not activated. Please activate it to use SimpleCV Classic.', 'simplecv') . '</p>';
        } else {
            echo '<p>' . esc_html__('To use this plugin, you need the CMB2 plugin (version 2.10.1 or newer).', 'simplecv') . '</p>';
        }

        if ($plugin_inactive && current_user_can('activate_plugins')) {
            $activate_url = wp_nonce_url(
                admin_url('plugins.php?action=activate&plugin=' . urlencode($plugin_file)),
                'activate-plugin_' . $plugin_file
            );
            echo '<p><a href="' . esc_url($activate_url) . '" class="button button-primary">' . esc_html__('Activate CMB2', 'simplecv') . '</a></p>';
        } elseif (!$plugin_installed) {
            echo '<p><a href="https://wordpress.org/plugins/cmb2/" target="_blank" class="button button-primary">' . esc_html__('Download CMB2', 'simplecv') . '</a></p>';
        }

        echo '</div>';
    }
});

/**
 * Load plugin features if CMB2 is available.
 */
if (!apply_filters('simplecv_cmb2_unmet', false)) {
    require_once SIMPLECV_CLASSIC_PATH . 'includes/class-simplecv-resume-cpt.php';
    require_once SIMPLECV_CLASSIC_PATH . 'includes/class-simplecv-resume-metabox.php';
    require_once SIMPLECV_CLASSIC_PATH . 'includes/class-simplecv-resume-frontend.php';
    require_once SIMPLECV_CLASSIC_PATH . 'includes/class-simplecv-resume-shortcode.php';
    require_once SIMPLECV_CLASSIC_PATH . 'includes/class-simplecv-resume-shortcode-box.php';

    new SimpleCV_Resume_CPT();
    new SimpleCV_Resume_Metabox();
    new SimpleCV_Resume_Frontend();
    new SimpleCV_Resume_Shortcode();
    new SimpleCV_Resume_Shortcode_Box();
}
