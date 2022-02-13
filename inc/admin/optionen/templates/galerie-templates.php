<?php


namespace Post\Galerie;
defined('ABSPATH') or die();

/**
 * POST GALERIE TEMPLATES
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */

if (!class_exists('PostGalerieTemplates')) {
    add_action('after_setup_theme', array('Post\\Galerie\\PostGalerieTemplates', 'init'), 0);

    class PostGalerieTemplates
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
            add_action('load_galerie_templates', array($this, 'loadGalerieTemplate'));
        }

        public function loadGalerieTemplate($attributes)
        {

            $args = sprintf('WHERE id=%d', $attributes['selectedGalerie']);
            $galerie = apply_filters('post_selector_get_galerie', $args, false);
            if (!$galerie->status) {
                return null;
            }

            $galerieSettings = $galerie->record;
            $args = sprintf('WHERE galerie_id=%d ORDER BY position ASC', $galerieSettings->id);
            $images = apply_filters('post_selector_get_images', $args);
            if (!$images->status) {
                return null;
            }
            isset($attributes['className']) ? $customCss = $attributes['className'] : $customCss = '';

            $typeSettings = json_decode($galerieSettings->type_settings);
            switch ($galerieSettings->type) {
                case '1':
                    $args = sprintf('WHERE id=%d', $typeSettings->slider_id);
                    $slider = apply_filters('post_selector_get_by_args', $args, false);
                    if (!$slider->status) {
                        return null;
                    }
                    $rand = apply_filters('get_ps_generate_random_id', 12, 0);
                    $settings = $slider->record->data;
                    $html = $this->render_galerie_slider_template($galerieSettings, $typeSettings, $images->record, $images->count, $attributes);
                    $settings->arrows && $images->count > 0 ? $arrows = '' : $arrows = 'd-none';
                    $settings->label ? $padding = 'style="padding-bottom:2.5rem!important"' : $padding = '';
                    $settings->label ? $arrow_bt = 'style="margin-top:-1.25rem"' : $arrow_bt = '';
                    ?>
                    <div class="wp-block-hupa-theme-post-list <?= $customCss ?>">
                        <?= $galerieSettings->show_bezeichnung ? '<h3 class="post-galerie-h3">' . $galerieSettings->bezeichnung . '</h3>' : '' ?>
                        <?= $galerieSettings->show_beschreibung ? '<small class="post-small-description">' . $galerieSettings->beschreibung . '</small>' : '' ?>
                        <div data-id="<?= $typeSettings->slider_id ?>" data-rand="<?= $rand ?>"
                             class="splide splide<?= $rand ?>">
                            <div class="splide__arrows <?= $arrows ?>">
                                <button class="splide__arrow splide__arrow--prev" <?= $arrow_bt ?>>
                                    <i class="fa fa-angle-left"></i>
                                </button>
                                <button class="splide__arrow splide__arrow--next" <?= $arrow_bt ?>>
                                    <i class="fa fa-angle-right"></i>
                                </button>
                            </div>
                            <div class="splide__track" <?= $padding ?>>
                                <div class="splide__list <?= $galerieSettings->lightbox_aktiv ? 'light-box-controls' : '' ?>">
                                    <?= $html ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '2':
                    $html = $this->render_galerie_slider_template($galerieSettings, $typeSettings, $images->record, $images->count, $attributes);
                    $ts = $typeSettings;
                    $ts->xs_grid_column ? $xs_grid_column = $ts->xs_grid_column : $xs_grid_column = 5;
                    $ts->sm_grid_column ? $sm_grid_column = $ts->sm_grid_column : $sm_grid_column = 4;
                    $ts->md_grid_column ? $md_grid_column = $ts->md_grid_column : $md_grid_column = 3;
                    $ts->lg_grid_column ? $lg_grid_column = $ts->lg_grid_column : $lg_grid_column = 2;
                    $ts->xl_grid_column ? $xl_grid_column = $ts->xl_grid_column : $xl_grid_column = 1;

                    $ts->xs_grid_gutter ? $xs_grid_gutter = $ts->xs_grid_gutter : $xs_grid_gutter = 1;
                    $ts->sm_grid_gutter ? $sm_grid_gutter = $ts->sm_grid_gutter : $sm_grid_gutter = 1;
                    $ts->md_grid_gutter ? $md_grid_gutter = $ts->md_grid_gutter : $md_grid_gutter = 1;
                    $ts->lg_grid_gutter ? $lg_grid_gutter = $ts->lg_grid_gutter : $lg_grid_gutter = 1;
                    $ts->xl_grid_gutter ? $xl_grid_gutter = $ts->xl_grid_gutter : $xl_grid_gutter = 1;
                    ?>
                    <div class="wp-block-hupa-theme-post-list grid-wrapper <?= $customCss ?>">
                        <?= $galerieSettings->show_bezeichnung ? '<h3 class="post-galerie-h3">' . $galerieSettings->bezeichnung . '</h3>' : '' ?>
                        <?= $galerieSettings->show_beschreibung ? '<small class="post-small-description">' . $galerieSettings->beschreibung . '</small>' : '' ?>

                        <div class="<?= $galerieSettings->lightbox_aktiv ? 'light-box-controls' : '' ?>">

                            <div class="post-selector-grid-gutter mb-3">
                                <?php
                                $grid_cols = '<div class="row
                                        row-cols-' . $xs_grid_column . '
                                        row-cols-sm-' . $sm_grid_column . '
                                        row-cols-md-' . $md_grid_column . '
                                        row-cols-lg-' . $lg_grid_column . '
                                        row-cols-xl-' . $xl_grid_column . '
                                        g-' . $xs_grid_gutter . '
                                        g-sm-' . $sm_grid_gutter . '
                                        g-md-' . $md_grid_gutter . '
                                        g-lg-' . $lg_grid_gutter . '
                                        g-xl-' . $xl_grid_gutter . '">';
                                $grid_cols = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $grid_cols));
                                $html = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $html));
                                echo $grid_cols . $html; ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php
                    break;
                case'3':

                    $html = $this->render_galerie_slider_template($galerieSettings, $typeSettings, $images->record, $images->count, $attributes);
                    $ts = $typeSettings;

                    $ts->xs_column ? $xs_column = $ts->xs_column : $xs_column = 6;
                    $ts->sm_column ? $sm_column = $ts->sm_column : $sm_column = 5;
                    $ts->md_column ? $md_column = $ts->md_column : $md_column = 4;
                    $ts->lg_column ? $lg_column = $ts->lg_column : $lg_column = 3;
                    $ts->xl_column ? $xl_column = $ts->xl_column : $xl_column = 2;

                    $ts->xs_gutter ? $xs_gutter = $ts->xs_gutter : $xs_gutter = 1;
                    $ts->sm_gutter ? $sm_gutter = $ts->sm_gutter : $sm_gutter = 1;
                    $ts->md_gutter ? $md_gutter = $ts->md_gutter : $md_gutter = 1;
                    $ts->lg_gutter ? $lg_gutter = $ts->lg_gutter : $lg_gutter = 1;
                    $ts->xl_gutter ? $xl_gutter = $ts->xl_gutter : $xl_gutter = 1;
                    ?>

                    <div class="wp-block-hupa-theme-post-list masonry-grid-wrapper <?= $customCss ?>">
                        <?= $galerieSettings->show_bezeichnung ? '<h3 class="post-galerie-h3">' . $galerieSettings->bezeichnung . '</h3>' : '' ?>
                        <?= $galerieSettings->show_beschreibung ? '<small class="post-small-description">' . $galerieSettings->beschreibung . '</small>' : '' ?>
                        <div class="<?= $galerieSettings->lightbox_aktiv ? 'light-box-controls' : '' ?>">
                            <div class="post-selector-grid mb-3">
                                <?php
                                $grid_cols = '<div class="row
                                        row-cols-' . $xs_column . '
                                        row-cols-sm-' . $sm_column . '
                                        row-cols-md-' . $md_column . '
                                        row-cols-lg-' . $lg_column . '
                                        row-cols-xl-' . $xl_column . '
                                        g-' . $xs_gutter . '
                                        g-sm-' . $sm_gutter . '
                                        g-md-' . $md_gutter . '
                                        g-lg-' . $lg_gutter . '
                                        g-xl-' . $xl_gutter . '">';

                                $grid_cols = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $grid_cols));
                                $html = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $html));
                                echo $grid_cols . $html; ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php
                    break;
            }
        }

        private function render_galerie_slider_template($galerieSettings, $typeSettings, $images, $count, $attributes): string
        {
            $attr = (object)$attributes;
            $html = '';

            foreach ($images as $tmp):
                $link = $this->get_galerie_vs_image_settings($galerieSettings, $tmp, 'link');
                $is_link = $this->get_galerie_vs_image_settings($galerieSettings, $tmp, 'is_link');
                $hover_aktiv = $this->get_galerie_vs_image_settings($galerieSettings, $tmp, 'hover_aktiv');
                $hover_title_aktiv = $this->get_galerie_vs_image_settings($galerieSettings, $tmp, 'hover_title_aktiv');
                $hover_beschreibung_aktiv = $this->get_galerie_vs_image_settings($galerieSettings, $tmp, 'hover_beschreibung_aktiv');
                $link_target = $this->get_galerie_vs_image_settings($galerieSettings, $tmp, 'link_target');


                $lightbox_aktiv = $galerieSettings->lightbox_aktiv;
                $caption_aktiv = $galerieSettings->caption_aktiv;


                if (isset($attr->hoverBGColor) && isset($attr->TextColor)) {
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

                $hover_aktiv ? $hover_none = '' : $hover_none = ' d-none';
                $hover_title_aktiv ? $title = $tmp->img_title : $title = '';
                $hover_beschreibung_aktiv ? $img_beschreibung = $tmp->img_beschreibung : $img_beschreibung = '';
                $caption_aktiv ? $caption = $tmp->img_caption : $caption = '';
                $caption_aktiv ? $caption_none = '' : $caption_none = ' d-none';
                $link_target ? $target = 'target="_blank"' : $target = '';
                $brokenImg = POST_SELECT_PLUGIN_URL . '/inc/assets/images/img-broken.svg';
                if (!$tmp->img_id) {
                    $img_src[0] = $brokenImg;
                    $img_full[0] = $brokenImg;
                } else {
                    $img_src = wp_get_attachment_image_src($tmp->img_id, $typeSettings->img_size, false);
                    $img_full = wp_get_attachment_image_src($tmp->img_id, 'full', false);
                }
                if ($is_link) {
                    global $post;
                    $wpPage = explode('#', $link);
                    $post = get_post($wpPage[1]);
                    setup_postdata($post);
                    $link = get_permalink();
                }
                if ($galerieSettings->type == '1') {
                    $control = 'data-control="single"';
                } else {
                    $control = 'data-control="control"';
                }

                $lightbox_start = '';
                $lightbox_end = '';
                $lightbox_none = '';
                $data_control = '';

                if (!$hover_aktiv && $lightbox_aktiv) {
                    $lightbox_start = '<a ' . $control . ' class="img-link slider-href-link" title="' . $title . '" href="' . $img_full[0] . '">';
                    $lightbox_end = '</a>';
                }
                if ($hover_aktiv && $lightbox_aktiv) {
                    $lightbox_start = '';
                    $lightbox_end = '';
                    $lightbox_none = '';
                    $data_control = $control;
                }

                if ($hover_aktiv && !$lightbox_aktiv) {
                    $lightbox_none = ' d-none';
                }

                if (!$hover_aktiv && $lightbox_aktiv && $link || !$hover_aktiv && !$lightbox_aktiv && $link) {
                    $lightbox_start = '<a '. $target . ' class="slider-href-link" title="' . $title . '" href="' . $link . '">';
                    $lightbox_end = '</a>';
                }

                if ($link) {
                    $btnShowLink = '';
                } else {
                    $btnShowLink = ' d-none';
                }
                $attachment = apply_filters('post_selector_wp_get_attachment', $tmp->img_id);

                $caption ?: $caption_none = 'd-none';
                $img_link = 'img-link';
                if (!$hover_aktiv) {
                    $img_link = '';
                }

                $lazy_load_aktiv = '"';
                if ($galerieSettings->lazy_load_aktiv) {
                    $galerieSettings->animate_select ? $animate_select = $galerieSettings->animate_select : $animate_select = 'fadeInUp';
                    $aniRand = mt_rand(50, 450);
                    $aniOffset = mt_rand(50, 90);
                    $aniDuration = mt_rand(350, 1000);
                    $galerieSettings->lazy_load_ani_aktiv ? $ani = 'wow animate__' . $animate_select . '" data-wow-offset="50" data-wow-duration="' . $aniDuration . 'ms" data-wow-delay="' . $aniRand . 'ms"' : $ani = '"';
                    $lazy_load_aktiv = ' lazy-image ' . $ani . '';
                }

                isset($attr->hoverBGColor) ? $bgHoverStyle = 'style="background-color:' . $attr->hoverBGColor . '"' : $bgHoverStyle = '';
                if ($galerieSettings->type == '1') {
                    $html .= '
                     <div class="splide__slide">
                        ' . $lightbox_start . '
                        <img class="splide-img" alt="' . $attachment['alt'] . '"
                             data-splide-lazy="' . $img_src[0] . '" src="' . $img_src[0] . '"/>
                        ' . $lightbox_end . '
                        <div class="slide-hover' . $hover_none . '" ' . $bgStyle . '>
                            <div class="hover-wrapper">
                                <div class="hover-headline">' . $title . '</div>
                                <div class="post-excerpt">
                                    ' . $img_beschreibung . '
                                </div>
                                <div class="hover-button mt-auto" '.$bgHoverStyle.'>
                                    <a title="' . $title . '" ' . $data_control . ' href="' . $img_full[0] . '" class="' . $img_link . ' btn-grid-hover btn-img' . $lightbox_none . '" ' . $btnOut . '></a>
                                    <a '.$target. ' href="' . $link . '" class="btn-grid-hover btn-link' . $btnShowLink . '" title="' . $link . '" ' . $btnOut . '></a>
                                </div>
                            </div>
                          </div>
                        <div class="splide-label' . $caption_none . '">
                            ' . $caption . '
                        </div>
                     </div>';
                }// GALERIE 1

                if ($galerieSettings->type == '2') {
                    isset($typeSettings->crop) ? $height = $typeSettings->img_width : $height = $typeSettings->img_height;
                    $style = 'style="
                    width:' . $typeSettings->img_width . 'px;
                    height:' . $height . 'px;
                    "';

                    $html .= '<div class="col grid-gutter">
                             ' . $lightbox_start . '
                              <img class="grid-gutter-image rounded' . $lazy_load_aktiv . '  alt="' . $attachment['alt'] . '" src="' . $img_src[0] . '" data-src="' . $img_src[0] . '" ' . $style . '>              
                            ' . $lightbox_end . '
                            <div class="rounded grid-hover' . $hover_none . '" ' . $bgStyle . '>
                             <div class="hover-wrapper">
                                <div class="hover-headline">' . $title . '</div>
                                <div class="post-excerpt">
                                    ' . $img_beschreibung . '
                                </div>
                                <div class="hover-button mt-auto" '.$bgHoverStyle.'>
                                    <a title="' . $title . '" ' . $data_control . ' href="' . $img_full[0] . '" class="' . $img_link . ' btn-grid-hover btn-img' . $lightbox_none . '" ' . $btnOut . '></a>
                                    <a ' . $target . ' href="' . $link . '" class="btn-grid-hover btn-link' . $btnShowLink . '" title="' . $link . '" ' . $btnOut . '></a>
                                 </div>
                             </div>
                            </div>
                            <div class="grid-caption ' . $caption_none . '">
                              ' . $caption . '
                            </div>
                          </div>';
                }
                if ($galerieSettings->type == '3') {
                    $html .= '<div class="col grid-item">
                             ' . $lightbox_start . '
                              <img class="rounded masonry-grid-class' . $lazy_load_aktiv . '  alt="' . $attachment['alt'] . '" src="' . $img_src[0] . '"  data-src="' . $img_src[0] . '">              
                            ' . $lightbox_end . '
                            <div class="rounded grid-hover' . $hover_none . '" ' . $bgStyle . '>
                             <div class="hover-wrapper">
                                <div class="hover-headline">' . $title . '</div>
                                <div class="post-excerpt">
                                    ' . $img_beschreibung . '
                                </div>
                                <div class="hover-button mt-auto" '.$bgHoverStyle.'>
                                    <a title="' . $title . '" ' . $data_control . ' href="' . $img_full[0] . '" class="' . $img_link . ' btn-grid-hover btn-img' . $lightbox_none . '" ' . $btnOut . '></a>
                                    <a ' . $target . ' href="' . $link . '" class="btn-grid-hover btn-link' . $btnShowLink . '" title="' . $link . '" ' . $btnOut . '></a>
                                 </div>  
                             </div>
                            </div>
                          </div>';
                }
            endforeach; ?>
            <?php
            return $html;
        }

        private function get_galerie_vs_image_settings($galSettings, $imgSettings, $type)
        {
            if ($imgSettings->galerie_settings_aktiv) {
                $return = $galSettings->$type;
            } else {
                $return = $imgSettings->$type;
            }
            return $return;
        }
    }
}