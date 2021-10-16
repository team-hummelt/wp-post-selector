<?php
/**
 * WP Gutenberg Post-Selector
 *
 *
 * @link              https://www.hummelt-werbeagentur.de/
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Post-Selector - Gutenberg Block Plugin
 * Plugin URI:        https://www.hummelt-werbeagentur.de/leistungen/
 * Description:       Auswahl von Beiträgen im Gutenberg-Block Editor mit verschiedenen Ausgabeoptionen.
 * Version:           1.0.2
 * Author:            Jens Wiecker
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP:      8.0
 * Requires at least: 5.8
 * Tested up to:      5.8
 * Stable tag:        1.0.2
 */

defined( 'ABSPATH' ) or die();
//DEFINE CONSTANT
const POST_SELECT_PLUGIN_DB_VERSION = '1.0.3';
const POST_SELECT_MIN_PHP_VERSION = '8.0';
const POST_SELECT_MIN_WP_VERSION = '5.7';

const SLIDER_IMAGE_SIZE = 'large';

//PLUGIN ROOT PATH
define('POST_SELECT_PLUGIN_DIR', dirname(__FILE__));
//PLUGIN SLUG
define('POST_SELECT_SLUG_PATH', plugin_basename(__FILE__));
//PLUGIN URL
define('POST_SELECT_PLUGIN_URL', plugins_url('wp-post-selector'));
//PLUGIN INC PATH
const POST_SELECT_PLUGIN_INC = POST_SELECT_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR;
//PLUGIN DATA PATH
const POST_SELECT_PLUGIN_DATA = POST_SELECT_PLUGIN_INC  . 'plugin-data' . DIRECTORY_SEPARATOR . 'build' . DIRECTORY_SEPARATOR;
//PLUGIN DATA URL
define('POST_SELECT_PLUGIN_DATA_URL', plugins_url('wp-post-selector').'/inc/plugin-data/build/');

/**
 * REGISTER PLUGIN
 */

require 'inc/license/license-init.php';
function activate_wp_postselector() {
    require_once plugin_dir_path( __FILE__ ) . 'inc/includes/class-wp-postselector-activator.php';
    Wp_Post_Selector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bs-formular-deactivator.php
 */
function deactivate_wp_postselector() {
    require_once plugin_dir_path( __FILE__ ) . 'inc/includes/class-wp-postselector-deactivator.php';
    Wp_Post_Selector_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_postselector' );
register_deactivation_hook( __FILE__, 'deactivate_wp_postselector' );


require POST_SELECT_PLUGIN_INC . 'admin/optionen/optionen-init.php';

if(get_option('post_selector_product_install_authorize')) {
    require 'inc/register-wp-post-select.php';
    require 'inc/update-checker/autoload.php';
    $postSelectorUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
        'https://github.com/team-hummelt/wp-post-selector/',
        __FILE__,
        'wp-post-selector'
    );
    $postSelectorUpdateChecker->getVcsApi()->enableReleaseAssets();
}

function showWPPostSelectorSitemapInfo() {
    if(get_transient('show_post_select_lizenz_info')) {
        echo '<div class="error"><p>' .
            'WP-Postselector ungültige Lizenz: Zum Aktivieren geben Sie Ihre Zugangsdaten ein.' .
            '</p></div>';
    }
}

add_action('admin_notices','showWPPostSelectorSitemapInfo');