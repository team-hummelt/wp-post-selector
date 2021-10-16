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

    $table_name      = $wpdb->prefix . 'ps_galerie';
    $charset_collate = $wpdb->get_charset_collate();
    $sql             = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        bezeichnung varchar(60) NOT NULL,
        beschreibung text,
        type mediumint(6) NOT NULL,
        type_settings text NOT NULL,
        link varchar(255) NULL,
        is_link  BOOLEAN NULL,
        hover_aktiv  BOOLEAN NOT NULL DEFAULT FALSE,
        hover_title_aktiv  BOOLEAN NOT NULL DEFAULT TRUE,
        hover_beschreibung_aktiv  BOOLEAN NOT NULL DEFAULT TRUE,  
        lightbox_aktiv  BOOLEAN NOT NULL DEFAULT TRUE,
        caption_aktiv  BOOLEAN NOT NULL DEFAULT TRUE, 
        show_bezeichnung  BOOLEAN NOT NULL DEFAULT FALSE,
        show_beschreibung  BOOLEAN NOT NULL DEFAULT FALSE,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (id)
     ) $charset_collate;";
    dbDelta( $sql );

    $table_name      = $wpdb->prefix . 'ps_galerie_images';
    $charset_collate = $wpdb->get_charset_collate();
    $sql             = "CREATE TABLE $table_name ( 
        id int(11) NOT NULL AUTO_INCREMENT,
        galerie_id mediumint(11) NOT NULL,
        img_id int(11) NOT NULL,
        img_caption varchar(128) NULL,
        img_title varchar(128) NULL, 
        img_beschreibung text NULL,
        link varchar(255) NULL,
        is_link  BOOLEAN NULL,
        galerie_settings_aktiv BOOLEAN NOT NULL DEFAULT TRUE,
        hover_aktiv BOOLEAN NOT NULL DEFAULT FALSE,
        hover_title_aktiv BOOLEAN NOT NULL DEFAULT FALSE,
        hover_beschreibung_aktiv BOOLEAN NOT NULL DEFAULT FALSE,      
        lightbox_aktiv BOOLEAN NOT NULL DEFAULT FALSE,
        caption_aktiv BOOLEAN NOT NULL DEFAULT FALSE,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (id)
     ) $charset_collate;";
    dbDelta( $sql );
}

function post_selector_formular_plugin_update_dbCheck() {
	if ( get_option( 'jal_post_selector_db_version' ) != POST_SELECT_PLUGIN_DB_VERSION ) {
		update_option('jal_post_selector_db_version', POST_SELECT_PLUGIN_DB_VERSION);
        post_selector_formular_theme_jal_install();
	}
}

add_action( 'post_selector_formular_plugin_update_dbCheck', 'post_selector_formular_plugin_update_dbCheck', false );
add_action( 'post_selector_formular_plugin_create_db', 'post_selector_formular_theme_jal_install', false );