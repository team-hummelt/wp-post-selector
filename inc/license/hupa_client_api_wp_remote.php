<?php

namespace Hupa\PostSelectorPluginLicense;

use Exception;
use stdClass;

defined('ABSPATH') or die();

/**
 * @package Hummelt & Partner WordPress-PLUGIN
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 */

if (!class_exists('HupaApiPluginServerHandle')) {
    add_action('plugin_loaded', array('Hupa\\PostSelectorPluginLicense\\HupaApiPluginServerHandle', 'init'), 0);

    class HupaApiPluginServerHandle
    {
        private static $instance;


        /**
         * @return static
         */
        public static function init(): self
        {
            if (is_null(self::$instance)) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct()
        {

            //TODO Endpoints URL's
            add_filter('get_post_selector_api_urls', array($this, 'PostSelectorGetApiUrl'));
            //TODO JOB POST Resources Endpoints
            add_filter('post_selector_scope_resource', array($this, 'hupaPostselectorPOSTApiResource'), 10, 2);
            //TODO JOB GET Resources Endpoints
            add_filter('get_scope_resource', array($this, 'PostSelectorGETApiResource'), 10, 2);

            //TODO JOB VALIDATE SOURCE BY Authorization Code
            add_filter('get_post_selector_resource_authorization_code', array($this, 'PostSelectorInstallByAuthorizationCode'));


            //TODO JOB SERVER URL ÄNDERN FALLS NÖTIG
            add_filter('post_selector_update_server_url', array($this, 'PostSelectorUpdateServerUrl'));
        }

        public function PostSelectorUpdateServerUrl($url)
        {
            update_option('hupa_server_url', $url);
        }

        public function PostSelectorGetApiUrl($scope): string
        {
            $client_id =  get_option('post_selector_client_id');
            return match ($scope) {
                'authorize_url' => get_option('hupa_server_url') . 'authorize?response_type=code&client_id=' . $client_id,
                default => '',
            };
        }

        public function PostSelectorInstallByAuthorizationCode($authorization_code): object
        {
            $error = new stdClass();
            $error->status = false;
            $client_id =  get_option('post_selector_client_id');
            $client_secret = get_option('post_selector_client_secret');
            $token_url = get_option('hupa_server_url') . 'token';
            $authorization = base64_encode("$client_id:$client_secret");

            $args = array(
                'headers' => array(
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => "Basic {$authorization}"
                ),
                'body' => [
                    'grant_type' => "authorization_code",
                    'code' => $authorization_code
                ]
            );

            $response = wp_remote_post($token_url, $args);
            if (is_wp_error($response)) {
                $error->message = $response->get_error_message();
                return $error;
            }

            $apiData = json_decode($response['body']);
            if ($apiData->error) {
                $apiData->status = false;
                return $apiData;
            }

            update_option('post_selector_access_token', $apiData->access_token);
            $body = [
                'version' => POST_SELECTOR_PLUGIN_VERSION,
            ];
            return $this->hupaPostselectorPOSTApiResource('install', $body);
        }

        public function hupaPostselectorPOSTApiResource($scope, $body=false)
        {
            $response = wp_remote_post(get_option('hupa_server_url') . $scope, $this->PostSelectorApiPostArgs($body));
            if (is_wp_error($response)) {
                return $response->get_error_message();
            }
            if (is_array($response)) {
                $query = json_decode($response['body']);
                if (isset($query->error)) {
                    if ($this->get_error_message($query)) {
                        $this->PostSelectorGetApiClientCredentials();
                    }
                    $response = wp_remote_post(get_option('hupa_server_url') . $scope, $this->PostSelectorApiPostArgs($body));
                    if (is_array($response)) {
                        return json_decode($response['body']);
                    }
                } else {
                    return $query;
                }
            }
            return false;
        }


        public function postSelServerPOSTApiResource($scope, $body = false)
        {
            $response = wp_remote_post(get_option('hupa_server_url') . $scope, $this->PostSelectorApiPostArgs($body));
            if (is_wp_error($response)) {
                return $response->get_error_message();
            }
            if (is_array($response)) {
                $query = json_decode($response['body']);
                if (isset($query->error)) {
                    if ($this->get_error_message($query)) {
                        $this->PostSelectorGetApiClientCredentials();
                    }
                    $response = wp_remote_post(get_option('hupa_server_url') . $scope, $this->PostSelectorApiPostArgs($body));
                    if (is_array($response)) {
                        return $response['body'];
                    }
                } else {
                    return $response['body'];
                }
            }
            return false;
        }

        public function PostSelectorGETApiResource($scope, $get = []) {

            $error = new stdClass();
            $error->status = false;

            $getUrl = '';
            if($get){
                $getUrl = implode('&', $get);
                $getUrl = '?' . $getUrl;
            }

            $url = get_option('hupa_server_url') . $scope . $getUrl;
            $args = $this->PostSelectorGETApiArgs();

            $response = wp_remote_get( $url, $args );
            if (is_wp_error($response)) {
                $error->message = $response->get_error_message();
                return $error;
            }

            $apiData = json_decode($response['body']);
            if($apiData->error){
                $errType = $this->get_error_message($apiData);
                if($errType) {
                    $this->PostSelectorGetApiClientCredentials();
                }
            }

            $response = wp_remote_get(get_option('hupa_server_url'), $this->PostSelectorGETApiArgs() );
            if (is_wp_error($response)) {
                $error->message = $response->get_error_message();
                return $error;
            }
            $apiData = json_decode($response['body']);
            if(!$apiData->error){
                $apiData->status = true;
                return $apiData;
            }

            $error->error = $apiData->error;
            $error->error_description = $apiData->error_description;
            return $error;
        }

        public function PostSelectorApiPostArgs($body = []):array
        {
            $bearerToken = get_option('post_selector_access_token');
            return [
                'method'        => 'POST',
                'timeout'       => 45,
                'redirection'   => 5,
                'httpversion'   => '1.0',
                'blocking'      => true,
                'sslverify'     => true,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => "Bearer $bearerToken"
                ],
                'body'          => $body

            ];
        }

        private function PostSelectorGETApiArgs():array
        {
            $bearerToken = get_option('post_selector_access_token');
            return  [
                'method' => 'GET',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => true,
                'blocking' => true,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => "Bearer $bearerToken"
                ],
                'body'          => []
            ];
        }

        private function PostSelectorGetApiClientCredentials():void
        {
            $token_url = get_option('hupa_server_url') . 'token';
            $client_id =  get_option('post_selector_client_id');
            $client_secret = get_option('post_selector_client_secret');
            $authorization = base64_encode("$client_id:$client_secret");
            $error = new stdClass();
            $error->status = false;
            $args = [
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => true,
                'blocking' => true,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => "Basic $authorization"
                ],
                'body' => [
                    'grant_type' => 'client_credentials'
                ]
            ];

            $response = wp_remote_post($token_url, $args);
            if (!is_wp_error($response)) {
                $apiData = json_decode($response['body']);
                update_option('post_selector_access_token', $apiData->access_token);
            }
        }

        public function PostSelectApiDownloadFile($url, $body = []) {

            $bearerToken = get_option('post_selector_access_token');
            $args = [
                'method'        => 'POST',
                'timeout'       => 45,
                'redirection'   => 5,
                'httpversion'   => '1.0',
                'blocking'      => true,
                'sslverify'     => true,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => "Bearer $bearerToken"
                ],
                'body'          => $body
            ];

            $response = wp_remote_post( $url, $args );

            if (is_wp_error($response)) {
                $this->PostSelectorGetApiClientCredentials();
            }

            $response = wp_remote_post( $url, $args );

            if (is_wp_error($response)) {
                print_r($response->get_error_message());
                exit();
            }

            if( !is_array( $response ) ) {
                exit('Download Fehlgeschlagen!');
            }
            return $response['body'];
        }

        private function get_error_message($error): bool
        {
            $return = false;
            switch ($error->error) {
                case 'invalid_grant':
                case 'insufficient_scope':
                case 'invalid_request':
                    $return = false;
                    break;
                case'invalid_token':
                    $return = true;
                    break;
            }

            return $return;
        }

    }
}

