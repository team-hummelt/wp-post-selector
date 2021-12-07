<?php


namespace Post\News;

defined('ABSPATH') or die();

/**
 * POST NEWS TEMPLATE
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */

if (!class_exists('PostNewsTemplates')) {
    add_action('after_setup_theme', array('Post\\News\\PostNewsTemplates', 'init'), 0);

    class PostNewsTemplates
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
            add_action('load_news_template', array($this, 'loadNewsTemplate'), 10, 2);
        }

        public function loadNewsTemplate($data, $attr)
        {

            $attr->imageCheckActive ? $ifImage = true : $ifImage = false;
            if (isset($attr->lightBoxActive) && $attr->lightBoxActive) {
                $dataGallery = 'data-control="single"';
                $imgLink = 'img-link ';
                $imgWrapper = 'light-box-controls';
            } else {
                $dataGallery = '';
                $imgLink = '';
                $imgWrapper = '';
            }
            $newsTemplate = 2;
            isset($attr->className) && $attr->className ? $className = $attr->className : $className = '';
            ?>
            <div class="wp-block-hupa-theme-post-list d-flex flex-wrap align-items-stretch py-3">
                <?php foreach ($data as $tmp):
                    $tmp->excerpt ? $excerpt = $tmp->excerpt : $excerpt = $tmp->page_excerpt;
                    if ($attr->radioMedienLink == 2) {
                        $src = $tmp->href;
                    } else {
                        $src = wp_get_attachment_image_src($tmp->img_id, 'large', false);
                        $src = $src[0];
                    }
                    $attr->titleCheckActive ? $titleNone = '' : $titleNone = 'd-none ';
                    $attr->linkCheckActive ? $linkNone = '' : $linkNone = 'd-none ';

                    //JOB WARNING NEWS TEMPLATE 1
                    if ($newsTemplate == 1) :
                        if ($tmp->img_id && $ifImage) {
                            $lazyImg = get_the_post_thumbnail($tmp->post_id, 'post-cover-img-large', array('title' => $tmp->title));
                            $lazyImg = preg_replace( '@(width.+height.+?".+?")@i', "", $lazyImg );
                            $hideImg = '';
                            $imgSrc = wp_get_attachment_image_src($tmp->img_id, 'large', false);
                        } else {
                            $hideImg = 'd-none';
                            $lazyImg = '';
                        }

                        ?>
                        <div class="<?= $className ?> col-12 p-2">
                            <div class="news-wrapper d-flex overflow-hidden position-relative h-100 w-100">
                                <div class="p-4 d-flex flex-column">
                                    <strong class="post-news-kategorie d-block mb-2  text-muted">
                                        <?php $x = 1;
                                        $category = get_the_category($tmp->post_id);
                                        foreach ($category as $cat):
                                            count($category) > $x  ? $bull = ' <div class="vr mx-1"></div> ' : $bull = '';
                                            echo sprintf('<a  class="text-decoration-none link-secondary" href="%s">%s</a>', get_category_link($cat), $cat->name) . $bull;
                                            $x++;
                                            ?>
                                        <?php endforeach; ?>
                                    </strong>
                                    <h4 class="<?= $titleNone ?>mb-0 lh-1"><?= $tmp->title ?></h4>
                                    <div class="mb-1 text-muted"><?= $tmp->date ?></div>
                                    <p class="card-text mb-auto"><?= $excerpt ?></p>
                                    <span>
                            <a href="<?= $tmp->permalink ?>"
                               class="<?= $linkNone ?>text-decoration-none">weiterlesen...</a>
                           </span>
                                </div>
                                <div class="<?= $imgWrapper ?> col-auto d-none d-lg-block ms-auto <?= $hideImg ?>">
                                    <?php if ($dataGallery || $attr->radioMedienLink == 2 || $ifImage): ?>
                                        <a class="<?= $imgLink ?>" title="<?= $tmp->title ?>" <?= $dataGallery ?>
                                           href="<?= $src ?>">
                                            <?= $lazyImg ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                    //JOB WARNING NEWS TEMPLATE 2
                    if ($newsTemplate == 2):
                        if ($tmp->img_id && $ifImage) {

                            $lazyImg = get_the_post_thumbnail($tmp->post_id, 'card-img-top-large', array('title' => $tmp->title));
                            $lazyImg = preg_replace( '@(width.+height.+?".+?")@i', "", $lazyImg );
                            $hideImg = '';
                            $imgSrc = wp_get_attachment_image_src($tmp->img_id, 'large', false);
                        } else {
                            $hideImg = 'd-none';
                            $lazyImg = '';
                        }
                        ?>
                        <div class="<?= $className ?> card mb-3">
                            <div class="<?= $imgWrapper ?> <?= $hideImg ?>">
                                <?php if ($dataGallery || $attr->radioMedienLink == 2 || $ifImage): ?>
                                    <a class="<?= $imgLink ?>" title="<?= $tmp->title ?>" <?= $dataGallery ?>
                                       href="<?= $src ?>">
                                        <?= $lazyImg ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <strong class="d-inline-block mb-2 text-muted">
                                    <?php $x = 1;
                                    $category = get_the_category($tmp->post_id);
                                    foreach ($category as $cat):
                                        count($category) > $x  ? $bull = ' <div class="vr mx-1"></div> ' : $bull = '';
                                        echo sprintf('<a  class="text-decoration-none link-secondary" href="%s">%s</a>', get_category_link($cat), $cat->name) . $bull;
                                        $x++;
                                        ?>
                                    <?php endforeach; ?>
                                </strong>
                                <h4 class="<?= $titleNone?> mb-0 "><?= $tmp->title ?></h4>
                                <div class="mb-2 text-muted"><?= $tmp->date ?></div>
                                <p class="card-text"><?= $excerpt ?></p>
                                <p class="card-text"><span class="text-muted">
                                        <a href="<?= $tmp->permalink ?>"
                                           class="<?= $linkNone ?>text-decoration-none">weiterlesen...</a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
            <?php
        }
    }
}