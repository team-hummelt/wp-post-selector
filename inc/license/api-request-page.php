<?php
defined('ABSPATH') or die();

/**
 * REGISTER HUPA CUSTOM THEME
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */


$data = json_decode(file_get_contents("php://input"));

if($data->client_id !== get_option('post_selector_client_id')){
    $backMsg =  [
        'client_id' => get_option('post_selector_client_id'),
        'reply' => 'falsche Client ID',
        'status' => false,
    ];
    echo json_encode($backMsg);
    exit();
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
        break;
    case'2':
        $message = json_decode($data->message);
        $backMsg = [
            'client_id' => get_option('post_selector_client_id'),
            'reply' => 'Plugin Datei gelöscht',
            'status' => true,
        ];
        update_option('post_selector_message',$message->msg);
        //$file = POST_SELECT_PLUGIN_DIR . DIRECTORY_SEPARATOR . $data->aktivierung_path;
        //unlink($file);
        delete_option('post_selector_product_install_authorize');
        delete_option('post_selector_client_id');
        delete_option('post_selector_client_secret');
        deactivate_plugins( POST_SELECT_SLUG_PATH );
        break;
    default:
        $backMsg = [
          'status' => false
        ];
}

$response = new stdClass();
if($data) {
    echo json_encode($backMsg);
}
