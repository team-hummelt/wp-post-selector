<?php


namespace Post\Selector;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use stdClass;
use WP_Query;

defined('ABSPATH') or die();

/**
 * ADMIN POST SELECTOR HANDLE
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 */

if (!class_exists('PostSelectorFilter')) {
    add_action('plugin_loaded', array('Post\\Selector\\PostSelectorFilter', 'init'), 0);

    class PostSelectorFilter
    {
        //STATIC INSTANCE
        private static $instance;
        private string $table_slider = 'ps_slider';
        private string $table_galerie = 'ps_galerie';
        private string $table_images = 'ps_galerie_images';

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

            //Helper
            add_filter('get_ps_random_string', array($this, 'getPSRandomString'));
            add_filter('get_ps_generate_random_id', array($this, 'getPSGenerateRandomId'), 10, 4);
            add_filter('psArrayToObject', array($this, 'postSelectArrayToObject'));

            //GET Slider by Args
            add_filter('post_selector_get_by_args', array($this, 'postSelectorGetByArgs'), 10, 3);
            //SET SLIDER
            add_filter('post_selector_set_slider', array($this, 'postSelectorSetSlider'));
            //Update Slider
            add_filter('update_post_selector_slider', array($this, 'updatePostSelectorSlider'));
            //Delete Slider
            add_filter('delete_post_selector_slider', array($this, 'deletePostSelectorSlider'));

            //GET SLIDER TYPES
            add_filter('get_post_select_data_type', array($this, 'getPostSelectDataType'), 10, 2);

            //GET PAGE & POST SELECT
            add_filter('post_selector_get_theme_pages', array($this, 'postSelectorGetThemePages'));
            add_filter('post_selector_get_theme_posts', array($this, 'postSelectorGetThemePosts'));


            add_filter('post_selector_wp_get_attachment', array($this, 'wp_get_attachment'));

            // Design Optionen Select
            add_filter('ps_select_design_optionen', array($this, 'psSelectDesignOptionen'));

            //GET SLIDER DEMOS
            add_filter('get_post_slider_demo', array($this, 'getPostSliderDemo'));

            add_filter('post_hupa_thumbnail_html', array($this, 'post_remove_thumbnail_width_height'));
        }


        public function post_remove_thumbnail_width_height($imgHtml): string
        {
            return preg_replace('@(width.+height.+?".+?")@i', "", $imgHtml);
        }

        public function postSelectorSetSlider($record): object
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_slider;
            $wpdb->insert(
                $table,
                array(
                    'slider_id' => $record->slider_id,
                    'bezeichnung' => $record->bezeichnung,
                    'data' => $record->data,
                ),
                array('%s', '%s', '%s')
            );

            $return = new stdClass();
            if (!$wpdb->insert_id) {
                $return->status = false;
                $return->msg = 'Daten konnten nicht gespeichert werden!';
                $return->id = false;

                return $return;
            }
            $return->status = true;
            $return->msg = 'Daten gespeichert!';
            $return->id = $wpdb->insert_id;

            return $return;
        }

        public function updatePostSelectorSlider($record): void
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_slider;
            $wpdb->update(
                $table,
                array(
                    'bezeichnung' => $record->bezeichnung,
                    'data' => $record->data
                ),
                array('id' => $record->id),
                array(
                    '%s',
                    '%s'
                ),
                array('%d')
            );
        }

        public function deletePostSelectorSlider($id): void
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_slider;
            $wpdb->delete(
                $table,
                array(
                    'id' => $id
                ),
                array('%d')
            );
        }

        public function postSelectorGetByArgs($args, $fetchMethod = true, $col = false): object
        {
            global $wpdb;
            $return = new stdClass();
            $return->status = false;
            $return->count = 0;
            $fetchMethod ? $fetch = 'get_results' : $fetch = 'get_row';
            $table = $wpdb->prefix . $this->table_slider;
            $col ? $select = $col : $select = '*';
            $result = $wpdb->$fetch("SELECT {$select}, DATE_FORMAT(created_at, '%d.%m.%Y %H:%i') AS created  FROM {$table} {$args}");
            if (!$result) {
                return $return;
            }
            $fetchMethod ? $count = count($result) : $count = 1;
            $return->status = true;

            $return->count = $count;
            if ($col) {
                $return->record = $this->postSelectArrayToObject($result);

                return $return;
            }

            if ($fetchMethod) {
                $retArr = [];
                $count = count($result);
                foreach ($result as $tmp) {
                    $ret_item = [
                        'id' => $tmp->id,
                        'slider_id' => $tmp->slider_id,
                        'bezeichnung' => $tmp->bezeichnung,
                        'created_at' => $tmp->created_at,
                        'created' => $tmp->created,
                        'data' => json_decode($tmp->data)
                    ];
                    $retArr[] = $ret_item;
                }
                $return->record = $this->postSelectArrayToObject($retArr);
            } else {
                $data = json_decode($result->data);
                $result->data = $data;
                $return->record = $this->postSelectArrayToObject($result);
                $count = 1;
            }
            $return->count = $count;
            $return->status = true;

            return $return;
        }

        public function getPostSelectDataType($query, $attr)
        {

            $attributes = $this->postSelectArrayToObject($attr);

            $record = new stdClass();
            $record->status = false;
            $sendData = new stdClass();
            $postArr = [];
            isset($attributes->imageCheckActive) ? $sendData->image = true : $sendData->image = false;

            if (isset($attributes->selectedCat) && !empty($attributes->selectedCat)) {
                $sendData->kategorie = true;
                isset($attributes->postCount) && $attributes->postCount ? $sendData->postCount = $attributes->postCount : $sendData->postCount = '-1';
                $sendData->katId = $attributes->selectedCat;

                //$post = $this->get_posts_by_data($sendData, $attributes);
                if (isset($query) && !empty($query)) {
                    $post = $this->get_posts_by_category($query->posts, $attributes);
                } else {
                    $post = $this->get_posts_by_data($sendData, $attributes);
                }

                $post = $this->postSelectArrayToObject($post);
                switch ($attributes->outputType) {
                    case 1:
                        do_action('load_slider_template', $post, $attributes);
                        break;
                    case 3:
                        do_action('load_news_template', $post, $attributes);
                        break;
                }
            }

            if (!isset($attributes->selectedCat) || empty($attributes->selectedCat) && isset($attributes->selectedPosts) && !empty($attributes->selectedPosts)) {
                if (isset($attributes->selectedPosts) && $attributes->selectedPosts) {
                    foreach ($attributes->selectedPosts as $tmp) {
                        $post = $this->get_posts_by_id($tmp);
                        $postArr[] = $post;
                    }
                }

                $post = $this->postSelectArrayToObject($postArr);
                if (isset($attributes->outputType)) {
                    switch ($attributes->outputType) {
                        case '1':
                            do_action('load_slider_template', $post, $attributes);
                            break;
                        case '3':
                            do_action('load_news_template', $post, $attributes);
                            break;
                    }
                }
            }
        }

        private function get_posts_by_category($query, $attr = false): array
        {
            $page_id = get_queried_object_id();
            global $post;
            $postArr = [];

            foreach ($query as $post) {
                setup_postdata($post);
                $customTitle = get_post_meta($post->ID, '_hupa_custom_title', true);
                $customTitle ? $title = $customTitle : $title = get_the_title();
                $image_id = get_post_thumbnail_id();
                $attachment = (object)$this->wp_get_attachment($image_id);

                $post_item = [
                    'post_id' => get_the_ID(),
                    'parent_id' => $page_id,
                    'img_id' => $image_id,
                    'title' => $title,
                    'permalink' => get_the_permalink(),
                    'author' => get_the_author(),
                    'alt' => $attachment->alt,
                    'captions' => $attachment->caption,
                    'description' => $attachment->description,
                    'href' => $attachment->href,
                    'src' => $attachment->src,
                    'img_title' => $attachment->title,
                    'content' => get_the_content(),
                    'excerpt' => get_the_excerpt(),
                    'page_excerpt' => get_the_excerpt($page_id),
                    'date' => esc_html(get_the_date()),
                ];
                $postArr[] = $post_item;
            }
            return $postArr;
        }

        private function get_posts_by_data($data, $attr = false): array
        {
            $page_id = get_queried_object_id();
            global $post;

            $args = [
                'post_type' => get_post_types(),
                'posts_per_page' => $data->postCount,
                'category' => $data->katId,
                'post_status' => 'publish'
            ];

            $posts = get_posts($args);

            $postArr = [];
            foreach ($posts as $post) {
                setup_postdata($post);
                $customTitle = get_post_meta(get_the_ID(), '_hupa_custom_title', true);
                $customTitle ? $title = $customTitle : $title = get_the_title();
                $image_id = get_post_thumbnail_id();
                //$thumb_url_array = wp_get_attachment_image_src($image_id, SLIDER_IMAGE_SIZE, false);
                //print_r($thumb_url_array);
                $attachment = (object)$this->wp_get_attachment($image_id);

                $post_item = [
                    'post_id' => get_the_ID(),
                    'parent_id' => $page_id,
                    'img_id' => $image_id,
                    'title' => $title,
                    //'image'        => get_the_post_thumbnail_url(),
                    //'image' => $thumb_url_array[0],
                    'permalink' => get_the_permalink(),
                    'author' => get_the_author(),
                    'alt' => $attachment->alt,
                    'captions' => $attachment->caption,
                    'description' => $attachment->description,
                    'href' => $attachment->href,
                    'src' => $attachment->src,
                    'img_title' => $attachment->title,
                    'content' => get_the_content(),
                    'excerpt' => get_the_excerpt(),
                    'page_excerpt' => get_the_excerpt($page_id),
                    'date' => esc_html(get_the_date()),
                ];

                $postArr[] = $post_item;
            }
            return $postArr;
        }

        private function get_posts_by_id($id): array
        {
            $page_id = get_queried_object_id();
            global $post;

            $post = get_post($id);
            setup_postdata($post);
            $customTitle = get_post_meta(get_the_ID(), '_hupa_custom_title', true);
            $customTitle ? $title = $customTitle : $title = get_the_title();
            $image_id = get_post_thumbnail_id();


            $attachment = (object)$this->wp_get_attachment($image_id);

            return [
                'post_id' => get_the_ID(),
                'img_id' => $image_id,
                'parent_id' => $page_id,
                'title' => $title,
                'image' => get_the_post_thumbnail_url(),
                'permalink' => get_the_permalink(),
                'author' => get_the_author(),
                'alt' => $attachment->alt,
                'description' => $attachment->description,
                'href' => $attachment->href,
                'src' => $attachment->src,
                'img_title' => $attachment->title,
                'content' => get_the_content(),
                'page_excerpt' => get_the_excerpt($page_id),
                'excerpt' => get_the_excerpt(),
                'captions' => $attachment->caption,
                'date' => esc_html(get_the_date()),
            ];
        }

        final public function postSelectorGetThemePages($args): array
        {
            $pages = get_pages();
            $retArr = [];
            foreach ($pages as $page) {
                $ret_item = [
                    'name' => $page->post_title,
                    'id' => $page->ID,
                    'type' => 'page'
                ];
                $retArr[] = $ret_item;
            }
            return $retArr;
        }

        final public function postSelectorGetThemePosts($args): array
        {
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1
            );

            $posts = get_posts($args);
            $retArr = [];
            $i = 1;
            foreach ($posts as $post) {

                $ret_item = [
                    'name' => $post->post_title,
                    'id' => $post->ID,
                    'type' => 'post',
                    'first' => $i === 1
                ];
                $retArr[] = $ret_item;
                $i++;
            }
            return $retArr;
        }

        #[ArrayShape([
            'alt' => "mixed",
            'description' => "string",
            'href' => "false|string|\WP_Error",
            'src' => "string",
            'title' => "string",
            'caption' => "string"
        ])] public function wp_get_attachment($attachment_id): array
        {

            $attachment = get_post($attachment_id);

            return array(
                'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
                'description' => $attachment->post_content,
                'href' => get_permalink($attachment->ID),
                'src' => $attachment->guid,
                'title' => $attachment->post_title,
                'caption' => $attachment->post_excerpt,
            );
        }

        #[Pure] public function getPostSliderDemo($id): object
        {

            $rand = $this->getPSGenerateRandomId(4, 0, 4);
            $sliderSettings = [];
            $return = new stdClass();
            $return->status = false;
            switch ($id) {
                case '1':
                    $return->bezeichnung = 'Beitrags Slider Demo-' . $rand;
                    $return->status = true;
                    $sliderSettings = [
                        'autoplay' => 'loop',
                        'cover' => 1,
                        'trim_space' => 'true',
                        'auto_width' => 0,
                        'auto_height' => 0,
                        'arrows' => 1,
                        'lazy_load' => 'sequential',
                        'pause_on_hover' => 1,
                        'pause_on_focus' => 1,
                        'drag' => 1,
                        'keyboard' => 1,
                        'hover' => 1,
                        'label' => 0,

                        'img_link_aktiv' => 1,
                        'select_design_option' => 0,
                        'select_design_btn_link' => 1,
                        'design_btn_aktiv' => 0,
                        'design_btn_txt' => 'Button Beschriftung',
                        'design_btn_css' => '',
                        'design_link_tag_txt' => '',
                        'design_text_aktiv' => 0,
                        'select_design_text' => 1,
                        'design_titel_css' => '',
                        'design_auszug_css' => '',
                        'select_title_tag' => 1,
                        'design_container_height'=> '450px',
                        'inner_container_height' => '150px',

                        'textauszug' => 1,
                        'rewind' => 0,
                        'speed' => 500,
                        'rewind_speed' => 1000,
                        'fixed_width' => '',
                        'fixed_height' => '',
                        'height_ratio' => '',
                        'start_index' => 3,
                        'flick_power' => 500,
                        'preload_pages' => 1,
                        'pagination' => 0,
                        'slide_focus' => 1,

                        'pro_page_xs' => 1,
                        'pro_page_sm' => 1,
                        'pro_page_md' => 1,
                        'pro_page_lg' => 2,
                        'pro_page_xl' => 3,
                        'pro_page_xxl' => 4,

                        'gap_xs' => '0.1rem',
                        'gap_sm' => '0.1rem',
                        'gap_md' => '0.1rem',
                        'gap_lg' => '0.3rem',
                        'gap_xl' => '0.3rem',
                        'gap_xxl' => '0.3rem',

                        'width_xs' => '100%',
                        'width_sm' => '100%',
                        'width_md' => '100%',
                        'width_lg' => '100%',
                        'width_xl' => '100%',
                        'width_xxl' => '100%',

                        'height_xs' => '300px',
                        'height_sm' => '300px',
                        'height_md' => '300px',
                        'height_lg' => '250px',
                        'height_xl' => '250px',
                        'height_xxl' => '250px',

                        'slide_type' => 'loop',
                        'pro_move' => '',
                        'pro_page' => 5,
                        'gap' => '0.5rem',
                        'width' => '100%',
                        'height' => '250px',
                        'intervall' => 3000,
                        'focus' => 'center',
                    ];
                    break;
                case'2':
                    $return->status = true;
                    $return->bezeichnung = 'Einzelbild Demo-' . $rand;
                    $sliderSettings = [
                        'autoplay' => 1,
                        'cover' => 1,
                        'trim_space' => 'true',
                        'auto_width' => 0,
                        'auto_height' => 0,
                        'arrows' => 0,
                        'lazy_load' => 'nearby',
                        'pause_on_hover' => 0,
                        'pause_on_focus' => 0,
                        'drag' => 0,
                        'keyboard' => 0,
                        'hover' => 0,
                        'label' => 1,

                        'img_link_aktiv' => 1,
                        'select_design_option' => 0,
                        'select_design_btn_link' => 1,
                        'design_btn_aktiv' => 0,
                        'design_btn_txt' => 'Button Beschriftung',
                        'design_btn_css' => '',
                        'design_link_tag_txt' => '',
                        'design_text_aktiv' => 0,
                        'design_titel_css' => '',
                        'design_auszug_css' => '',
                        'select_title_tag' => 1,
                        'select_design_text' => 1,
                        'design_container_height'=> '450px',
                        'inner_container_height' => '150px',

                        'textauszug' => 0,
                        'rewind' => 1,
                        'speed' => 1200,
                        'rewind_speed' => 2500,
                        'fixed_width' => '',
                        'fixed_height' => '',
                        'height_ratio' => '',
                        'start_index' => 0,
                        'flick_power' => 500,
                        'preload_pages' => 3,
                        'pagination' => 0,
                        'slide_focus' => 1,

                        'pro_page_xs' => '',
                        'pro_page_sm' => '',
                        'pro_page_md' => '',
                        'pro_page_lg' => '',
                        'pro_page_xl' => '',
                        'pro_page_xxl' => '',

                        'gap_xs' => '',
                        'gap_sm' => '',
                        'gap_md' => '',
                        'gap_lg' => '',
                        'gap_xl' => '',
                        'gap_xxl' => '',

                        'width_xs' => '450px',
                        'width_sm' => '450px',
                        'width_md' => '450px',
                        'width_lg' => '450px',
                        'width_xl' => '450px',
                        'width_xxl' => '450px',

                        'height_xs' => '350px',
                        'height_sm' => '350px',
                        'height_md' => '350px',
                        'height_lg' => '350px',
                        'height_xl' => '350px',
                        'height_xxl' => '350px',

                        'slide_type' => 'fade',
                        'pro_move' => 1,
                        'pro_page' => 1,
                        'gap' => '0',
                        'width' => '450px',
                        'height' => '350px',
                        'intervall' => 8000,
                        'focus' => '0',
                    ];
                    break;

            }
            $return->record = $sliderSettings;

            return $return;
        }

        public function psSelectDesignOptionen($args = false): object
        {
            $selectDesign = [
                '0' => [
                    'id' => 0,
                    'name' => 'auswählen...'
                ],
                '1' => [
                    'id' => 1,
                    'name' => 'erweitert'
                ]
            ];

            $selectLinkType = [
                '0'=> [
                    'id' => 1,
                    'name' => 'Light Box',
                ],
                '1'=> [
                    'id' => 2,
                    'name' => 'zum Beitrag',
                ],
                '2'=> [
                    'id' => 3,
                    'name' => 'Bildanhang Seite',
                ],
                '3'=> [
                    'id' => 4,
                    'name' => 'extra Url',
                ]
            ];

            $selectTextOption = [
                '0' => [
                    'id' => 1,
                    'name' => 'Beitragstitel'
                ],
                '1' => [
                    'id' => 2,
                    'name' => 'Textauszug'
                ],
                '2' => [
                    'id' => 3,
                    'name' => 'Beitragstitel & Textauszug'
                ]
            ];

            $selectTitleTag = [
                '0' => [
                    'id' => 1,
                    'name' => 'Beitragstitel'
                ],
                '1' => [
                    'id' => 2,
                    'name' => 'individuell'
                ]
            ];

            $returnArray = [
                'select_design' => $selectDesign,
                'select_link' => $selectLinkType,
                'select_text' => $selectTextOption,
                'select_title_tag' => $selectTitleTag
            ];

            return $this->postSelectArrayToObject($returnArray);
        }

        /**
         * @throws Exception
         */
        public function getPSRandomString(): string
        {
            if (function_exists('random_bytes')) {
                $bytes = random_bytes(16);
                $str = bin2hex($bytes);
            } elseif (function_exists('openssl_random_pseudo_bytes')) {
                $bytes = openssl_random_pseudo_bytes(16);
                $str = bin2hex($bytes);
            } else {
                $str = md5(uniqid('post_selector_rand', true));
            }

            return $str;
        }

        public function getPSGenerateRandomId($passwordlength = 12, $numNonAlpha = 1, $numNumberChars = 4, $useCapitalLetter = true): string
        {
            $numberChars = '123456789';
            //$specialChars = '!$&?*-:.,+@_';
            $specialChars = '!$%&=?*-;.,+~@_';
            $secureChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
            $stack = $secureChars;
            if ($useCapitalLetter == true) {
                $stack .= strtoupper($secureChars);
            }
            $count = $passwordlength - $numNonAlpha - $numNumberChars;
            $temp = str_shuffle($stack);
            $stack = substr($temp, 0, $count);
            if ($numNonAlpha > 0) {
                $temp = str_shuffle($specialChars);
                $stack .= substr($temp, 0, $numNonAlpha);
            }
            if ($numNumberChars > 0) {
                $temp = str_shuffle($numberChars);
                $stack .= substr($temp, 0, $numNumberChars);
            }

            return str_shuffle($stack);
        }

        /**
         * @param $array
         *
         * @return object
         */
        final public function postSelectArrayToObject($array): object
        {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::postSelectArrayToObject($value);
                }
            }

            return (object)$array;
        }

    }
}