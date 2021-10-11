<?php


defined( 'ABSPATH' ) or die();

function post_selector_formular_theme_jal_install() {
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	global $wpdb;

	$table_name      = $wpdb->prefix . 'ps_slider';
	$charset_collate = $wpdb->get_charset_collate();
	$sql             = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        slider_id varchar(14) NOT NULL UNIQUE,
        bezeichnung varchar(128) NOT NULL,
        data text NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (id)
     ) $charset_collate;";
	dbDelta( $sql );

}

function post_selector_formular_plugin_update_dbCheck() {
	if ( get_option( 'jal_post_selector_db_version' ) != POST_SELECT_PLUGIN_DB_VERSION ) {
		post_selector_formular_theme_jal_install();
	}
}

add_action( 'post_selector_formular_plugin_update_dbCheck', 'post_selector_formular_plugin_update_dbCheck', false );
add_action( 'post_selector_formular_plugin_create_db', 'post_selector_formular_theme_jal_install', false );