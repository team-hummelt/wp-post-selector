<?php


namespace Post\Selector;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use stdClass;
use WP_Query;

defined('ABSPATH') or die();

/**
 * ADMIN POST SELECTOR GALERIE HANDLE
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */

if (!class_exists('PostSelectorGalerieFilter')) {
    add_action('plugin_loaded', array('Post\\Selector\\PostSelectorGalerieFilter', 'init'), 0);

    class PostSelectorGalerieFilter
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
            //JOB WARNING GALERIE SET GALERIE
            //Set Galerie
            add_filter('post_selector_set_galerie', array($this, 'postSelectorSetGalerie'));
            //Get Galerie
            add_filter('post_selector_get_galerie', array($this, 'postSelectorGetGalerie'), 10, 3);
            //Update Galerie
            add_filter('post_selector_update_galerie', array($this, 'postSelectorUpdateGalerie'));
            //DELETE GALERIE
            add_filter('post_selector_delete_galerie', array($this, 'PostSelectorDeleteGalerie'));

            //JOB WARNING GALERIE Image
            //SET GALERIE IMAGE
            add_filter('post_selector_set_image', array($this, 'postSelectorSetImage'));
            //UPDATE IMAGE
            add_filter('post_selector_update_image', array($this, 'postSelectorUpdateImage'));
            //GET Images
            add_filter('post_selector_get_images', array($this, 'postSelectorGetImages'), 10, 3);
            //DELETE IMAGE
            add_filter('post_selector_delete_image', array($this, 'PostSelectorDeleteImage'));
            // UPDATE POSITION
            add_filter('post_update_sortable_position', array($this, 'postSelectorUpdateSortablePosition'), 10, 2);

            //User Role Select
            add_filter('ps_user_roles_select', array($this, 'post_selector_user_roles_select'));

            //JOB WARNING HELPER
            //GET Galerie Types Select
            add_filter('get_galerie_types_select', array($this, 'getGalerieTypesSelect'));
            //GET Animate Type
            add_filter('post_selector_get_animate_select', array($this, 'postSelectorGetAnimateSelect'));
            //GET Image FileSize
            add_filter('post_select_file_size_convert', array($this, 'PostSelectFileSizeConvert'));

        }

        public function post_selector_user_roles_select(): array {

                return [
                    'read'           => esc_html__( 'Subscriber', 'wp-post-selector' ),
                    'edit_posts'     => esc_html__( 'Contributor', 'wp-post-selector' ),
                    'publish_posts'  => esc_html__( 'Author', 'wp-post-selector' ),
                    'publish_pages'  => esc_html__( 'Editor', 'wp-post-selector' ),
                    'manage_options' => esc_html__( 'Administrator', 'wp-post-selector' )
                ];
         }

        public function postSelectorSetGalerie($record): object
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_galerie;
            $wpdb->insert(
                $table,
                array(
                    'bezeichnung' => $record->bezeichnung,
                    'type' => $record->type,
                    'type_settings' => $record->type_settings,
                    'link' => $record->link,
                    'is_link' => $record->is_link,
                    'hover_aktiv' => $record->hover_aktiv,
                    'hover_title_aktiv' => $record->hover_title_aktiv,
                    'hover_beschreibung_aktiv' => $record->hover_beschreibung_aktiv,
                    'lightbox_aktiv' => $record->lightbox_aktiv,
                    'caption_aktiv' => $record->caption_aktiv,
                    'show_bezeichnung' => $record->show_bezeichnung,
                    'show_beschreibung' => $record->show_beschreibung,
                    'beschreibung' => $record->beschreibung,
                    'lazy_load_aktiv' => $record->lazy_load_aktiv,
                    'lazy_load_ani_aktiv' => $record->lazy_load_ani_aktiv,
                    'animate_select' => $record->animate_select,
                    'link_target' => $record->link_target
                ),
                array('%s', '%d', '%s', '%s','%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%s', '%d')
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

        public function postSelectorUpdateGalerie($record): void
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_galerie;
            $wpdb->update(
                $table,
                array(
                    'bezeichnung' => $record->bezeichnung,
                    'type' => $record->type,
                    'type_settings' => $record->type_settings,
                    'link' => $record->link,
                    'is_link' => $record->is_link,
                    'hover_aktiv' => $record->hover_aktiv,
                    'hover_title_aktiv' => $record->hover_title_aktiv,
                    'hover_beschreibung_aktiv' => $record->hover_beschreibung_aktiv,
                    'lightbox_aktiv' => $record->lightbox_aktiv,
                    'caption_aktiv' => $record->caption_aktiv,
                    'show_bezeichnung' => $record->show_bezeichnung,
                    'show_beschreibung' => $record->show_beschreibung,
                    'beschreibung' => $record->beschreibung,
                    'lazy_load_aktiv' => $record->lazy_load_aktiv,
                    'lazy_load_ani_aktiv' => $record->lazy_load_ani_aktiv,
                    'animate_select' => $record->animate_select,
                    'link_target' => $record->link_target,
                ),
                array('id' => $record->id),
                array('%s', '%d', '%s','%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%s', '%d'),
                array('%d')
            );
        }

        public function postSelectorGetGalerie($args, $fetchMethod = true, $col = false): object
        {
            global $wpdb;
            $return = new stdClass();
            $return->status = false;
            $return->count = 0;
            $fetchMethod ? $fetch = 'get_results' : $fetch = 'get_row';
            $table = $wpdb->prefix . $this->table_galerie;
            $col ? $select = $col : $select = '*';
            $result = $wpdb->$fetch("SELECT {$select}  FROM {$table} {$args}");
            if (!$result) {
                return $return;
            }
            $fetchMethod ? $return->count = count($result) : $return->count = 1;
            $return->status = true;
            $return->record = $result;
            return $return;
        }

        //JOB IMAGES DB HANDLES
        public function postSelectorSetImage($record): object
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_images;
            $wpdb->insert(
                $table,
                array(
                    'galerie_id' => $record->galerie_id,
                    'img_id' => $record->img_id,
                    'img_beschreibung' => $record->img_beschreibung,
                    'img_caption' => $record->img_caption,
                    'img_title' => $record->img_title,
                ),
                array('%d', '%d', '%s', '%s', '%s')
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

        public function postSelectorUpdateImage($record): void
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_images;
            $wpdb->update(
                $table,
                array(
                    'img_beschreibung' => $record->img_beschreibung,
                    'img_caption' => $record->img_caption,
                    'img_title' => $record->img_title,
                    'link' => $record->link,
                    'is_link' => $record->is_link,
                    'galerie_settings_aktiv' => $record->galerie_settings_aktiv,
                    'hover_aktiv' => $record->hover_aktiv,
                    'hover_title_aktiv' => $record->hover_title_aktiv,
                    'hover_beschreibung_aktiv' => $record->hover_beschreibung_aktiv,
                    'link_target' => $record->link_target
                ),
                array('id' => $record->id),
                array('%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d'),
                array('%d')
            );
        }

        public function postSelectorUpdateSortablePosition($id, $position): void
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_images;
            $wpdb->update(
                $table,
                array(
                    'position' => $position
                ),
                array('id' => $id),
                array('%d'),
                array('%d')
            );
        }

        public function PostSelectorDeleteGalerie($id): void
        {

            $args = sprintf('WHERE galerie_id=%d', $id);
            $galerie = $this->postSelectorGetImages($args);
            if ($galerie->status) {
                foreach ($galerie->record as $tmp) {
                    $this->PostSelectorDeleteImage($tmp->id);
                }
            }

            global $wpdb;
            $table = $wpdb->prefix . $this->table_galerie;
            $wpdb->delete(
                $table,
                array(
                    'id' => $id
                ),
                array('%d')
            );
        }


        public function postSelectorGetImages($args, $fetchMethod = true, $col = false): object
        {
            global $wpdb;
            $return = new stdClass();
            $return->status = false;
            $return->count = 0;
            $fetchMethod ? $fetch = 'get_results' : $fetch = 'get_row';
            $table = $wpdb->prefix . $this->table_images;
            $col ? $select = $col : $select = '*, DATE_FORMAT(created_at, \'%d.%m.%Y %H:%i:%s\') AS created';
            $result = $wpdb->$fetch("SELECT {$select}  FROM {$table} {$args}");
            if (!$result) {
                return $return;
            }
            $fetchMethod ? $return->count = count($result) : $return->count = 1;
            $return->status = true;
            $return->record = $result;
            return $return;
        }

        public function PostSelectorDeleteImage($id): void
        {
            global $wpdb;
            $table = $wpdb->prefix . $this->table_images;
            $wpdb->delete(
                $table,
                array(
                    'id' => $id
                ),
                array('%d')
            );
        }

        //WARNING JOB HELPER
        public function getGalerieTypesSelect($id = false): object
        {

            $types = [
                '0' => [
                    'id' => '',
                    'bezeichnung' => 'ausw??hlen...'
                ],
                '1' => [
                    'id' => 1,
                    'bezeichnung' => 'Slider'
                ],
                '2' => [
                    'id' => 2,
                    'bezeichnung' => 'Galerie Grid'
                ],
                '3' => [
                    'id' => 3,
                    'bezeichnung' => 'Masonry Grid'
                ]
            ];

            return apply_filters('psArrayToObject', $types);
        }

        public function postSelectorGetAnimateSelect(): object
        {
            $seekers = array("bounce", "flash", "pulse", "rubberBand", "shakeX", "headShake", "swing", "tada", "wobble", "jello", "heartBeat");
            $entrances = array("backInDown", "backInLeft", "backInRight", "backInUp");
            //$back_exits = array("backOutDown","backOutLeft","backOutRight","backOutUp");
            $bouncing = array("bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp");
            $fade = array("fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "fadeInTopLeft", "fadeInTopRight",
                "fadeInBottomLeft", "fadeInBottomRight");
            $flippers = array("flip", "flipInX", "flipInY", "flipOutX", "flipOutY");
            $lightspeed = array("lightSpeedInRight", "lightSpeedInLeft", "lightSpeedOutRight", "lightSpeedOutLeft");
            $rotating = array("rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight");
            $zooming = array("zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp");
            $sliding = array("slideInDown", "slideInLeft", "slideInRight", "slideInUp");

            $ani_arr = array();
            for ($i = 0; $i < count($seekers); $i++) {
                $ani_item = array(
                    "animate" => $seekers[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

            for ($i = 0; $i < count($entrances); $i++) {
                $ani_item = array(
                    "animate" => $entrances[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);


            for ($i = 0; $i < count($bouncing); $i++) {
                $ani_item = array(
                    "animate" => $bouncing[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

            for ($i = 0; $i < count($fade); $i++) {
                $ani_item = array(
                    "animate" => $fade[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

            for ($i = 0; $i < count($flippers); $i++) {
                $ani_item = array(
                    "animate" => $flippers[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

            for ($i = 0; $i < count($lightspeed); $i++) {
                $ani_item = array(
                    "animate" => $lightspeed[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

            for ($i = 0; $i < count($rotating); $i++) {
                $ani_item = array(
                    "animate" => $rotating[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

            for ($i = 0; $i < count($zooming); $i++) {
                $ani_item = array(
                    "animate" => $zooming[$i]
                );
                $ani_arr[] = $ani_item;
            }

            $ani_arr[] = array("value" => '-', "animate" => '----', "divider" => true);

            for ($i = 0; $i < count($sliding); $i++) {
                $ani_item = array(
                    "animate" => $sliding[$i]
                );
                $ani_arr[] = $ani_item;
            }

            return apply_filters('arrayToObject', $ani_arr);
        }

        function PostSelectFileSizeConvert(float $bytes): string
        {
            $result = '';
            $bytes = floatval($bytes);
            $arBytes = array(
                0 => array("UNIT" => "TB", "VALUE" => pow(1024, 4)),
                1 => array("UNIT" => "GB", "VALUE" => pow(1024, 3)),
                2 => array("UNIT" => "MB", "VALUE" => pow(1024, 2)),
                3 => array("UNIT" => "KB", "VALUE" => 1024),
                4 => array("UNIT" => "B", "VALUE" => 1),
            );

            foreach ($arBytes as $arItem) {
                if ($bytes >= $arItem["VALUE"]) {
                    $result = $bytes / $arItem["VALUE"];
                    $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                    break;
                }
            }
            return $result;
        }

    }//endClass
}