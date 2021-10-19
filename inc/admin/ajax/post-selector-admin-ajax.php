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

        $img_size = filter_input( INPUT_POST, 'img_size', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

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
		    'img_size'       => $img_size,
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

    case'post_galerie_handle':

        $type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
        $bezeichnung = filter_input( INPUT_POST, 'bezeichnung', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
        $beschreibung = filter_input( INPUT_POST, 'beschreibung', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

        $record->type   = filter_input( INPUT_POST, 'galerie_type', FILTER_VALIDATE_INT );
        $link = filter_input( INPUT_POST, 'link', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
        $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);

        filter_input(INPUT_POST, 'show_bezeichnung', FILTER_SANITIZE_STRING) ? $record->show_bezeichnung = true : $record->show_bezeichnung = false;
        filter_input(INPUT_POST, 'show_beschreibung', FILTER_SANITIZE_STRING) ? $record->show_beschreibung = true : $record->show_beschreibung = false;

        filter_input(INPUT_POST, 'hover_aktiv', FILTER_SANITIZE_STRING) ? $record->hover_aktiv = true : $record->hover_aktiv = false;
        filter_input(INPUT_POST, 'hover_title_aktiv', FILTER_SANITIZE_STRING) ? $record->hover_title_aktiv = true : $record->hover_title_aktiv = false;
        filter_input(INPUT_POST, 'hover_beschreibung_aktiv', FILTER_SANITIZE_STRING) ? $record->hover_beschreibung_aktiv = true : $record->hover_beschreibung_aktiv = false;
        filter_input(INPUT_POST, 'lightbox_aktiv', FILTER_SANITIZE_STRING) ? $record->lightbox_aktiv = true : $record->lightbox_aktiv = false;
        filter_input(INPUT_POST, 'caption_aktiv', FILTER_SANITIZE_STRING) ? $record->caption_aktiv = true : $record->caption_aktiv = false;

        filter_input(INPUT_POST, 'lazy_load_aktiv', FILTER_SANITIZE_STRING) ? $record->lazy_load_aktiv = true : $record->lazy_load_aktiv = false;

        $img_size = filter_input( INPUT_POST, 'image_size', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

        $record->is_link = false;
        if($url){
            $record->link = $url;
        } elseif ($link) {
            $record->link = $link;
            $record->is_link = true;
        } else {
            $record->link = '';
        }

        if(!$type){
            $responseJson->msg = 'Ein Fehler ist aufgetreten!';
            $responseJson->status = false;
            return $responseJson;
        }

        if(!$bezeichnung) {
            $bezeichnung = 'Galerie-' .apply_filters('get_ps_generate_random_id',4,0,4);
        }

        switch ($record->type){
            case '1':
                $slider_id   = filter_input( INPUT_POST, 'slider_id', FILTER_VALIDATE_INT );

                $typeSettings = [
                  'slider_id' => $slider_id,
                  'img_size' => $img_size
                ];
                break;
            case'2':
                filter_input(INPUT_POST, 'galerie_crop_aktiv', FILTER_SANITIZE_STRING) ? $galerie_crop_aktiv = true : $galerie_crop_aktiv = false;
                $img_width   = filter_input( INPUT_POST, 'img_width', FILTER_VALIDATE_INT );
                $img_height   = filter_input( INPUT_POST, 'img_height', FILTER_VALIDATE_INT );

                $xl_grid_column = filter_input( INPUT_POST, 'xl_grid_column', FILTER_SANITIZE_STRING);
                $xl_grid_gutter = filter_input( INPUT_POST, 'xl_grid_gutter', FILTER_SANITIZE_STRING);

                $lg_grid_column = filter_input( INPUT_POST, 'lg_grid_column', FILTER_SANITIZE_STRING);
                $lg_grid_gutter = filter_input( INPUT_POST, 'lg_grid_gutter', FILTER_SANITIZE_STRING);

                $md_grid_column = filter_input( INPUT_POST, 'md_grid_column', FILTER_SANITIZE_STRING);
                $md_grid_gutter = filter_input( INPUT_POST, 'md_grid_gutter', FILTER_SANITIZE_STRING);

                $sm_grid_column = filter_input( INPUT_POST, 'sm_grid_column', FILTER_SANITIZE_STRING);
                $sm_grid_gutter = filter_input( INPUT_POST, 'sm_grid_gutter', FILTER_SANITIZE_STRING);

                $xs_grid_column = filter_input( INPUT_POST, 'xs_grid_column', FILTER_SANITIZE_STRING);
                $xs_grid_gutter = filter_input( INPUT_POST, 'xs_grid_gutter', FILTER_SANITIZE_STRING);

                $typeSettings = [
                    'img_size' => $img_size,
                    'crop' => $galerie_crop_aktiv,
                    'img_width' => $img_width ?: 260,
                    'img_height' => !$img_height &&  !$galerie_crop_aktiv ? 160 : $img_height,
                    'xl_grid_column' => $xl_grid_column ?: 5,
                    'xl_grid_gutter' => $xl_grid_gutter ?: 1,
                    'lg_grid_column' => $lg_grid_column ?: 4,
                    'lg_grid_gutter' => $lg_grid_gutter ?: 1,
                    'md_grid_column' => $md_grid_column ?: 3,
                    'md_grid_gutter' => $md_grid_gutter ?: 1,
                    'sm_grid_column' => $sm_grid_column ?: 2,
                    'sm_grid_gutter' => $sm_grid_gutter ?: 1,
                    'xs_grid_column' => $xs_grid_column ?: 1,
                    'xs_grid_gutter' => $xs_grid_gutter ?: 1
                ];
                break;
            case '3':
                $xl_column = filter_input( INPUT_POST, 'xl_column', FILTER_SANITIZE_STRING);
                $xl_gutter = filter_input( INPUT_POST, 'xl_gutter', FILTER_SANITIZE_STRING);

                $lg_column = filter_input( INPUT_POST, 'lg_column', FILTER_SANITIZE_STRING);
                $lg_gutter = filter_input( INPUT_POST, 'lg_gutter', FILTER_SANITIZE_STRING);

                $md_column = filter_input( INPUT_POST, 'md_column', FILTER_SANITIZE_STRING);
                $md_gutter = filter_input( INPUT_POST, 'md_gutter', FILTER_SANITIZE_STRING);

                $sm_column = filter_input( INPUT_POST, 'sm_column', FILTER_SANITIZE_STRING);
                $sm_gutter = filter_input( INPUT_POST, 'sm_gutter', FILTER_SANITIZE_STRING);

                $xs_column = filter_input( INPUT_POST, 'xs_column', FILTER_SANITIZE_STRING);
                $xs_gutter = filter_input( INPUT_POST, 'xs_gutter', FILTER_SANITIZE_STRING);

                $typeSettings = [
                    'img_size'  => $img_size,
                    'xl_column' => $xl_column ?: 6,
                    'xl_gutter' => $xl_gutter ?: 2,
                    'lg_column' => $lg_column ?: 5,
                    'lg_gutter' => $lg_gutter ?: 1,
                    'md_column' => $md_column ?: 4,
                    'md_gutter' => $md_gutter ?: 1,
                    'sm_column' => $sm_column ?: 3,
                    'sm_gutter' => $sm_gutter ?: 1,
                    'xs_column' => $xs_column ?: 2,
                    'xs_gutter' => $xs_gutter ?: 1
                ];
                break;
            default:
                $typeSettings = [];
        }

        if(!$typeSettings){
            $responseJson->msg = 'kein Galerie Type ausgewählt!';
            return $responseJson;
        }
        $record->type_settings = json_encode($typeSettings);
        $record->bezeichnung = esc_html($bezeichnung);
        $record->beschreibung = esc_textarea($beschreibung);

        switch ($type){
            case'insert':
                $insert = apply_filters('post_selector_set_galerie', $record);
                if(!$insert->id) {
                    $responseJson->msg = $insert->msg;
                    $responseJson->status = false;
                    return $responseJson;
                }
                $responseJson->id = $insert->id;
                $args = sprintf('WHERE id=%d', $insert->id);
                $galerie = apply_filters('post_selector_get_galerie','');
                if(!$galerie->status){
                    $responseJson->msg = 'Ein Fehler ist aufgetreten!';
                    $responseJson->status = false;
                    return $responseJson;
                }

                $responseJson->images = false;
                $responseJson->galerie = $galerie->record;
                $responseJson->show_galerie = true;
                $responseJson->reset = true;
                $responseJson->status = true;
                break;

            case 'update':
                $id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
                if(!$id){

                    $responseJson->msg = 'Ein Fehler ist aufgetreten!';
                    $responseJson->status = false;
                    return $responseJson;
                }
                $record->id = $id;
                apply_filters('post_selector_update_galerie', $record);
                $responseJson->msg = 'Änderungen erfolgreich gespeichert!';

                break;
        }
        $responseJson->status = true;
        break;

    case 'get_galerie_data':
        $id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

        $responseJson->status = true;
        $responseJson->type = $type;
        switch ($type) {
            case'galerie-toast':
                $galerie = apply_filters('post_selector_get_galerie','');
                $responseJson->galerie = $galerie->record;
                return $responseJson;
        }

        if(!$id || !$type){
            $responseJson->msg = 'Ein Fehler ist aufgetreten!';
            $responseJson->status = false;
            return $responseJson;
        }

        $pages = apply_filters('post_selector_get_theme_pages', false);
        $post = apply_filters('post_selector_get_theme_posts', false);
        if ($post) {
            $responseJson->sitesSelect = array_merge_recursive($pages, $post);
        } else {
            $responseJson->sitesSelect = $pages;
        }
        $responseJson->galerieSelect = apply_filters('get_galerie_types_select','');

        $galerieArgs = sprintf('WHERE id=%d', $id);
        $galerie = apply_filters('post_selector_get_galerie',$galerieArgs, false);
        $responseJson->record = $galerie->record;

        $galerie->record->type_settings = json_decode($galerie->record->type_settings);


        $args = sprintf('WHERE galerie_id=%d ORDER BY position ASC', $id);
        $images = apply_filters('post_selector_get_images',$args);

        if($images->status){
            $img_arr = [];
            foreach ($images->record as $tmp){
                $src = wp_get_attachment_image_src( $tmp->img_id, 'medium', false );
                $url = wp_get_attachment_image_src( $tmp->img_id, 'large', false );
                $img_item = [
                    'id' => $tmp->id,
                    'src' => $src[0],
                    'url' => $url[0],
                    'img_id' => $tmp->img_id,
                    'bezeichnung' => $tmp->img_bezeichnung,
                    'beschreibung' => $tmp->beschreibung,
                    'title' => $tmp->img_title
                ];
                $img_arr[] = $img_item;
            }
            $img_arr ? $responseJson->images = $img_arr : $responseJson->images = false;
        }
        break;

    case 'delete_image':
        $id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        if(!$id){
            $responseJson->msg = 'Ein Fehler ist aufgetreten!';
            $responseJson->status = false;
            return $responseJson;
        }
        apply_filters('post_selector_delete_image', $id);
        $responseJson->id = $id;
        $responseJson->status = true;
        $responseJson->msg = 'Bild gelöscht!';
        break;

    case 'add_galerie_image':
        $type   = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH );
        $record->img_title   = filter_input( INPUT_POST, 'img_title', FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH );
        $record->img_beschreibung   = filter_input( INPUT_POST, 'img_beschreibung', FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH );
        $record->img_caption   = filter_input( INPUT_POST, 'img_caption', FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH );

        switch ($type){
            case 'insert':
                $galerie_id   = filter_input( INPUT_POST, 'galerie_id', FILTER_VALIDATE_INT );
                $image_id   = filter_input( INPUT_POST, 'image_id', FILTER_VALIDATE_INT );
                $record->galerie_id = (int) $galerie_id;
                $record->img_id = (int) $image_id;
                $insert = apply_filters('post_selector_set_image', $record);
                $responseJson->id = $insert->id;
                break;
            case'update':
                $record->id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
                if(!$record->id ){
                    $responseJson->msg = 'Ein Fehler ist aufgetreten!';
                    $responseJson->status = false;
                    return $responseJson;
                }
                filter_input(INPUT_POST, 'hover_aktiv', FILTER_SANITIZE_STRING) ? $record->hover_aktiv = true : $record->hover_aktiv = false;
                filter_input(INPUT_POST, 'hover_title_aktiv', FILTER_SANITIZE_STRING) ? $record->hover_title_aktiv = true : $record->hover_title_aktiv = false;
                filter_input(INPUT_POST, 'hover_beschreibung_aktiv', FILTER_SANITIZE_STRING) ? $record->hover_beschreibung_aktiv = true : $record->hover_beschreibung_aktiv = false;
                filter_input(INPUT_POST, 'galerie_settings_aktiv', FILTER_SANITIZE_STRING) ? $record->galerie_settings_aktiv = true : $record->galerie_settings_aktiv = false;

                $link = filter_input( INPUT_POST, 'link', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
                $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);

                $record->is_link = false;
                if($url){
                    $record->link = $url;
                } elseif ($link) {
                    $record->link = $link;
                    $record->is_link = true;
                } else {
                    $record->link = '';
                }

                apply_filters('post_selector_update_image', $record);
                $responseJson->msg = 'Änderungen gespeichert!';
                break;
        }

        $responseJson->status = true;
        break;

    case 'delete_galerie':
        $id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING );
        if(!$id || !$type){
            $responseJson->msg = 'Ein Fehler ist aufgetreten!';
            $responseJson->status = false;
            return $responseJson;
        }
        apply_filters('post_selector_delete_galerie', $id);
        $galerie = apply_filters('post_selector_get_galerie','');
        $responseJson->type = $type;
        $responseJson->galerie = $galerie->record;
        $responseJson->status = true;
        $responseJson->id = $id;
        $responseJson->msg = 'Galerie gelöscht!';
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
		//Get Galerie
        $galerie = apply_filters('post_selector_get_galerie', '');
        $galerie->status ? $responseJson->galerie = $galerie->record : $responseJson->galerie = false;

        //Get Slider
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

    case 'get_galerie_modal_data':
        $pages = apply_filters('post_selector_get_theme_pages', false);
        $post = apply_filters('post_selector_get_theme_posts', false);
        if ($post) {
           $responseJson->sitesSelect = array_merge_recursive($pages, $post);
        } else {
           $responseJson->sitesSelect = $pages;
        }

        $responseJson->galerieSelect = apply_filters('get_galerie_types_select','');
        $responseJson->status = true;
        break;

    case'get_image_modal_data':
        $id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if(!$id){
            $responseJson->msg = 'Ein Fehler ist aufgetreten!';
            $responseJson->status = false;
            return $responseJson;
        }

        $args = sprintf('WHERE id=%d ORDER BY position ASC', $id);
        $image = apply_filters('post_selector_get_images', $args, false);
        if(!$image->status){
            $responseJson->msg = 'Ein Fehler ist aufgetreten!';
            $responseJson->status = false;
            return $responseJson;
        }

        $responseJson->record = $image->record;
        $pages = apply_filters('post_selector_get_theme_pages', false);
        $post = apply_filters('post_selector_get_theme_posts', false);
        if ($post) {
            $responseJson->sitesSelect = array_merge_recursive($pages, $post);
        } else {
            $responseJson->sitesSelect = $pages;
        }

        $responseJson->galerieSelect = apply_filters('get_galerie_types_select','');
        $responseJson->status = true;
        break;

    case 'get_galerie_type_data':
        $typeId   = filter_input( INPUT_POST, 'type_id', FILTER_VALIDATE_INT );
        $id   = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        if(!$typeId){
            $responseJson->msg = 'keine Daten gefunden!';
           return $responseJson;
        }

        if($id){
            $galerieArgs = sprintf('WHERE id=%d', $id);
            $galerie = apply_filters('post_selector_get_galerie',$galerieArgs, false);
            $galerie->status ? $responseJson->typeSettings = json_decode($galerie->record->type_settings) : $responseJson->typeSettings = false;
        }

        $responseJson->type = (string) $typeId;
        switch ($typeId){
            case '1':
                $postSlider = apply_filters('post_selector_get_by_args','', true, 'bezeichnung, id');
                if(!$postSlider->status){
                    $responseJson->msg = 'kein Slider gefunden!';
                   return $responseJson;
                }
                $responseJson->sliderSelect = $postSlider->record;
                $responseJson->status = true;
                $responseJson->disabled = false;
                break;
            case '2':
            case '3':
                $responseJson->status = true;
                $responseJson->disabled = false;
                break;
        }

        break;
    case'image_change_position':
       $regEx = '/(\d{1,6})/i';
        if($_POST['data']){
            $position = 1;
            foreach ($_POST['data'] as $tmp){
                preg_match($regEx, $tmp, $hit);
                if($hit[0]){
                    apply_filters('post_update_sortable_position',$hit[0], $position);
                    $position++;
                }
            }
        }

        $responseJson->status = true;
        break;
}
