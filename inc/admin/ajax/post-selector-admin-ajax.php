<?php
defined( 'ABSPATH' ) or die();
/**
 * ADMIN AJAX
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */

$responseJson         = new stdClass();
$record               = new stdClass();
$responseJson->status = false;
$data                 = '';
$method               = filter_input( INPUT_POST, 'method', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

switch ( $method ) {
	case'slider-form-handle';

		$type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

		if ( ! $type ) {
			$responseJson->msg = 'Ein Fehler ist aufgetreten!';

			return $responseJson;
		}
		$bezeichnung = filter_input( INPUT_POST, 'bezeichnung', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );


		//Input CheckBoxen
		filter_input( INPUT_POST, 'autoplay', FILTER_SANITIZE_STRING ) ? $autoplay = 1 : $autoplay = 0;
		filter_input( INPUT_POST, 'cover', FILTER_SANITIZE_STRING ) ? $cover = 1 : $cover = 0;

		filter_input( INPUT_POST, 'auto_width', FILTER_SANITIZE_STRING ) ? $auto_width = 1 : $auto_width = 0;
		filter_input( INPUT_POST, 'auto_height', FILTER_SANITIZE_STRING ) ? $auto_height = 1 : $auto_height = 0;
		filter_input( INPUT_POST, 'arrows', FILTER_SANITIZE_STRING ) ? $arrows = 1 : $arrows = 0;

		filter_input( INPUT_POST, 'pause_on_hover', FILTER_SANITIZE_STRING ) ? $pause_on_hover = 1 : $pause_on_hover = 0;
		filter_input( INPUT_POST, 'pause_on_focus', FILTER_SANITIZE_STRING ) ? $pause_on_focus = 1 : $pause_on_focus = 0;
		filter_input( INPUT_POST, 'drag', FILTER_SANITIZE_STRING ) ? $drag = 1 : $drag = 0;
		filter_input( INPUT_POST, 'keyboard', FILTER_SANITIZE_STRING ) ? $keyboard = 1 : $keyboard = 0;

		filter_input( INPUT_POST, 'hover', FILTER_SANITIZE_STRING ) ? $hover = 1 : $hover = 0;
		filter_input( INPUT_POST, 'label', FILTER_SANITIZE_STRING ) ? $label = 1 : $label = 0;
		filter_input( INPUT_POST, 'textauszug', FILTER_SANITIZE_STRING ) ? $textauszug = 1 : $textauszug = 0;
		filter_input( INPUT_POST, 'rewind', FILTER_SANITIZE_STRING ) ? $rewind = 1 : $rewind = 0;

		//Input Breakpoints
		$pro_page_xs  = filter_input( INPUT_POST, 'pro_page_xs', FILTER_VALIDATE_INT );
		$pro_page_sm  = filter_input( INPUT_POST, 'pro_page_sm', FILTER_VALIDATE_INT );
		$pro_page_md  = filter_input( INPUT_POST, 'pro_page_md', FILTER_VALIDATE_INT );
		$pro_page_lg  = filter_input( INPUT_POST, 'pro_page_lg', FILTER_VALIDATE_INT );
		$pro_page_xl  = filter_input( INPUT_POST, 'pro_page_xl', FILTER_VALIDATE_INT );
		$pro_page_xxl = filter_input( INPUT_POST, 'pro_page_xxl', FILTER_VALIDATE_INT );

		$gap_xs  = filter_input( INPUT_POST, 'gap_xs', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$gap_sm  = filter_input( INPUT_POST, 'gap_sm', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$gap_md  = filter_input( INPUT_POST, 'gap_md', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$gap_lg  = filter_input( INPUT_POST, 'gap_lg', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$gap_xl  = filter_input( INPUT_POST, 'gap_xl', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$gap_xxl = filter_input( INPUT_POST, 'gap_xxl', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

		$width_xs  = filter_input( INPUT_POST, 'width_xs', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$width_sm  = filter_input( INPUT_POST, 'width_sm', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$width_md  = filter_input( INPUT_POST, 'width_md', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$width_lg  = filter_input( INPUT_POST, 'width_lg', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$width_xl  = filter_input( INPUT_POST, 'width_xl', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$width_xxl = filter_input( INPUT_POST, 'width_xxl', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

		$height_xs  = filter_input( INPUT_POST, 'height_xs', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$height_sm  = filter_input( INPUT_POST, 'height_sm', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$height_md  = filter_input( INPUT_POST, 'height_md', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$height_lg  = filter_input( INPUT_POST, 'height_lg', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$height_xl  = filter_input( INPUT_POST, 'height_xl', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$height_xxl = filter_input( INPUT_POST, 'height_xxl', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

		$slide_type = filter_input( INPUT_POST, 'slide_type', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$pro_move   = filter_input( INPUT_POST, 'pro_move', FILTER_VALIDATE_INT );
		$pro_page   = filter_input( INPUT_POST, 'pro_page', FILTER_VALIDATE_INT );
		$gap        = filter_input( INPUT_POST, 'gap', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$width      = filter_input( INPUT_POST, 'width', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$height     = filter_input( INPUT_POST, 'height', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$intervall  = filter_input( INPUT_POST, 'intervall', FILTER_VALIDATE_INT );
		$focus      = filter_input( INPUT_POST, 'focus', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

		$trim_space   = filter_input( INPUT_POST, 'trim_space', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$lazy_load    = filter_input( INPUT_POST, 'lazy_load', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$speed        = filter_input( INPUT_POST, 'speed', FILTER_VALIDATE_INT );
		$rewind_speed = filter_input( INPUT_POST, 'rewind_speed', FILTER_VALIDATE_INT );

		$fixed_width  = filter_input( INPUT_POST, 'fixed_width', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
		$fixed_height = filter_input( INPUT_POST, 'fixed_height', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

		$height_ratio = filter_input( INPUT_POST, 'height_ratio', FILTER_SANITIZE_STRING );
		$start_index  = filter_input( INPUT_POST, 'start_index', FILTER_SANITIZE_NUMBER_INT );

		$flick_power   = filter_input( INPUT_POST, 'flick_power', FILTER_SANITIZE_NUMBER_INT );
		$preload_pages = filter_input( INPUT_POST, 'preload_pages', FILTER_SANITIZE_NUMBER_INT );

		filter_input( INPUT_POST, 'pagination', FILTER_SANITIZE_STRING ) ? $pagination = 1 : $pagination = 0;
		filter_input( INPUT_POST, 'slide_focus', FILTER_SANITIZE_STRING ) ? $slide_focus = 1 : $slide_focus = 0;

		$demo_type = filter_input( INPUT_POST, 'demo_type', FILTER_SANITIZE_NUMBER_INT );

		$sliderSettings = [
			'autoplay'       => $autoplay,
			'cover'          => $cover,
			'trim_space'     => $trim_space,
			'auto_width'     => $auto_width,
			'auto_height'    => $auto_height,
			'arrows'         => $arrows,
			'lazy_load'      => $lazy_load,
			'pause_on_hover' => $pause_on_hover,
			'pause_on_focus' => $pause_on_focus,
			'drag'           => $drag,
			'keyboard'       => $keyboard,
			'hover'          => $hover,
			'label'          => $label,
			'textauszug'     => $textauszug,
			'rewind'         => $rewind,
			'speed'          => $speed,
			'rewind_speed'   => $rewind_speed,
			'fixed_width'    => $fixed_width,
			'fixed_height'   => $fixed_height,
			'height_ratio'   => $height_ratio,
			'start_index'    => $start_index,
			'flick_power'    => $flick_power,
			'preload_pages'  => $preload_pages,
			'pagination'     => $pagination,
			'slide_focus'    => $slide_focus,

			'pro_page_xs'  => $pro_page_xs,
			'pro_page_sm'  => $pro_page_sm,
			'pro_page_md'  => $pro_page_md,
			'pro_page_lg'  => $pro_page_lg,
			'pro_page_xl'  => $pro_page_xl,
			'pro_page_xxl' => $pro_page_xxl,

			'gap_xs'  => $gap_xs,
			'gap_sm'  => $gap_sm,
			'gap_md'  => $gap_md,
			'gap_lg'  => $gap_lg,
			'gap_xl'  => $gap_xl,
			'gap_xxl' => $gap_xxl,

			'width_xs'  => $width_xs,
			'width_sm'  => $width_sm,
			'width_md'  => $width_md,
			'width_lg'  => $width_lg,
			'width_xl'  => $width_xl,
			'width_xxl' => $width_xxl,

			'height_xs'  => $height_xs,
			'height_sm'  => $height_sm,
			'height_md'  => $height_md,
			'height_lg'  => $height_lg,
			'height_xl'  => $height_xl,
			'height_xxl' => $height_xxl,

			'slide_type' => $slide_type,
			'pro_move'   => $pro_move,
			'pro_page'   => $pro_page,
			'gap'        => $gap,
			'width'      => $width,
			'height'     => $height,
			'intervall'  => $intervall,
			'focus'      => $focus,
		];

		/*if ( $trim_space == 'move' ) {
			unset( $sliderSettings['trim_space'] );
		} else {
			$sliderSettings['trim_space'] = str_replace( "'", '', $sliderSettings['trim_space'] );
		}*/


		$record->bezeichnung = $bezeichnung;
		$record->slider_id   = apply_filters( 'get_ps_generate_random_id', 12, 0 );
		$record->data        = json_encode( $sliderSettings );

		switch ( $type ) {
			case 'insert':
			case 'demo':
				if($type == 'demo' && $demo_type){
					$demo = apply_filters('get_post_slider_demo', $demo_type);
					if($demo->status) {
						$record->bezeichnung = $demo->bezeichnung;
						$record->data        = json_encode( $demo->record );
					}
				}
				$insert               = apply_filters( 'post_selector_set_slider', $record );
				$responseJson->status = $insert->status;
				$responseJson->msg    = $insert->msg;
				break;
			case 'update':
				$id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
				if ( ! $id ) {
					$responseJson->msg = 'Ein Fehler ist aufgetreten!';

					return $responseJson;
				}
				$record->id = $id;
				apply_filters( 'update_post_selector_slider', $record );
				$responseJson->status = true;
				$responseJson->msg    = 'änderungen gespeichert!';
				break;
		}

		$load_toast = apply_filters( 'post_selector_get_by_args', 'ORDER BY created_at ASC' );
		if ( $load_toast->status ) {
			$responseJson->load_toast = $load_toast->record;
		}

		break;

	case 'get_slider_data':
		$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
		$type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING );

		$responseJson->status = true;
		if ( $type == 'update' ) {
			if ( ! $id ) {
				$responseJson->msg = 'Ein Fehler ist aufgetreten!';

				return $responseJson;
			}
			$args                        = sprintf( 'WHERE id=%d', $id );
			$fetch                       = false;
			$responseJson->load_template = true;
			$responseJson->id            = $id;
			$responseJson->type          = $type;

		} else {
			$args                     = 'ORDER BY created_at ASC';
			$fetch                    = true;
			$responseJson->load_toast = true;
		}

		$load_toast = apply_filters( 'post_selector_get_by_args', $args, $fetch );
		if ( ! $load_toast->status ) {
			return $responseJson;
		}

		$responseJson->record = $load_toast->record;
		$responseJson->status = true;
		break;

	case 'delete_post_items':
		$id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
		$type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING );

		if ( ! $id || ! $type ) {
			$responseJson->msg = 'Ein Fehler ist aufgetreten!';

			return $responseJson;
		}
		switch ( $type ) {
			case 'slider':
				apply_filters( 'delete_post_selector_slider', $id );
				break;
		}
		$responseJson->id     = $id;
		$responseJson->type   = $type;
		$responseJson->status = true;
		$responseJson->msg    = 'erfolgreich gelöscht!';
		break;
}
