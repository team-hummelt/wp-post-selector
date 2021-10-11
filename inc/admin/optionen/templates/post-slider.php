<?php


namespace Post\Slider;

use stdClass;

defined( 'ABSPATH' ) or die();

/**
 * POST SLIDER SHORTCODE
 * @package Hummelt & Partner WordPress Theme
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */

if ( ! class_exists( 'PostSliderTemplates' ) ) {
	add_action( 'after_setup_theme', array( 'Post\\Slider\\PostSliderTemplates', 'init' ), 0 );

	class PostSliderTemplates {
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
			add_action( 'load_slider_template', array( $this, 'loadSliderTemplate' ), 10, 2 );
		}

		public function loadSliderTemplate( $data, $attr ) {
			$args   = sprintf( 'WHERE id=%d', $attr->selectedSlider );
			$slider = apply_filters( 'post_selector_get_by_args', $args, false );
			if ( ! $slider->status ) {
				return null;
			}
			$settings = $slider->record->data;
			$this->render_splide_template( $settings, $attr, $data );
		}

		private function render_splide_template( $settings, $attr, $data ) {

			$rand = apply_filters( 'get_ps_generate_random_id', 12, 0 );
			if ( isset( $attr->lightBoxActive ) && $attr->lightBoxActive ) {
				$dataGallery = 'data-gallery=""';
			} else {
				$dataGallery = '';
			}

			if ( isset( $attr->hoverBGColor ) && $attr->hoverBGColor && isset($attr->TextColor) && $attr->TextColor) {
				$bGColor = $attr->hoverBGColor.'d9';
				$textColor = $attr->TextColor.'ff';
				$btnBGHover = $attr->TextColor;

				$bgStyle = 'style=
                          "color: '.$textColor.';
                          background-color: '.$bGColor.';"';

				$bgStyle = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $bgStyle));
				$btnStyle = 'style=
                          "color: '.$btnBGHover.';
                           background-color: '.$attr->hoverBGColor.'00;
                           border-color: '.$attr->TextColor.'33;"';

				$onMouseBgHover = 'onmouseover="this.style.background=\''.$attr->TextColor.'\';';
				$onMouseBgHover .= 'this.style.color=\''.$attr->hoverBGColor.'\';';
				$onMouseBgHover .= 'this.style.borderColor=\''.$attr->hoverBGColor.'\';"';
				$onMouseBgOut = 'onmouseout="this.style.background=\''.$attr->hoverBGColor.'00'.'\';';
				$onMouseBgOut .= 'this.style.borderColor=\''.$textColor.'33'.'\';';
				$onMouseBgOut .= 'this.style.color=\''.$textColor.'\';"';

				$btnOut = $btnStyle . $onMouseBgHover . $onMouseBgOut;
				$btnOut = preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $btnOut));
			} else {
				$btnOut = '';
                $bgStyle = '';
			}

			$count = count((array) $data);
			$settings->arrows && $count > 0 ? $arrows  = '' : $arrows = 'd-none';
			$settings->label ? $padding = 'style="padding-bottom:3rem!important"' : $padding = '';
			?>
            <div class="wp-block-hupa-theme-post-list">
                <div data-id="<?= $attr->selectedSlider ?>" data-rand="<?= $rand ?>" class="splide splide<?= $rand ?>">
                    <div class="splide__arrows <?=$arrows?>">
                        <button class="splide__arrow splide__arrow--prev">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button class="splide__arrow splide__arrow--next">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                    <div class="splide__track" <?=$padding?>>
                        <div class="splide__list">
							<?php foreach ( $data as $tmp ):
								if($attr->radioMedienLink == 2) {
									$src = $tmp->href;
                                    } else {
								    $src = $tmp->src;
								}
								if($attr->linkCheckActive) {
								   $btnShowLink = '';
                                }else {
									$btnShowLink = 'd-none';
								}
								if($attr->titleCheckActive){
								    $title = $tmp->title;
								}else {
									$title = '';
								}
								if(!$tmp->excerpt){
								    $excerpt = $tmp->page_excerpt;
								} else {
									$excerpt = $tmp->excerpt;
								}
								?>
                                <div class="splide__slide">
                                    <img class="splide-img" alt="<?= $tmp->alt ?>"
                                         data-splide-lazy="<?= $tmp->image ?>" src="<?= $tmp->image ?>"/>
                                    <div class="slide-hover <?=$settings->hover ? '' : 'd-none'?>"<?=$bgStyle?>>
                                        <div class="hover-wrapper">
                                            <div class="hover-headline"><?=$title?></div>
                                            <div class="post-excerpt">
                                                <?php if($settings->textauszug): ?>
                                                  <?=$excerpt?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="hover-button">
                                                <a title="<?=$title?>" <?=$dataGallery?> href="<?=$src?>" class="btn-hover" <?=$btnOut?>> <i class="fa fa-image"></i> </a>
                                                <a href="<?=$tmp->permalink?>" class="btn-hover <?=$btnShowLink?>" title="Link zum Beitrag" <?=$btnOut?>> <i class="fa fa-list"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="splide-label">
                                        <?=$tmp->captions?>
                                    </div>
                                </div>
							<?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

		<?php
		}
	}
}