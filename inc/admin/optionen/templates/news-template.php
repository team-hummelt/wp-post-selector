<?php


namespace Post\News;

defined( 'ABSPATH' ) or die();

/**
 * POST NEWS TEMPLATE
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 */

if ( ! class_exists( 'PostNewsTemplates' ) ) {
    add_action( 'after_setup_theme', array( 'Post\\News\\PostNewsTemplates', 'init' ), 0 );

    class PostNewsTemplates {
        //INSTANCE
        private static $instance;

        /**
         * @return static
         */
        public static function init(): self {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        public function __construct() {
            add_action( 'load_news_template', array( $this, 'loadNewsTemplate' ), 10, 2 );
        }

        public function loadNewsTemplate( $data, $attr ) {

            isset($attr->imageCheckActive) && $attr->imageCheckActive  ? $ifImage = true : $ifImage = false;
            if ( isset( $attr->lightBoxActive ) && $attr->lightBoxActive ) {
                $dataGallery = 'data-control="single"';
                $imgLink     = 'img-link ';
                $imgWrapper  = 'light-box-controls';
            } else {
                $dataGallery = '';
                $imgLink     = '';
                $imgWrapper  = '';
            }


            isset( $attr->className ) && $attr->className ? $className = $attr->className : $className = '';
            isset( $attr->kategorieShowActive ) && $attr->kategorieShowActive ? $kategorieShowActive = '' : $kategorieShowActive = 'd-none';
            isset( $attr->authorShowActive ) && $attr->authorShowActive ? $authorShowActive = true : $authorShowActive = false;
            isset( $attr->datumShowActive ) && $attr->datumShowActive ? $datumShowActive = true : $datumShowActive = false;
            isset( $attr->urlNewTabActive ) && $attr->urlNewTabActive ? $urlNewTabActive = ' target="_blank"' : $urlNewTabActive = 'd-none';
            isset( $attr->linkCheckActive ) && $attr->linkCheckActive ? $linkCheckActive = true : $linkCheckActive = false;
            isset( $attr->titleLinkCheck ) && $attr->titleLinkCheck ? $titleLinkCheck = true : $titleLinkCheck = false;

            isset( $attr->selectedNews ) ? $selectedNews = (int) $attr->selectedNews : $selectedNews = 1;
            isset( $attr->urlValue ) && $attr->urlValue ? $individuellUrl = $attr->urlValue : $individuellUrl = false;
            isset($attr->radioMedienLink) ? $radioMedienLink =  $attr->radioMedienLink : $radioMedienLink = 1;

            ?>
            <div class="wp-block-hupa-theme-post-list d-flex flex-wrap align-items-stretch py-3">
                <?php foreach ( $data as $tmp ):
                    $tmp->excerpt ? $excerpts = $tmp->excerpt : $excerpts = $tmp->page_excerpt;
                    $excerpt = $excerpts;
                    if ( isset( $attr->radioContend ) && $attr->radioContend == 1 ) {
                        $excerpt = $excerpts;
                    }

                    if ( isset( $attr->radioContend ) && $attr->radioContend == 2 ) {
                        $excerpt               = $tmp->content;
                        $attr->linkCheckActive = false;
                    }

                    isset( $attr->radioContend ) && $attr->radioContend == 3 ? $showContent = false : $showContent = true;

                    $targetBlank = '';
                    $src         = '';
                    switch ( $radioMedienLink ) {
                        case 1:
                            if($tmp->img_id){
                                $src         = wp_get_attachment_image_src( $tmp->img_id, 'large', false );
                                $src = $src[0];
                            } else {
                                $src = '';
                            }
                            $targetBlank = '';
                            break;
                        case 2:
                            $src         = $tmp->href;
                            $targetBlank = $urlNewTabActive;
                            break;
                        case 3:
                            $targetBlank = $urlNewTabActive;
                            if ( $individuellUrl ) {
                                $metaCheckUrl = get_post_meta( $tmp->post_id, '_hupa_show_custom_url', true );
                                $metaUrl      = get_post_meta( $tmp->post_id, '_hupa_beitragsbild_url', true );
                                if ( $metaCheckUrl && filter_var( $metaUrl, FILTER_VALIDATE_URL ) ) {
                                    $src         = $metaUrl;
                                    $dataGallery = '';
                                    $imgLink     = '';
                                } else {
                                    if ( isset( $attr->lightBoxActive ) && $attr->lightBoxActive && ! $metaUrl ) {
                                        $dataGallery = 'data-control="single"';
                                        $imgLink     = 'img-link ';
                                        $imgWrapper  = 'light-box-controls';
                                        $src         = wp_get_attachment_image_src( $tmp->img_id, 'large', false );
                                        $src         = $src[0];
                                        $targetBlank = '';
                                    } else {
                                        $src         = $tmp->href;
                                        $targetBlank = $urlNewTabActive;
                                        $dataGallery = '';
                                        $imgLink     = '';
                                    }
                                }
                            } else {
                                if ( isset( $attr->lightBoxActive ) && $attr->lightBoxActive ) {
                                    $dataGallery = 'data-control="single"';
                                    $imgLink     = 'img-link ';
                                    $imgWrapper  = 'light-box-controls';
                                    $src         = wp_get_attachment_image_src( $tmp->img_id, 'large', false );
                                    $src         = $src[0];
                                    $targetBlank = '';
                                } else {
                                    $src         = $tmp->href;
                                    $targetBlank = $urlNewTabActive;
                                    $dataGallery = '';
                                    $imgLink     = '';
                                }
                            }
                            break;
                    }

                    isset( $attr->titleCheckActive ) && $attr->titleCheckActive ? $titleNone = '' : $titleNone = 'd-none ';
                    isset( $attr->linkCheckActive ) && $attr->linkCheckActive ? $linkNone = '' : $linkNone = 'd-none ';


                    //JOB WARNING NEWS TEMPLATE 1
                    if ( $selectedNews == 1 ) :
                        if ( $tmp->img_id && $ifImage ) {
                            $lazyImg = get_the_post_thumbnail( $tmp->post_id, 'post-cover-img-large', array( 'title' => $tmp->title ) );
                            $lazyImg = preg_replace( '@(width.+height.+?".+?")@i', "", $lazyImg );
                            $hideImg = '';
                        } else {
                            $hideImg = 'd-none';
                            $lazyImg = '';
                        }
                        ?>
                        <div class="<?= $className ?> col-12 p-2 ps-template-eins">
                            <div class="news-wrapper d-flex overflow-hidden position-relative h-100 w-100">
                                <div class="p-4 d-flex flex-column">
                                    <strong class="post-news-kategorie <?= $kategorieShowActive ?> d-block mb-2  text-muted">
                                        <?php $x  = 1;
                                        $category = get_the_category( $tmp->post_id );
                                        foreach ( $category as $cat ):
                                            count( $category ) > $x ? $bull = ' <div class="vr mx-1"></div> ' : $bull = '';
                                            echo sprintf( '<a  class="text-decoration-none link-secondary" href="%s">%s</a>', get_category_link( $cat ), $cat->name ) . $bull;
                                            $x ++;
                                            ?>
                                        <?php endforeach; ?>
                                    </strong>
                                    <h4 class="<?= $titleNone ?>mb-0 lh-1">
                                        <?php
                                        if ( $titleLinkCheck ) {
                                            echo '<a class="post-title-link" href="' . $tmp->permalink . '">' . $tmp->title . '</a>';
                                        } else {
                                            echo $tmp->title;
                                        }
                                        ?></h4>
                                    <div class="mb-1 text-muted post-meta">
                                        <?php if ( $datumShowActive ): ?>
                                            <?= $tmp->date ?>
                                        <?php endif; ?>
                                        <?php if ( $authorShowActive ): ?>
                                            <?= __( 'by', 'wp-post-selector' ) ?> <?= get_the_author_posts_link() ?>
                                        <?php endif; ?>
                                    </div>
                                    <p class="card-text mb-auto pb-2 <?= $showContent ? '' : 'd-none' ?>"><?= $excerpt ?></p>
                                    <span <?= $linkCheckActive ? '' : 'class="d-none"' ?>>
                            <a href="<?= $tmp->permalink ?>"
                               class="<?= $linkNone ?>text-decoration-none">weiterlesen...</a>
                           </span>
                                </div>
                                <div class="<?= $imgWrapper ?> col-auto d-none d-lg-block ms-auto <?= $hideImg ?>">
                                    <?php if ( $dataGallery || $radioMedienLink == 2 || $ifImage ): ?>
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
                    if ( $selectedNews == 2 ):
                        if ( $tmp->img_id && $ifImage ) {

                            $lazyImg = get_the_post_thumbnail( $tmp->post_id, 'card-img-top-large', array( 'title' => $tmp->title ) );
                            $lazyImg = preg_replace( '@(width.+height.+?".+?")@i', "", $lazyImg );
                            $hideImg = '';
                        } else {
                            $hideImg = 'd-none';
                            $lazyImg = '';
                        }
                        ?>
                        <div class="<?= $className ?> card flex-fill mb-3 ps-template-zwei">
                            <div class="<?= $imgWrapper ?> <?= $hideImg ?>">
                                <?php if ( $dataGallery || $radioMedienLink == 2 || $ifImage ): ?>
                                    <a class="<?= $imgLink ?>" title="<?= $tmp->title ?>" <?= $dataGallery ?>
                                       href="<?= $src ?>" <?= $targetBlank ?>>
                                        <?= $lazyImg ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="card-body pt-1 pb-3">
                                <strong class="d-inline-block my-2 <?= $kategorieShowActive ?> text-muted">
                                    <?php $x  = 1;
                                    $category = get_the_category( $tmp->post_id );
                                    foreach ( $category as $cat ):
                                        count( $category ) > $x ? $bull = ' <div class="vr"></div> ' : $bull = '';
                                        echo sprintf( '<a  class="text-decoration-none link-secondary" href="%s">%s</a>', get_category_link( $cat ), $cat->name ) . $bull;
                                        $x ++;
                                        ?>
                                    <?php endforeach; ?>
                                </strong>
                                <h4 class="<?= $titleNone ?> mb-0 ">
                                    <?php
                                    if ( $titleLinkCheck ) {
                                        echo '<a class="post-title-link" href="' . $tmp->permalink . '">' . $tmp->title . '</a>';
                                    } else {
                                        echo $tmp->title;
                                    }
                                    ?>
                                </h4>
                                <div class="mb-2 text-muted post-meta">
                                    <?php if ( $datumShowActive ): ?>
                                        <?= $tmp->date ?>
                                    <?php endif; ?>
                                    <?php if ( $authorShowActive ): ?>
                                        <?= __( 'by', 'wp-post-selector' ) ?> <?= get_the_author_posts_link() ?>
                                    <?php endif; ?>
                                </div>
                                <p class="card-text <?= $showContent ? '' : 'd-none' ?>"><?= $excerpt ?></p>
                                <p class="card-text <?= $linkCheckActive ? '' : 'd-none' ?>"><span class="text-muted">
                                        <a href="<?= $tmp->permalink ?>"
                                           class="<?= $linkNone ?>text-decoration-none">weiterlesen...</a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    <?php endif;
                    //JOB WARNING NEWS TEMPLATE 3
                    if ( $selectedNews == 3 ):
                        if ( $tmp->img_id && $ifImage ) {

                            $lazyImg = get_the_post_thumbnail( $tmp->post_id, 'card-img-bottom-large', array( 'title' => $tmp->title ) );
                            $lazyImg = preg_replace( '@(width.+height.+?".+?")@i', "", $lazyImg );
                            $hideImg = '';
                        } else {
                            $hideImg = 'd-none';
                            $lazyImg = '';
                        }
                        ?>
                        <div class="<?= $className ?> card flex-fill mb-3 ps-template-drei">
                            <div class="card-body py-3">
                                <strong class="d-inline-block mb-1 mt-2 <?= $kategorieShowActive ?> text-muted">
                                    <?php $x  = 1;
                                    $category = get_the_category( $tmp->post_id );
                                    foreach ( $category as $cat ):
                                        count( $category ) > $x ? $bull = ' <div class="vr"></div> ' : $bull = '';
                                        echo sprintf( '<a  class="text-decoration-none link-secondary" href="%s">%s</a>', get_category_link( $cat ), $cat->name ) . $bull;
                                        $x ++;
                                        ?>
                                    <?php endforeach; ?>
                                </strong>
                                <h4 class="<?= $titleNone ?> mb-0 ">
                                    <?php
                                    if ( $titleLinkCheck ) {
                                        echo '<a class="post-title-link" href="' . $tmp->permalink . '">' . $tmp->title . '</a>';
                                    } else {
                                        echo $tmp->title;
                                    }
                                    ?>
                                </h4>
                                <div class="mb-2 text-muted post-meta">
                                    <?php if ( $datumShowActive ): ?>
                                        <?= $tmp->date ?>
                                    <?php endif; ?>
                                    <?php if ( $authorShowActive ): ?>
                                        <?= __( 'by', 'wp-post-selector' ) ?> <?= get_the_author_posts_link() ?>
                                    <?php endif; ?>
                                </div>
                                <p class="card-text <?= $showContent ? '' : 'd-none' ?>"><?= $excerpt ?></p>
                                <p class="card-text <?= $linkCheckActive ? '' : 'd-none' ?>"><span class="text-muted">
                                        <a href="<?= $tmp->permalink ?>"
                                           class="<?= $linkNone ?>text-decoration-none">weiterlesen...</a>
                                    </span>
                                </p>
                            </div>
                            <div class="<?= $imgWrapper ?> <?= $hideImg ?>">
                                <?php if ( $dataGallery || $radioMedienLink == 2 || $ifImage ): ?>
                                    <a class="<?= $imgLink ?>" title="<?= $tmp->title ?>" <?= $dataGallery ?>
                                       href="<?= $src ?>" <?= $targetBlank ?>>
                                        <?= $lazyImg ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif;
                    //JOB WARNING NEWS TEMPLATE 4
                    if ( $selectedNews == 4 ):

                        if ( ! $ifImage ) {
                            return '';
                        }
                        $lazyImg = get_the_post_thumbnail( $tmp->post_id, 'card-img-overlay-large', array( 'title' => $tmp->title ) );
                        $lazyImg = preg_replace( '@(width.+height.+?".+?")@i', "", $lazyImg );
                        isset( $attr->TextColor ) ? $TextColor = 'color: ' . $attr->TextColor . ';' : $TextColor = '';
                        isset( $attr->TextColor ) ? $LinkColor = 'style="color: ' . $attr->TextColor . 'eb;"' : $LinkColor = '';
                        if ( isset( $attr->hoverBGColor ) ) {
                            $style = 'style="background-color:' . $attr->hoverBGColor . '50;' . $TextColor . ' "';
                        } else {
                            $style = 'style="background-color:#00000050; color:#ffffff"';
                        }
                        if ( $LinkColor ): ?>
                            <style> .post-meta a {
                                    color: <?=$attr->TextColor?>eb;
                                } </style>
                        <?php endif; ?>
                        <div class="<?= $className ?> post-news-overlay-wrapper mb-3 ps-template-vier">
                            <div class="card">
                                <?= $lazyImg ?>
                                <div class="post-news-overlay d-flex flex-column h-100 card-img-overlay" <?= $style ?>>
                                    <div class="fs-4 card-title <?= $titleNone ?>">
                                        <?php
                                        if ( $titleLinkCheck ) {
                                            echo '<a class="post-title-link" href="' . $tmp->permalink . '">' . $tmp->title . '</a>';
                                        } else {
                                            echo $tmp->title;
                                        }
                                        ?>
                                    </div>
                                    <strong class="d-inline-block mb-0 <?= $kategorieShowActive ?> text-muted">
                                        <?php $x  = 1;
                                        $category = get_the_category( $tmp->post_id );
                                        foreach ( $category as $cat ):
                                            count( $category ) > $x ? $bull = ' <div class="vr"></div> ' : $bull = '';
                                            echo sprintf( '<a ' . $LinkColor . '  class="text-decoration-none" href="%s">%s</a>', get_category_link( $cat ), $cat->name ) . $bull;
                                            $x ++;
                                            ?>
                                        <?php endforeach; ?>
                                    </strong>

                                    <div class="mb-2 post-meta">
                                        <?php if ( $datumShowActive ): ?>
                                            <?= $tmp->date ?>
                                        <?php endif; ?>
                                        <?php if ( $authorShowActive ): ?>
                                            <?= __( 'by', 'wp-post-selector' ) ?> <?= get_the_author_posts_link() ?>
                                        <?php endif; ?>
                                    </div>
                                    <p class="card-text <?= $showContent ? '' : 'd-none' ?>"><?= $excerpt ?></p>
                                    <p class="card-text mt-auto <?= $linkCheckActive ? '' : 'd-none' ?>">
                                        <a <?= $LinkColor ?> href="<?= $tmp->permalink ?>"
                                                             class="<?= $linkNone ?>text-decoration-none">weiterlesen...</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
            <?php
        }
    }
}