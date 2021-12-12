<?php

namespace PostSelectorAPIExec\EXEC;

defined('ABSPATH') or die();

use stdClass;
use Hupa\PostSelectorPluginLicense\HupaApiPluginServerHandle;

if (!function_exists('get_plugins')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if (!function_exists('is_user_logged_in')) {
    require_once ABSPATH . 'wp-includes/pluggable.php';
}

/**
 * REGISTER HUPA CUSTOM THEME
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 */
final class PostSelectorLicenseExecAPI
{
    private static $instance;

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        if (is_user_logged_in() && is_admin()) {
            if (site_url() !== get_option('post_selector_license_url')) {
                $msg = 'Version: ' . POST_SELECTOR_PLUGIN_VERSION . ' ungültige Lizenz URL: ' . get_option('post_selector_license_url');
                $this->apiSystemLog('url_error', $msg);
            }
        }
    }

    public function make_api_exec_job($data): object
    {
        $return = new stdClass();
        $return->status = false;
        $getJob = $this->load_post_make_exec_job($data);

        if (!$getJob->status) {
            $return->msg = 'Exec Job konnte nicht ausgeführt werden!';
            return $getJob;
        }
        $getJob = $getJob->record;
        switch ($getJob->exec_id) {
            case '1':
                update_option('post_selector_license_url', site_url());
                $status = true;
                $msg = 'Lizenz Url erfolgreich geändert.';
                break;
            case '2':
                update_option('post_selector_client_id', $getJob->client_id);
                $status = true;
                $msg = 'Client ID erfolgreich geändert.';
                break;
            case '3':
                update_option('post_selector_client_secret', $getJob->client_secret);
                $status = true;
                $msg = 'Client Secret erfolgreich geändert.';
                break;
            case '4':
                $body = [
                    'version' => POST_SELECTOR_PLUGIN_VERSION,
                    'type' => 'aktivierungs_file'
                ];

                $api = HupaApiPluginServerHandle::init();
                $datei = $api->PostSelectApiDownloadFile(get_option('hupa_server_url').'download', $body);
                if($datei){
                    $file = POST_SELECT_PLUGIN_DIR . DIRECTORY_SEPARATOR . $getJob->aktivierung_path;
                    file_put_contents($file, $datei);
                    $activate = activate_plugin( POST_SELECT_SLUG_PATH );
                    if ( is_wp_error( $activate ) ) {
                        $status = false;
                        $msg = 'Plugin konnte nicht aktiviert werden.';
                    } else {
                        $status = true;
                        $msg = 'Plugin erfolgreich aktiviert.';
                        update_option('post_selector_client_id', $getJob->client_id);
                        update_option('post_selector_client_secret', $getJob->client_secret);
                        update_option('post_selector_license_url', site_url());
                        update_option('post_selector_product_install_authorize', true);
                        delete_option('post_selector_message');
                    }
                } else {
                    $status = false;
                    $msg = 'Plugin konnte nicht aktiviert werden.!';
                }
                break;
            case '5':
                deactivate_plugins( POST_SELECT_SLUG_PATH );
                set_transient('show_lizenz_info', true, 5);
                delete_option('post_selector_client_id');
                delete_option('post_selector_client_secret');
                delete_option('post_selector_license_url');
                delete_option('post_selector_product_install_authorize');
                update_option('post_selector_message', 'Das Plugin Post-Selector wurde deaktiviert. Wenden Sie sich an den Administrator.');
                $status = true;
                $msg = 'Post-Selector erfolgreich deaktiviert.';
                break;
            case '6':
                $body = [
                    'version' => POST_SELECTOR_PLUGIN_VERSION,
                    'type' => 'aktivierungs_file'
                ];
                $api = HupaApiPluginServerHandle::init();
                $datei = $api->PostSelectApiDownloadFile(get_option('hupa_server_url').'download', $body);
                if($datei){
                    $file = POST_SELECT_PLUGIN_DIR . DIRECTORY_SEPARATOR . $getJob->aktivierung_path;
                    file_put_contents($file, $datei);
                    $status = true;
                    $msg = 'Aktivierungs File erfolgreich kopiert.';
                } else {
                    $status = false;
                    $msg = 'Datei konnte nicht kopiert werden!';
                }
                break;
            case '7':
                delete_option('post_selector_client_id');
                delete_option('post_selector_client_secret');
                delete_option('post_selector_license_url');
                delete_option('post_selector_product_install_authorize');
                update_option('post_selector_message', 'Das Plugin wurde deaktiviert. Wenden Sie sich an den Administrator.');

                $file = POST_SELECT_PLUGIN_DIR . DIRECTORY_SEPARATOR . $getJob->file_path;
                unlink($file);
                $status = true;
                $msg = 'Aktivierungs File erfolgreich gelöscht.';
                deactivate_plugins( POST_SELECT_SLUG_PATH );
                break;
            case '8':
                update_option('hupa_server_url', $getJob->server_url);
                $status = true;
                $msg = 'Server URL erfolgreich geändert.';
                break;
            case '9':
                $body = [
                    'version' => POST_SELECTOR_PLUGIN_VERSION,
                    'type' => 'update_version'
                ];

                apply_filters('post_scope_resource', $getJob->uri, $body);
                $status = true;
                $msg = 'Version aktualisiert.';
                break;
            default:
                $status = false;
                $msg = 'keine Daten empfangen';
        }

        $return->status = $status;
        $return->msg = $msg;
        return $return;
    }

    protected function load_post_make_exec_job($data, $body = []): object
    {
        $bearerToken = $data->access_token;
        $args = [
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'sslverify' => true,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => "Bearer $bearerToken"
            ],
            'body' => $body
        ];

        $return = new stdClass();
        $return->status = false;
        $response = wp_remote_post($data->url, $args);
        if (is_wp_error($response)) {
            $return->msg = $response->get_error_message();
            return $return;
        }
        if (!is_array($response)) {
            $return->msg = 'API Error Response array!';
            return $return;
        }

        $return->status = true;
        $return->record = json_decode($response['body']);
        return $return;
    }

    public function apiSystemLog($type, $message)
    {

        $body = [
            'type' => $type,
            'version' => POST_SELECTOR_PLUGIN_VERSION,
            'log_date' => date('m.d.Y H:i:s'),
            'message' => $message
        ];

        $remoteApi = HupaApiPluginServerHandle::init();
        $sendErr = $remoteApi->hupaPostselectorPOSTApiResource('error-log', $body);
    }

} //endClass

global $post_selector_license_exec;
$post_selector_license_exec = PostSelectorLicenseExecAPI::instance();

