<?php


namespace Post\News;

defined( 'ABSPATH' ) or die();

/**
 * POST NEWS TEMPLATE
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
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

			$category = get_the_category($data->post_id);
			$attr->imageCheckActive ? $ifImage = true : $ifImage = false;

			if ( isset( $attr->lightBoxActive ) && $attr->lightBoxActive ) {
				$dataGallery = 'data-control="single"';
				$imgLink = 'img-link ';
                $imgWrapper = 'light-box-controls';
			} else {
				$dataGallery = '';
                $imgLink = '';
                $imgWrapper = '';
			}

            $attr->className ? $className = $attr->className : $className = '';
            ?>
            <div class="wp-block-hupa-theme-post-list   d-flex flex-wrap align-items-stretch py-3">
                <?php foreach ($data as $tmp):
                $tmp->excerpt ? $excerpt = $tmp->excerpt : $excerpt = $tmp->page_excerpt;
                if($tmp->image && $ifImage){
                    $hideImg = '';
                    $imgSrc = wp_get_attachment_image_src($tmp->img_id, 'large', false);
                    $img_src = $imgSrc[0];
                } else {
                    $hideImg = 'd-none';
                    $img_src = '';
                }

	             if($attr->radioMedienLink == 2) {
		                $src = $tmp->href;
	                } else {
		                //$src = $tmp->src;
                        //$img_src = wp_get_attachment_image_src($tmp->img_id, 'medium', false);
                        $src = wp_get_attachment_image_src($tmp->img_id, 'large', false);
                        $src = $src[0];
	                }
                    $attr->titleCheckActive ? $titleNone = '' : $titleNone = 'd-none ';
                    $attr->linkCheckActive ? $linkNone = '' : $linkNone = 'd-none ';

	             $count = count((array) $data);
	             $count == 1 ? $colXl = '12' : $colXl = '6';
                    ?>
                <div class="<?=$className?> col-12 p-2">
                    <div class="news-wrapper d-flex overflow-hidden position-relative h-100 w-100">
                        <div class="p-4 d-flex flex-column">
                            <strong class="d-inline-block mb-2 text-muted">
                                <?php $x = 1;
                                $x != count($category) ? $bull = ' | ' : $bull = '';
                                $category = get_the_category($data->post_id);
                                foreach ($category as $cat):
                                 echo sprintf( '<a  class="text-decoration-none" href="%s">%s</a>', get_category_link( $cat ), $cat->name ) . $bull ;
                                $x++;
                                ?>
                            <?php endforeach; ?>
                            </strong>
                            <h4 class="<?=$titleNone?>mb-0 lh-1"><?=$tmp->title?></h4>
                            <div class="mb-1 text-muted"><?=$tmp->date?></div>
                            <p class="card-text mb-auto"><?=$excerpt?></p>
                            <span>
                            <a href="<?=$tmp->permalink?>" class="<?=$linkNone?>text-decoration-none">weiterlesen...</a>
                           </span>
                        </div>
                        <div class="<?=$imgWrapper?> col-auto d-none d-lg-block ms-auto <?=$hideImg?>">
                            <?php if($dataGallery || $attr->radioMedienLink == 2 || $ifImage):?>
                            <a class="<?=$imgLink?>" title="<?=$tmp->title?>" <?=$dataGallery?> href="<?=$src?>">
                            <img class="post-cover-img <?=$hideImg?>" src="<?=$img_src?>" alt="<?=$tmp->alt?>">
                           </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
               <?php endforeach; ?>
            </div>

			<?php
		}
	}
}