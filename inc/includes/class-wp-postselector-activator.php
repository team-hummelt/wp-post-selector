<?php

/**
 * Fired during plugin activation
 *
 * @link       https://jenswiecker.de
 * @since      1.0.0
 *
 * @package    WP_POSTSELECTOR
 * @subpackage WP_Postselector/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Postselector
 * @subpackage WP_Postselector/includes
 * @author     Jens Wiecker <email@jenswiecker.de>
 */
class Wp_Post_Selector_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$register = POST_SELECT_PLUGIN_INC . 'register-wp-post-select.php';
        if(!get_option('post_selector_product_install_authorize')){
            unlink($register);
        }
        if(!get_option('ps_user_role')){
            update_option('ps_user_role', 'manage_options');
        }
		delete_option("post_selector_product_install_authorize");
		delete_option("post_selector_client_id");
		delete_option("post_selector_client_secret");
		delete_option("post_selector_access_token");
		$infoTxt = 'aktiviert am ' . date('d.m.Y H:i:s')."\r\n";
		file_put_contents(POST_SELECT_PLUGIN_DIR.'/wp-postselector.txt',$infoTxt,  FILE_APPEND | LOCK_EX);
		set_transient('show_post_select_lizenz_info', true, 5);
	}
}


