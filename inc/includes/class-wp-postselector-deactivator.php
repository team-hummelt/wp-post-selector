<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://jenswiecker.de
 * @since      1.0.0
 *
 * @package    WP_POSTSELECTOR
 * @subpackage WP_Postselector/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Postselector
 * @subpackage WP_Postselector/includes
 * @author     Jens Wiecker <email@jenswiecker.de>
 */
class Wp_Post_Selector_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option("post_selector_product_install_authorize");
		delete_option("post_selector_client_id");
		delete_option("post_selector_client_secret");
        delete_option('post_selector_message');
		delete_option("post_selector_access_token");
		$infoTxt = 'deaktiviert am ' . date('d.m.Y H:i:s')."\r\n";
		file_put_contents(POST_SELECT_PLUGIN_DIR.'/wp-postselector.txt', $infoTxt,  FILE_APPEND | LOCK_EX);
	}
}
