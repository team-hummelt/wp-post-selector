<?php

namespace Block\PostSelector;

defined( 'ABSPATH' ) or die();

/**
 * Gutenberg POST SELECTOR
 * @package Hummelt & Partner Gutenberg Block Plugin
 * Copyright 2021, Jens Wiecker
 * https://www.hummelt-werbeagentur.de/
 */
final class RegisterGutenbergPostSelector {
	private static $post_selector_instance;
	private bool $ps_dependencies;

	/**
	 * @return static
	 */
	public static function post_selector_instance(): self {
		if ( is_null( self::$post_selector_instance ) ) {
			self::$post_selector_instance = new self();
		}

		return self::$post_selector_instance;
	}

	public function __construct() {
		$this->ps_dependencies = $this->check_post_selector_dependencies();
		add_action( 'admin_notices', array( $this, 'showPostSelectLizenzInfo' ) );
	}

	function showPostSelectLizenzInfo() {
		if ( get_transient( 'show_post_select_lizenz_info' ) ) {
			echo '<div class="error"><p>' .
			     'WP-Postselector ungültige Lizenz: Zum Aktivieren geben Sie Ihre Zugangsdaten ein.' .
			     '</p></div>';
		}
	}

	/**
	 * ============================================
	 * =========== REGISTER POST-SELECT ===========
	 * ============================================
	 */
	public function init_post_selector(): void {
		if ( ! $this->ps_dependencies ) {
			return;
		}
		add_action( 'init', array( $this, 'gutenberg_block_post_select_register' ) );
        add_action( 'init', array( $this, 'gutenberg_block_post_selector_galerie_register' ) );

        // TODO Create Database
		add_action( 'init', array( $this, 'post_selector_create_db' ) );
		//TODO REMOVE REST BY NOT LOGGED IN
		add_action( 'init', array( $this, 'post_select_removes_api_endpoints_for_not_logged_in' ) );
		add_action( 'init', array( $this, 'load_post_selector_textdomain' ) );

		add_action( 'enqueue_block_editor_assets', array( $this, 'post_select_plugin_editor_block_scripts' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'post_select_plugin_editor_galerie_scripts' ) );

		add_action( 'enqueue_block_assets', array( $this, 'post_select_plugin_public_scripts' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'post_select_script_text_domain' ), 100 );
		//add_action( 'init', array( $this, 'post_select_set_script_translations' ) );
		add_action( 'init', array( $this, 'post_select_script_text_domain' ) );
		//TODO REGISTER ADMIN PAGE
		add_action( 'admin_menu', array( $this, 'register_post_selector_menu' ) );

		//TODO AJAX ADMIN AND PUBLIC
		add_action( 'wp_ajax_PostSelHandle', array( $this, 'prefix_ajax_PostSelHandle' ) );
		add_action( 'wp_ajax_nopriv_PostSelHandlePublic', array( $this, 'prefix_ajax_PostSelHandlePublic' ) );
		add_action( 'wp_ajax_PostSelHandlePublic', array( $this, 'prefix_ajax_PostSelHandlePublic' ) );

	}

	public function load_post_selector_textdomain(): void {
		load_plugin_textdomain( 'wp-post-selector', false, dirname( POST_SELECT_SLUG_PATH ) . '/language/' );
	}

	public function register_post_selector_menu() {
		$hook_suffix = add_menu_page(
			__( 'Post-Selector', 'wp-post-selector' ),
			__( 'Post-Selector', 'wp-post-selector' ),
			'manage_options',
			'post-selector-settings',
			array( $this, 'admin_postselector_settings_page' ),
			'dashicons-slides', 7
		);

		add_action( 'load-' . $hook_suffix, array( $this, 'post_selector_load_ajax_admin_options_script' ) );
	}

	/**
	 * ==================================================
	 * =========== REGISTER GUTENBERG wp.i18n ===========
	 * ==================================================
	 */
	public function post_select_script_text_domain() {
		wp_set_script_translations( 'wp-post-selector', 'wp-post-selector', plugin_dir_path( __DIR__ ) . 'languages' );
	}

	public function post_select_set_script_translations() {
		wp_set_script_translations( 'wp-post-selector-script', 'wp-post-selector' );
	}

	/**
	 * ===================================
	 * =========== ADMIN PAGES ===========
	 * ===================================
	 */
	public function admin_postselector_settings_page() {
        wp_enqueue_media();
		require 'admin/admin-pages/ps-settings.php';
	}

	public function post_selector_load_ajax_admin_options_script() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_post_selector_admin_style' ) );
		$title_nonce = wp_create_nonce( 'post_selector_admin_handle' );

		wp_register_script( 'post-selector-admin-ajax-script', '', [], '', true );
		wp_enqueue_script( 'post-selector-admin-ajax-script' );
		wp_localize_script( 'post-selector-admin-ajax-script', 'ps_ajax_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $title_nonce,
            'data_table'      => POST_SELECT_PLUGIN_URL . '/inc/assets/json/DataTablesGerman.json'
		));
	}

	/**
	 * ============================================
	 * =========== AJAX RESPONSE HANDLE ===========
	 * ============================================
	 */
	public function prefix_ajax_PostSelHandle(): void {
		$responseJson = null;
		check_ajax_referer( 'post_selector_admin_handle' );
		require 'admin/ajax/post-selector-admin-ajax.php';
		wp_send_json( $responseJson );

	}

	/**
	 * ===================================================
	 * =========== AJAX PUBLIC RESPONSE HANDLE ===========
	 * ===================================================
	 */
	public function prefix_ajax_PostSelHandlePublic(): void {
		$responseJson = null;
		check_ajax_referer( 'post_selector_public_handle' );
		require 'admin/ajax/post-selector-public.php';
		wp_send_json( $responseJson );
	}


	/**
	 * =============================================================
	 * =========== REGISTER GUTENBERG POST-SELECT PLUGIN ===========
	 * =============================================================
	 */
	public function gutenberg_block_post_select_register() {
		register_block_type( 'hupa/theme-post-selector', array(
			'render_callback' => 'callback_post_selector_block',
			'editor_script'   => 'gutenberg-post-selector-block',
		) );

		add_filter( 'gutenberg_block_post_selector_render', 'gutenberg_block_post_selector_render_filter', 10, 20 );
	}

    /**
     * ================================================================
     * =========== REGISTER GUTENBERG POST-SELECTOR GALERIE ===========
     * ================================================================
     */
    public function gutenberg_block_post_selector_galerie_register() {
        register_block_type( 'hupa/post-selector-galerie', array(
            'render_callback' => 'callback_post_selector_galerie',
            'editor_script'   => 'gutenberg-post-selector-galerie',
        ) );

        add_filter( 'gutenberg_block_post_selector_galerie_render', 'gutenberg_block_post_selector_galerie_render_filter', 10, 20 );
    }

	public function post_selector_create_db() {
		require 'admin/optionen/database/post-selector-database.php';
		do_action( 'post_selector_formular_plugin_update_dbCheck', false );
	}

	/*======================================
	TODO VERSIONS CHECK
	========================================
	*/
	public function check_post_selector_dependencies(): bool {
		global $wp_version;
		if ( version_compare( PHP_VERSION, POST_SELECT_MIN_PHP_VERSION, '<' ) || $wp_version < POST_SELECT_MIN_WP_VERSION ) {
			$this->maybe_self_deactivate();
			return false;
		}
		return true;
	}

	/*=======================================
	TODO SELF-DEACTIVATE
	=========================================
	 */
	public function maybe_self_deactivate(): void {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		deactivate_plugins( POST_SELECT_SLUG_PATH );
		add_action( 'admin_notices', array( $this, 'self_deactivate_notice' ) );
	}

	/*==============================================
	TODO DEACTIVATE-ADMIN-NOTIZ
	================================================
	 */
	#[NoReturn] public function self_deactivate_notice() {
		echo sprintf( '<div class="error" style="margin-top:5rem"><p>' . __( 'This plugin has been disabled because it requires a PHP version greater than %s and a WordPress version greater than %s. Your PHP version can be updated by your hosting provider.', 'lva-buchungssystem' ) . '</p></div>', POST_SELECT_MIN_PHP_VERSION, POST_SELECT_MIN_WP_VERSION );
		exit();
	}

	/**
	 * =======================================================================
	 * =========== REGISTER GUTENBERG POST-SELECT JAVASCRIPT | CSS ===========
	 * =======================================================================
	 */
	public function post_select_plugin_editor_block_scripts(): void {
		$wp_ps_data   = get_file_data( POST_SELECT_PLUGIN_DIR . '/wp-post-selector.php', array( 'Version' => 'Version' ), false );
		$plugin_asset = require POST_SELECT_PLUGIN_DATA . 'index.asset.php';

		global $wpPs_V;
		$wpPs_V = $wp_ps_data['Version'];

		// Scripts.
		wp_enqueue_script(
			'gutenberg-post-selector-block',
			POST_SELECT_PLUGIN_DATA_URL . 'index.js',
			$plugin_asset['dependencies'], $plugin_asset['version']
		);

		// Styles.
		wp_enqueue_style(
			'gutenberg-post-selector-block', // Handle.
			POST_SELECT_PLUGIN_DATA_URL . 'index.css', array(), $wpPs_V
		);

		wp_register_script( 'post-select-rest-gutenberg-js-localize', '', [], $wpPs_V, true );
		wp_enqueue_script( 'post-select-rest-gutenberg-js-localize' );
		wp_localize_script( 'post-select-rest-gutenberg-js-localize',
			'WPPSRestObj',
			array(
				'url'   => esc_url_raw( rest_url( 'post-select-endpoint/v1/method/' ) ),
				'nonce' => wp_create_nonce( 'wp_rest' )
			)
		);
	}


    /**
     * =================================================================================
     * =========== REGISTER GUTENBERG POST-SELECTOR GALERIE JAVASCRIPT | CSS ===========
     * =================================================================================
     */
    public function post_select_plugin_editor_galerie_scripts(): void {
        $wp_ps_data   = get_file_data( POST_SELECT_PLUGIN_DIR . '/wp-post-selector.php', array( 'Version' => 'Version' ), false );
        $plugin_asset = require POST_SELECT_PLUGIN_GALERIE_DATA . 'index.asset.php';

        global $wpPs_V;
        $wpPs_V = $wp_ps_data['Version'];

        // Scripts.
        wp_enqueue_script(
            'gutenberg-post-selector-galerie',
            POST_SELECT_PLUGIN_GALERIE_DATA_URL . 'index.js',
            $plugin_asset['dependencies'], $plugin_asset['version']
        );

        // Styles.
        wp_enqueue_style(
            'gutenberg-post-selector-galerie', // Handle.
            POST_SELECT_PLUGIN_GALERIE_DATA_URL . 'index.css', array(), $wpPs_V
        );
    }

	public function post_select_plugin_public_scripts() {
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DATA . '/ps-style.css' ) );

		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/css/tools/splide-default.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/css/tools/splide-skyblue.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/css/tools/splide-sea-green.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/css/tools/splide.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/splide.min.js' ) );
		//$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/splide-extension-grid.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/css/bs/bootstrap.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/bs/bootstrap.bundle.min.js' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/css/tools/lightbox/blueimp-gallery.min.css' ) );
		$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/lightbox/blueimp-gallery.min.js' ) );
		//$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/jquery.blueimp-gallery.js' ) );

        $modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/imagesloaded.pkgd.min.js' ) );
        $modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/masonry.pkgd.min.js' ) );
        $modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/wowjs/wow.min.js' ) );


		//$modificated = date( 'YmdHi', filemtime( POST_SELECT_PLUGIN_DIR . '/inc/assets/js/tools/post-selector-splide.js' ) );

		// Styles.
		wp_enqueue_style(
			'post-selector-public-style',
			POST_SELECT_PLUGIN_DATA_URL . 'ps-style.css',
			array(), '' );

		//if nicht Install Starter Theme
		$ifHupaStarter = wp_get_theme( 'hupa-starter' );
		if ( ! $ifHupaStarter->exists() ) {
			// TODO Bootstrap CSS
			wp_enqueue_style(
				'post-selector-bootstrap',
				POST_SELECT_PLUGIN_URL . '/inc/assets/css/bs/bootstrap.min.css',
				array(), $modificated );

			// TODO Bootstrap JS
            wp_enqueue_script( 'gutenberg-post-selector-bs',
                POST_SELECT_PLUGIN_URL . '/inc/assets/js/bs/bootstrap.bundle.min.js', array(),
                $modificated, true );
            // TODO MASONRY
            wp_enqueue_script( 'gutenberg-post-selector-masonry-pkgd',
                POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/masonry.pkgd.min.js', array(),
                $modificated, true );
		}

		// TODO SPLIDE CSS
		wp_enqueue_style(
			'post-selector-splide-css',
			POST_SELECT_PLUGIN_URL . '/inc/assets/css/tools/splide.min.css',
			array(), $modificated );

		// TODO SPLIDE SEA GREEN CSS
		/*wp_enqueue_style(
			'post-selector-splide-css',
			POST_SELECT_PLUGIN_URL . '/inc/assets/css/tools/splide-sea-green.min.css',
			array(), $modificated );*/

		// TODO SPLIDE SEA BLUE CSS
		/*wp_enqueue_style(
			'post-selector-splide-css',
			POST_SELECT_PLUGIN_URL . '/inc/assets/css/tools/splide-skyblue.min.css',
			array(), $modificated );
		*/
		// TODO SPLIDE DEFAULT CSS
		/*wp_enqueue_style(
			'post-selector-splide-css',
			POST_SELECT_PLUGIN_URL . '/inc/assets/css/tools/splide-default.min.css',
			array(), $modificated );*/


		// TODO LIGHTBOX CSS
		wp_enqueue_style(
			'post-selector-lightbox-css',
			POST_SELECT_PLUGIN_URL . '/inc/assets/css/tools/lightbox/blueimp-gallery.min.css',
			array(), $modificated );

		//TODO LIGHTBOX
		wp_enqueue_script( 'gutenberg-post-selector-lightbox',
			POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/lightbox/blueimp-gallery.min.js', array(),
			$modificated, true );

		//TODO LIGHTBOX
	/*	wp_enqueue_script( 'gutenberg-post-selector-jq-lightbox',
			POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/jquery.blueimp-gallery.js', array(),
			$modificated, true );
*/
		//TODO SLIDER
		wp_enqueue_script( 'gutenberg-post-selector-splide',
			POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/splide.min.js', array(),
			$modificated, true );

		//TODO SLIDER GRID EXTENSION
		/*wp_enqueue_script( 'gutenberg-post-selector-splide-grid',
			POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/splide-extension-grid.min.js', array(),
			$modificated, true );*/

        //TODO IMAGES LOADED
        wp_enqueue_script( 'post-selector-galerie-images-loaded',
            POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/imagesloaded.pkgd.min.js', array(),
            $modificated, true );

		//TODO SLIDER  OPTIONEN
		wp_enqueue_script( 'gutenberg-post-selector-splide-optionen',
			POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/post-selector-splide.js', array(),
			$modificated, true );

        wp_enqueue_script( 'gutenberg-post-selector-wowjs',
            POST_SELECT_PLUGIN_URL . '/inc/assets/js/tools/wowjs/wow.min.js', array(),
            $modificated, true );

		$public_nonce = wp_create_nonce( 'post_selector_public_handle' );
		wp_register_script( 'post-selector-admin-ajax-script', '', [], '', true );
		wp_enqueue_script( 'post-selector-admin-ajax-script' );
		wp_localize_script( 'post-selector-admin-ajax-script', 'public_ajax_obj', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => $public_nonce
		));
	}

	/**
	 * ================================================
	 * =========== REMOVE REST API ENDPOINT ===========
	 * ================================================
	 */
	public function post_select_removes_api_endpoints_for_not_logged_in(): void {
		if ( ! is_user_logged_in() ) {
			// Removes WordPress endpoints:
			remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );

			// Removes Woocommerce endpoints
			if ( function_exists( 'WC' ) ) {
				remove_action( 'rest_api_init', array( WC()->api, 'register_rest_routes' ), 10 );
			}
		}
	}

	public function load_post_selector_admin_style() {
		$plugin_data = get_file_data( plugin_dir_path( __DIR__ ) . 'wp-post-selector.php', array( 'Version' => 'Version' ), false );
		global $post_sle_version;
		$post_sle_version = $plugin_data['Version'];
		wp_enqueue_script( 'post-selector-bs', POST_SELECT_PLUGIN_URL . '/inc/assets/js/bs/bootstrap.bundle.min.js', array(), $post_sle_version, true );
		//TODO FontAwesome / Bootstrap
		wp_enqueue_style( 'post-selector-admin-bs-style', POST_SELECT_PLUGIN_URL . '/inc/assets/admin/css/bootstrap.min.css', array(), $post_sle_version, false );
		// TODO ADMIN ICONS
		wp_enqueue_style( 'post-selector-admin-icons-style', POST_SELECT_PLUGIN_URL . '/inc/assets/admin/css/font-awesome.css', array(), $post_sle_version, false );
		// TODO DASHBOARD STYLES
		wp_enqueue_style( 'post-selector-admin-dashboard-style', POST_SELECT_PLUGIN_URL . '/inc/assets/admin/css/admin-dashboard-style.css', array(), $post_sle_version, false );

        // TODO DataTable STYLES
        wp_enqueue_style( 'post-selector-admin-data-table', POST_SELECT_PLUGIN_URL . '/inc/assets/admin/css/tools/dataTables.bootstrap5.min.css', array(), $post_sle_version, false );
		//wp_enqueue_script( 'post-selector-admin', POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/admin-js.js', array(), $post_sle_version, true );

        wp_enqueue_script( 'jquery' );
        // TODO LIGHTBOX CSS
        wp_enqueue_style(
            'post-selector-lightbox-css',
            POST_SELECT_PLUGIN_URL . '/inc/assets/admin/css/tools/blueimp-gallery.css',
            array(), $post_sle_version );

        //TODO SORTABLE
        wp_enqueue_script( 'gutenberg-post-selector-sortable',
            POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/tools/Sortable.min.js', array(),
            $post_sle_version, true );


        //TODO LIGHTBOX
        wp_enqueue_script( 'gutenberg-post-selector-lightbox',
            POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/tools/blueimp-gallery.min.js', array(),
            $post_sle_version, true );

        //TODO LIGHTBOX
        wp_enqueue_script( 'gutenberg-post-selector-jq-lightbox',
            POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/tools/jquery.blueimp-gallery.js', array(),
            $post_sle_version, true );

        //DataTables
        wp_enqueue_script( 'gutenberg-post-selector-jq-data-table',
            POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/tools/data-table/jquery.dataTables.min.js', array(),
            $post_sle_version, true );
        wp_enqueue_script( 'gutenberg-post-selector-bs5-data-table',
            POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/tools/data-table/dataTables.bootstrap5.min.js', array(),
            $post_sle_version, true );
        wp_enqueue_script( 'gutenberg-post-selector-data-table-galerie',
            POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/tools/data-table/data-table-galerie.js', array(),
            $post_sle_version, true );


		wp_enqueue_script( 'post-selector-script', POST_SELECT_PLUGIN_URL . '/inc/assets/admin/js/post-selector-admin.js', array(), $post_sle_version, true );
	}
}

$register_post_selector = RegisterGutenbergPostSelector::post_selector_instance();
if ( ! empty( $register_post_selector ) ) {
	$register_post_selector->init_post_selector();
}

require 'post-select-render.php';
require 'post-select-rest-endpoint.php';