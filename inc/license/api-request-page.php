<?php
defined('ABSPATH') or die();

/**
 * REGISTER HUPA POST SELECTOR
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 */

global $post_selector_license_exec;
$data = json_decode(file_get_contents("php://input"));

if($data->make_id == 'make_exec'){
    global $post_selector_license_exec;
    $makeJob = $post_selector_license_exec->make_api_exec_job($data);
    $backMsg =  [
        'msg' => $makeJob->msg,
        'status' => $makeJob->status,
    ];
    echo json_encode($backMsg);
    exit();
}


if($data->client_id !== get_option('post_selector_client_id')){
    $backMsg =  [
        'reply' => 'ERROR',
        'status' => false,
    ];
    echo json_encode($backMsg)."<br><br>";
    exit('ERROR');
}
require_once ABSPATH . 'wp-admin/includes/plugin.php';
switch ($data->make_id) {
    case '1':
        $message = json_decode($data->message);
        $backMsg =  [
            'client_id' => get_option('post_selector_client_id'),
            'reply' => 'Plugin deaktiviert',
            'status' => true,
        ];

        update_option('post_selector_message',$message->msg);
        delete_option('post_selector_product_install_authorize');
        delete_option('post_selector_client_id');
        delete_option('post_selector_client_secret');
        deactivate_plugins( POST_SELECT_SLUG_PATH );
        set_transient('show_lizenz_info', true, 5);
        break;
    case'send_versions':
        $backMsg = [
            'status' => true,
            'theme_version' => 'v'.POST_SELECTOR_PLUGIN_VERSION,
        ];
        break;
    default:
        $backMsg = [
          'status' => false,
          'theme_version' => 'unbekannt'
        ];
}

$response = new stdClass();
if($data) {
    echo json_encode($backMsg);
}
