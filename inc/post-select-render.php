<?php
defined( 'ABSPATH' ) or die();
/**
 * Gutenberg POST SELECTOR REST API CALLBACK
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * https://www.hummelt-werbeagentur.de/
 */

function callback_post_selector_block( $attributes ) {
    $selected_posts = $attributes['selectedPosts'] ?? false;

    $object_query = new WP_Query([
        'post__in'  => $selected_posts,
        'post_type' => get_post_types(),
        'order_by'  => 'posts__in'
    ]);

    return apply_filters( 'gutenberg_block_post_selector_render', $object_query ,$attributes);
}

function gutenberg_block_post_selector_render_filter($query,$attributes) {

    if (  $query->have_posts() ) {
    ob_start();
    apply_filters('get_post_select_data_type', $attributes);
	return ob_get_clean();
    }
}