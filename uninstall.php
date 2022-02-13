<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option("post_selector_product_install_authorize");
delete_option("post_selector_client_id");
delete_option("post_selector_client_secret");
delete_option("post_selector_message");
delete_option("post_selector_access_token");
delete_option('jal_post_selector_db_version');
delete_option('ps_user_role');
delete_transient('show_post_select_lizenz_info');

global $wpdb;
$table_name = $wpdb->prefix . 'ps_slider';
$sql = "DROP TABLE IF EXISTS $table_name";
$wpdb->query($sql);

$table_name = $wpdb->prefix . 'ps_galerie';
$sql = "DROP TABLE IF EXISTS $table_name";
$wpdb->query($sql);

$table_name = $wpdb->prefix . 'ps_galerie_images';
$sql = "DROP TABLE IF EXISTS $table_name";
$wpdb->query($sql);
