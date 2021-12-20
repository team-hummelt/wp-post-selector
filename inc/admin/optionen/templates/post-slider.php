<?php


namespace Post\Slider;

use stdClass;

defined('ABSPATH') or die();

/**
 * POST SLIDER SHORTCODE
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */

if (!class_exists('PostSliderTemplates')) {
    add_action('after_setup_theme', array('Post\\Slider\\PostSliderTemplates', 'init'), 0);

    class PostSliderTemplates
    {
        //INSTANCE
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
            add_action('load_slider_template', array($this, 'loadSliderTemplate'), 10, 2);
        }

        public function loadSliderTemplate($data, $attr)
        {
            $args = sprintf('WHERE id=%d', $attr->selectedSlider);
            $slider = apply_filters('post_selector_get_by_args', $args, false);
            if (!$slider->status) {
                return null;
            }


            $settings = $slider->record->data;
            //print_r($settings);
            isset($settings->select_design_option) && $settings->select_design_option ? $select_design_option = $settings->select_design_option : $select_design_option = 0;
            switch ($select_design_option) {
                case '0':
                    $this->render_splide_template($settings, $attr, $data);
                    break;
                case '1':
                    $this->splide_erweitertes_template($settings, $attr, $data);
                    break;
            }
        }

        private function render_splide_template($settings, $attr, $data)
        {

            $rand = apply_filters('get_ps_generate_random_id', 12, 0);

            if (isset($attr->hoverBGColor) && $attr->hoverBGColor && isset($attr->TextColor) && $attr->TextColor) {
                $bGColor = $attr->hoverBGColor . 'd9';
                $textColor = $attr->TextColor . 'ff';
                $btnBGHover = $attr->TextColor;

                $bgStyle = 'style=
                          "color: ' . $textColor . ';
                          background-color: ' . $bGColor . ';"';

                $bgStyle = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $bgStyle));
                $btnStyle = 'style=
                          "color: ' . $btnBGHover . ';
                           background-color: ' . $attr->hoverBGColor . '00;
                           font-weight:normal;
                           font-style:normal;
                           border-color: ' . $attr->TextColor . '33;"';

                $onMouseBgHover = 'onmouseover="this.style.background=\'' . $attr->TextColor . '\';';
                $onMouseBgHover .= 'this.style.color=\'' . $attr->hoverBGColor . '\';';
                $onMouseBgHover .= 'this.style.borderColor=\'' . $attr->hoverBGColor . '\';"';
                $onMouseBgOut = 'onmouseout="this.style.background=\'' . $attr->hoverBGColor . '00' . '\';';
                $onMouseBgOut .= 'this.style.borderColor=\'' . $textColor . '33' . '\';';
                $onMouseBgOut .= 'this.style.color=\'' . $textColor . '\';"';

                $btnOut = $btnStyle . $onMouseBgHover . $onMouseBgOut;
                $btnOut = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $btnOut));
            } else {
                $btnOut = '';
                $bgStyle = '';
            }

            $count = count((array)$data);
            isset($settings->arrows) && $count > 0 ? $arrows = '' : $arrows = 'd-none';
            isset($settings->label) ? $padding = 'style="padding-bottom:2.5rem!important"' : $padding = '';
            isset($settings->label) ? $arrow_bt = 'style="margin-top:-1.25rem"' : $arrow_bt = '';
            isset($settings->img_link_aktiv) && $settings->img_link_aktiv ? $img_link_aktiv = true : $img_link_aktiv = false;


            isset($attr->className) ? $customCss = $attr->className : $customCss = '';
            isset($attr->lightBoxActive) && $attr->lightBoxActive ? $lightBoxActive = $attr->lightBoxActive : $lightBoxActive = '';
            isset($attr->radioMedienLink) && $attr->radioMedienLink ? $radioMedienLink = $attr->radioMedienLink : $radioMedienLink = '';

            ?>
            <div class="wp-block-hupa-theme-post-list <?= $customCss ?>">
                <div data-id="<?= $attr->selectedSlider ?>" data-rand="<?= $rand ?>" class="splide splide<?= $rand ?>">
                    <div class="splide__arrows <?= $arrows ?>">
                        <button class="splide__arrow splide__arrow--prev" <?= $arrow_bt ?>>
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="splide__arrow splide__arrow--next" <?= $arrow_bt ?>>
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                    <div class="splide__track" <?= $padding ?>>
                        <div class="splide__list <?= $lightBoxActive ? 'light-box-controls' : '' ?>">
                            <?php foreach ($data as $tmp):
                                isset($settings->img_size) ? $imgSize = $settings->img_size : $imgSize = '';
                                $img_src_url = wp_get_attachment_image_src($tmp->img_id, $imgSize, false);
                                $img_full_url = wp_get_attachment_image_src($tmp->img_id, 'full', false);
                                if ($radioMedienLink == 2) {
                                    $src = $tmp->href;
                                } else {
                                    $src = $img_full_url[0];
                                }
                                if (isset($attr->linkCheckActive) && $attr->linkCheckActive) {
                                    $btnShowLink = '';
                                } else {
                                    $btnShowLink = 'd-none';
                                }
                                if (isset($attr->titleCheckActive) && $attr->titleCheckActive) {
                                    $title = $tmp->title;
                                } else {
                                    $title = '';
                                }
                                if (!$tmp->excerpt) {
                                    $excerpt = $tmp->page_excerpt;
                                } else {
                                    $excerpt = $tmp->excerpt;
                                }

                                if ($img_link_aktiv) {
                                    $imgLinkStart = '<a data-control="single" class="d-block w-100 h-100 img-link" href="' . $src . '">';
                                    $ingLinkEnd = '</a>';
                                } else {
                                    $imgLinkStart = '';
                                    $ingLinkEnd = '';
                                }
                                ?>
                                <div class="splide__slide">
                                    <?= $imgLinkStart ?><img class="splide-img" alt="<?= $tmp->alt ?>"
                                                             data-splide-lazy="<?= $img_src_url[0] ?>"
                                                             src="<?= $img_src_url[0] ?>"/><?= $ingLinkEnd ?>
                                    <div class="slide-hover <?= $settings->hover ? '' : 'd-none' ?>"<?= $bgStyle ?>>
                                        <div class="hover-wrapper">
                                            <div class="hover-headline"><?= $title ?></div>
                                            <div class="post-excerpt">
                                                <?php if ($settings->textauszug): ?>
                                                    <?= $excerpt ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                            isset($attr->hoverBGColor) && $attr->hoverBGColor ? $bgColor = 'style="background-color:' . $attr->hoverBGColor . '"' : $bgColor = '';
                                            ?>
                                            <div class="hover-button mt-auto" <?= $bgColor ?>>
                                                <a data-control="single" title="<?= $title ?>"
                                                   href="<?= $img_full_url[0] ?>"
                                                   class="img-link btn-grid-hover btn-img" <?= $btnOut ?>></a>
                                                <a href="<?= $tmp->permalink ?>"
                                                   class="btn-grid-hover btn-link <?= $btnShowLink ?>"
                                                   title="Link zum Beitrag" <?= $btnOut ?>> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($settings->label): ?>
                                        <div class="splide-label">
                                            <?= $tmp->captions ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        private function splide_erweitertes_template($settings, $attr, $data)
        {
            $rand = apply_filters('get_ps_generate_random_id', 12, 0);
            $count = count((array)$data);
            isset($settings->arrows) && $count > 0 ? $arrows = '' : $arrows = 'd-none';
            isset($settings->img_link_aktiv) && $settings->img_link_aktiv ? $img_link_aktiv = true : $img_link_aktiv = false;

            //JOB Button Optionen
            //Button aktiv
            isset($settings->design_btn_aktiv) && $settings->design_btn_aktiv ? $design_btn_aktiv = true : $design_btn_aktiv = false;
            isset($settings->select_design_btn_link) && $settings->select_design_btn_link ? $select_design_btn_link = $settings->select_design_btn_link : $select_design_btn_link = 1;

            //Button Text | CSS
            isset($settings->design_btn_txt) && $settings->design_btn_txt ? $design_btn_txt = $settings->design_btn_txt : $design_btn_txt = 'zum Beitrag';
            isset($settings->design_btn_css) && $settings->design_btn_css ? $design_btn_css = $settings->design_btn_css : $design_btn_css = '';
            $design_btn_css ? $btnCss = 'ps-one-design btn ' . $design_btn_css : $btnCss = 'ps-one-design btn btn-outline-secondary';

            //Title Tag
            isset($settings->select_title_tag) && $settings->select_title_tag ? $select_title_tag = $settings->select_title_tag : $select_title_tag = 1;
            isset($settings->design_link_tag_txt) && $settings->design_link_tag_txt ? $design_link_tag_txt = $settings->design_link_tag_txt : $design_link_tag_txt = 'zum Beitrag';

            //JOB TEXT Optionen
            //Aktiv
            isset($settings->design_text_aktiv) && $settings->design_text_aktiv ? $design_text_aktiv = true : $design_text_aktiv = false;
            isset($settings->select_design_text) && $settings->select_design_text ? $select_design_text = $settings->select_design_text : $select_design_text = 1;
            // Text CSS
            isset($settings->design_titel_css) && $settings->design_titel_css ? $design_titel_css = $settings->design_titel_css : $design_titel_css = '';
            isset($settings->design_auszug_css) && $settings->design_auszug_css ? $design_auszug_css = $settings->design_auszug_css : $design_auszug_css = '';

            //JOB Container Height
            isset($settings->design_container_height) && $settings->design_container_height ? $design_container_height = $settings->design_container_height : $design_container_height = '';
            isset($settings->inner_container_height) && $settings->inner_container_height ? $inner_container_height = $settings->inner_container_height : $inner_container_height = '';

            $showTitle = false;
            $showExcerpt = false;
            switch ($select_design_text) {
                case '1':
                    if ($design_text_aktiv) {
                        $showTitle = true;
                        $showExcerpt = false;
                    }
                    break;
                case '2':
                    if ($design_text_aktiv) {
                        $showTitle = false;
                        $showExcerpt = true;
                    }
                    break;
                case '3':
                    if ($design_text_aktiv) {
                        $showTitle = true;
                        $showExcerpt = true;
                    }
                    break;
            }


            // JOB Attributes
            //Wrapper Extra Css
            isset($attr->className) ? $customCss = $attr->className : $customCss = '';
            isset($attr->lightBoxActive) && $attr->lightBoxActive ? $lightBoxActive = $attr->lightBoxActive : $lightBoxActive = '';
            isset($attr->radioMedienLink) && $attr->radioMedienLink ? $radioMedienLink = $attr->radioMedienLink : $radioMedienLink = '';


            //TODO Template
            ?>
            <div class="wp-block-hupa-theme-post-list post-custom-template-one <?= $customCss ?>" style="height: <?=$design_container_height?>">
                <div data-id="<?= $attr->selectedSlider ?>" data-rand="<?= $rand ?>" class="splide splide<?= $rand ?>">
                    <div class="splide__arrows <?= $arrows ?>">
                        <button class="splide__arrow splide__arrow--prev">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="splide__arrow splide__arrow--next">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>

                    <div class="splide__track track-wrapper">
                        <div class="splide__list list-wrapper light-box-controls">
                            <?php foreach ($data as $tmp):
                                switch ($select_title_tag) {
                                    case '1':
                                        $titleTag = $tmp->title;
                                        break;
                                    case '2':
                                        $titleTag = $design_link_tag_txt;
                                        break;
                                    default:
                                        $titleTag = $tmp->title;
                                }

                                isset($settings->img_size) ? $imgSize = $settings->img_size : $imgSize = '';
                                $img_src_url = wp_get_attachment_image_src($tmp->img_id, $imgSize, false);
                                $img_full_url = wp_get_attachment_image_src($tmp->img_id, 'full', false);
                                if ($radioMedienLink == 2) {
                                    $src = $tmp->href;
                                } else {
                                    $src = $img_full_url[0];
                                }
                                if ($img_link_aktiv) {
                                    $lightBoxActive ? $dataLight = 'data-control="single"' : $dataLight = '';
                                    $imgLinkStart = '<a '.$dataLight.' title="' . $titleTag . '" class="d-block w-100 h-100 img-link" href="' . $src . '">';
                                    $ingLinkEnd = '</a>';
                                } else {
                                    $imgLinkStart = '<span class="d-block w-100 h-100 img-link">';
                                    $ingLinkEnd = '</span>';
                                }

                                $btnLink = '<a title="' . $titleTag . '" class="'.$btnCss.'" href="' . $tmp->permalink . '" target="_blank">'.$design_btn_txt.'</a>';
                                switch ($select_design_btn_link){
                                    case '1':
                                        $btnLink = '<a data-control="single" title="' . $titleTag . '" class="'.$btnCss.'" href="' . $img_full_url[0] . '">'.$design_btn_txt.'</a>';
                                        break;
                                    case '2':
                                        $btnLink = '<a title="' . $titleTag . '" class="'.$btnCss.'" href="' . $tmp->permalink . '" target="_blank">'.$design_btn_txt.'</a>';
                                        break;
                                    case '3':
                                        $btnLink = '<a title="' . $titleTag . '" class="'.$btnCss.'" href="' . $tmp->href . '" target="_blank">'.$design_btn_txt.'</a>';
                                        break;
                                    case '4':
                                        $customUrl = get_post_meta($tmp->post_id, '_hupa_show_custom_url', true);
                                        $url =get_post_meta($tmp->post_id, '_hupa_beitragsbild_url', true);
                                        if(isset($customUrl) && $customUrl){
                                            isset($url) && $url ? $link = $url : $link = $tmp->permalink;
                                            $btnLink = '<a title="' . $titleTag . '" class="'.$btnCss.'" href="' . $link . '" target="_blank">'.$design_btn_txt.'</a>';
                                        }
                                        break;
                                }
                                ?>
                                <div class="splide__slide position-relative">
                                    <?= $imgLinkStart ?><img class="splide-img" alt="<?= $tmp->alt ?>"
                                                             data-splide-lazy="<?= $img_src_url[0] ?>"
                                                             src="<?= $img_src_url[0] ?>"/><?= $ingLinkEnd ?>

                                    <div class="bottom-wrapper">
                                        <div class="one-wrapper-inner" style="height: <?=$inner_container_height?>">
                                            <div class="splide-custom-one-title <?= $design_titel_css ?>">
                                                <?= $showTitle ? $tmp->title : '' ?>
                                            </div>
                                            <div class="splide-custom-one-excerpt <?= $design_auszug_css ?>">
                                                <?= $showExcerpt ? $tmp->excerpt : '' ?>
                                            </div>
                                        </div>
                                        <div class="custom-one-button">
                                            <?php if ($design_btn_aktiv): ?>
                                                <?=$btnLink?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div><!--splide__splide-->
                            <?php endforeach; ?>
                        </div><!--list-->
                    </div><!--track-->
                </div><!--splide-->
            </div><!--wrapper-->
            <?php
        }
    }
}