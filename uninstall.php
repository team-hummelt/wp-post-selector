<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option("post_selector_product_install_authorize");
delete_option("post_selector_client_id");
delete_option("post_selector_client_secret");
delete_option("post_selector_message");
delete_option("post_selector_access_token");

