<?php

namespace Hupa\ThemeLicense;

defined('ABSPATH') or die();

/**
 * REGISTER HUPA CUSTOM THEME
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */
final class RegisterHupaPostSelector
{
    private static $hupa_post_selector_instance;

    /**
     * @return static
     */
    public static function hupa_post_selector_instance(): self
    {
        if (is_null(self::$hupa_post_selector_instance)) {
            self::$hupa_post_selector_instance = new self();
        }
        return self::$hupa_post_selector_instance;
    }

    public function __construct(){

    }

    public function init_hupa_post_selector(): void
    {

        // TODO REGISTER LICENSE MENU
        if(!get_option('post_selector_product_install_authorize')) {
            add_action('admin_menu', array($this, 'register_license_post_selector_plugin'));
        }
        add_action('wp_ajax_PostSelectLicenceHandle', array($this, 'prefix_ajax_PostSelectLicenceHandle'));
        add_action( 'init', array( $this, 'post_selector_license_site_trigger_check' ) );
        add_action( 'template_redirect',array($this, 'post_selector_license_callback_trigger_check' ));
    }

    /**
     * =================================================
     * =========== REGISTER THEME ADMIN MENU ===========
     * =================================================
     */

    public function register_license_post_selector_plugin(): void
    {
        $hook_suffix = add_menu_page(
            __('WP-Post-Selector', 'wp-post-selector'),
            __('WP-Post-Selector', 'wp-post-selector'),
            'manage_options',
            'post-selector-license',
            array($this, 'hupa_post_selector_license'),
            'dashicons-lock', 2
        );
        add_action('load-' . $hook_suffix, array($this, 'post_selector_load_ajax_admin_options_script'));
    }


    public function hupa_post_selector_license(): void
    {
        require 'activate-post-selector-page.php';
    }


    /**
     * =========================================
     * =========== ADMIN AJAX HANDLE ===========
     * =========================================
     */

    public function post_selector_load_ajax_admin_options_script(): void
    {
        add_action('admin_enqueue_scripts', array($this, 'load_post_selector_admin_style'));
        $title_nonce = wp_create_nonce('post_selector_license_handle');
        wp_register_script('post-selector-ajax-script', '', [], '', true);
        wp_enqueue_script('post-selector-ajax-script');
        wp_localize_script('post-selector-ajax-script', 'post_selector_license_obj', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $title_nonce
        ));
    }

    /**
     * ==================================================
     * =========== THEME AJAX RESPONSE HANDLE ===========
     * ==================================================
     */

    public function prefix_ajax_PostSelectLicenceHandle(): void {
        $responseJson = null;
        check_ajax_referer( 'post_selector_license_handle' );
        require 'post-selector-license-ajax.php';
        wp_send_json( $responseJson );
    }

    /*===============================================
       TODO GENERATE CUSTOM SITES
    =================================================
    */
    public function post_selector_license_site_trigger_check(): void {
        global $wp;
        $wp->add_query_var( POST_SELECT_BASENAME );
    }

    function post_selector_license_callback_trigger_check(): void {
       if ( get_query_var( POST_SELECT_BASENAME ) === POST_SELECT_BASENAME) {
            require 'api-request-page.php';
            exit;
        }
    }

    /**
     * ====================================================
     * =========== THEME ADMIN DASHBOARD STYLES ===========
     * ====================================================
     */

    public function load_post_selector_admin_style(): void
    {
        wp_enqueue_style('post-selector-license-style',plugins_url('wp-post-selector') . '/inc/license/assets/license-backend.css', array(), '');
        wp_enqueue_script('js-post-selector-license', plugins_url('wp-post-selector') . '/inc/license/license-script.js', array(), '', true );
    }
}

$hupa_register_post_selector = RegisterHupaPostSelector::hupa_post_selector_instance();
if (!empty($hupa_register_post_selector)) {
    $hupa_register_post_selector->init_hupa_post_selector();
}
