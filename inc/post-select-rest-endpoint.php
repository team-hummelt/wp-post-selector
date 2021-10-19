<?php
defined( 'ABSPATH' ) or die();
/**
 * Gutenberg POST SELECTOR REST API ENDPOINT
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * https://www.hummelt-werbeagentur.de/
 */

//TODO JOB REST API ENDPOINT
add_action( 'rest_api_init', 'post_select_rest_endpoint_api_handle' );

function post_select_rest_endpoint_api_handle() {
	register_rest_route( 'post-select-endpoint/v1', '/method/(?P<method>[\S]+)', [
		'method'              => WP_REST_Server::EDITABLE,
		'permission_callback' => function () {
			return current_user_can( 'edit_posts' );
		},
		'callback'            => 'post_select_rest_endpoint_get_response',
	] );
}

function post_select_rest_endpoint_get_response( $request ): WP_REST_Response {
	$method = $request->get_param( 'method' );
	$radio_check = $request->get_param('input');
	if ( empty( $method ) ) {
		return new WP_REST_Response( [
			'message' => 'Method not found',
		], 400 );
	}
	$response = new stdClass();

	switch ( $method ) {
		case 'get_post_slider':
			$data = apply_filters('post_selector_get_by_args', '',true, 'id, bezeichnung as name');
			$retSlid = [];
			if($data->status){
				$response->slider  = $data->record;
				foreach ($data->record as $tmp){
					$slid_item = [
						'id' => (int) $tmp->id,
						'name' => $tmp->name
					];
					$retSlid[] = $slid_item;
				}
			} else {
				$response->slider = [];
			}

			$response->slider  = $retSlid;
			$response->radio_check = (int) $radio_check;
			$response->galerie  = [];
			break;

        case 'get_galerie_data':
            $galerie = apply_filters('post_selector_get_galerie','', true, 'id, bezeichnung');
            $retGalerie = [];
            if ($galerie->status){
                foreach ($galerie->record as $tmp) {
                    $galItem = [
                        'id' => $tmp->id,
                        'name' => $tmp->bezeichnung
                    ];
                    $retGalerie[] = $galItem;
                }
            }
            $response->select  = $retGalerie;
            break;
	}

	return new WP_REST_Response( $response, 200 );
}