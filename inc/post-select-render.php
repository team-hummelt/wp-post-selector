<?php
defined('ABSPATH') or die();
/**
 * Gutenberg POST SELECTOR REST API CALLBACK
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * https://www.hummelt-werbeagentur.de/
 */

function callback_post_selector_block($attributes)
{
    $selected_posts = $attributes['selectedPosts'] ?? false;
    $orderBy = '';
    $order = 'ASC';
    if (isset($attributes['radioOrder']) && $attributes['radioOrder'] == 1) {
        $orderBy = 'menu_order';
    }
    if (isset($attributes['radioOrder']) && $attributes['radioOrder'] == 2) {
        $orderBy = 'post_date';
    }

    if (isset($attributes['selectedCat']) && !empty($attributes['selectedCat'])) {

        isset($attributes['postCount']) && !empty($attributes['postCount']) ? $count = abs($attributes['postCount']) : $count = -1;
        $args = array(
            'post_type' => 'post',
            'cat' => $attributes['selectedCat'],
            'posts_per_page' => $count,
            'orderby' => $orderBy,
            'order' => $order,
        );
        $posts = new WP_Query($args);

    } else {
        $posts = new WP_Query([
            'post__in' => $selected_posts,
            'post_type' => get_post_types(),
            'order_by' => 'posts__in'
        ]);
    }

    wp_reset_query();
    return apply_filters('gutenberg_block_post_selector_render', $posts, $attributes);
}

function gutenberg_block_post_selector_render_filter($query, $attributes)
{
    if ($query->have_posts()) {
        ob_start();
        apply_filters('get_post_select_data_type', $query, $attributes);
        return ob_get_clean();
    }
}

//GALERIE
function callback_post_selector_galerie($attributes)
{
    return apply_filters('gutenberg_block_post_selector_galerie_render', $attributes);
}

function gutenberg_block_post_selector_galerie_render_filter($attributes)
{
    if ($attributes) {
        ob_start();
        apply_filters('load_galerie_templates', $attributes);
        wp_reset_query();
        return ob_get_clean();
    }
}