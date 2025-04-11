<?php
defined('ABSPATH') || exit;

/**
 * Adds custom plugin meta links on the Plugins screen.
 *
 * @since 1.0
 */
class SimpleCV_Plugin_Meta {

    /**
     * Constructor. Hooks the plugin row meta filter.
     *
     * @since 1.0
     */
    public function __construct() {
        add_filter('plugin_row_meta', [$this, 'add_plugin_meta_links'], 10, 2);
    }

    /**
     * Adds a "Documentation" link under the plugin name on the Plugins screen.
     *
     * @param array  $links Existing plugin meta links.
     * @param string $file  Plugin file path.
     * @return array Modified links.
     *
     * @since 1.0
     */
    public function add_plugin_meta_links($links, $file) {
        if (plugin_basename(SIMPLECV_PATH . 'simplecv.php') === $file) {
            $links[] = '<a href="https://bimendra.me/wordpress/plugins/simplecv" target="_blank">' .
                        esc_html__('Documentation', SIMPLECV_TEXTDOMAIN) . '</a>';
        }
        return $links;
    }
}
