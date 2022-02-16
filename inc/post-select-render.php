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
    $total = 0;
    $pagination = '';
    if (isset($attributes['selectedCat']) && !empty($attributes['selectedCat'])) {
        //Pagination
        isset( $attributes['paginationActive'] ) && $attributes['paginationActive'] ? $paginationActive = true : $paginationActive = false;
        isset( $attributes['postPaginationLimit'] ) ? $postPaginationLimit = (int) $attributes['postPaginationLimit'] : $postPaginationLimit = 10;
        isset($attributes['postCount']) && !empty($attributes['postCount']) ? $count = abs($attributes['postCount']) : $count = -1;
        if($paginationActive){
            get_query_var('paged') ? $paged = get_query_var('paged') : $paged = 1;
            $limit = $postPaginationLimit;
            $totalArgs = [
                'post_type' => 'post',
                'cat' => $attributes['selectedCat'],
                'posts_per_page' => -1,
            ];

            $totalPosts = new WP_Query($totalArgs);
            if($totalPosts){
                $total = count($totalPosts->posts);
            }

            $pagination = make_news_pagination($total,$limit,$paged);

            $args = array(
                'post_type' => 'post',
                'cat' => $attributes['selectedCat'],
                'posts_per_page' => $limit,
                'offset' => $paged,
                //  'orderby' => $orderBy,
                //  'order' => $order,
            );

            $posts = new WP_Query($args);


        } else {
            $args = array(
                'post_type' => 'post',
                'cat' => $attributes['selectedCat'],
                'posts_per_page' => $count,
                //  'orderby' => $orderBy,
                //  'order' => $order,
            );
            $posts = new WP_Query($args);
        }
    } else {
        $posts = new WP_Query([
            'post__in' => $selected_posts,
            'post_type' => get_post_types(),
            //'order_by' => 'posts__in'
        ]);
    }

    wp_reset_query();
    return apply_filters('gutenberg_block_post_selector_render', $posts, $attributes, $pagination);
}

function gutenberg_block_post_selector_render_filter($query, $attributes, $pagination)
{
    if ($query->have_posts()) {
        ob_start();
        apply_filters('get_post_select_data_type', $query, $attributes);
        if($pagination){
            echo $pagination;
        }
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

 function make_news_pagination($total, $limit, $paged, $range = 2):string {
     $pages  = ceil( $total / $limit );
     if($pages < 2){
         return '';
     }
     $showitems = ($range * 2) + 1;
     $paged == (int)$pages ? $last = 'disabled' : $last = '';
     $paged == '1' ? $first = 'disabled' : $first = '';
     $html = '';
     $html .= '<nav id="theme-pagination" aria-label="Page navigation" role="navigation">';
     $html .= '<span class="sr-only">Page navigation</span>';
     $html .= '<ul class="pagination justify-content-center ft-wpbs mb-4">';
     $html .= '<li class="page-item ' . $first . '"><a class="page-link" href="' . get_pagenum_link(1) . '" aria-label="First Page"><i class="fa fa-angle-double-left"></i></a></li>';
     $html .= '<li class="page-item ' . $first . '"><a class="page-link" href="' . get_pagenum_link($paged - 1) . '" aria-label="Previous Page"><i class="fa fa-angle-left"></i></a></li>';
     for ($i = 1; $i <= $pages; $i++) {
         if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
             $html .= ($paged == $i) ? '<li class="page-item active"><span class="page-link"><span class="sr-only">Current Page </span>' . $i . '</span></li>' : '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '"><span class="sr-only">Page </span>' . $i . '</a></li>';
         }
     }
     $html .= '<li class="page-item ' . $last . '"><a class="page-link" href="' . get_pagenum_link($paged + 1) . '" aria-label="Next Page"><i class="fa fa-angle-right"></i> </a></li>';
     $html .= '<li class="page-item ' . $last . '"><a class="page-link" href="' . get_pagenum_link($pages) . '" aria-label="Last Page"><i class="fa fa-angle-double-right"></i> </a></li>';
     $html .= '</ul>';
     $html .= '</nav>';
     $html .= '<div class="pagination-info mb-5 text-center"> <span class="text-muted">( Seite</span> ' . $paged . ' <span class="text-muted">von ' . $pages . ' )</span></div>';
    return preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $html));
}