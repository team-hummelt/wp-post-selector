<?php
defined('ABSPATH') or die();
/**
 * Post Selector
 * @package Hummelt & Partner WordPress Plugin
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 * https://www.hummelt-werbeagentur.de/
 */

?>

<div class="wp-bs-starter-wrapper">
    <div class="container">
        <div class="card card-license shadow-sm">
            <h5 class="card-header d-flex align-items-center bg-hupa py-4">
                <i class="icon-hupa-white d-block mt-2" style="font-size: 2rem"></i>&nbsp;
                <?= __('Post Selector', 'wp-post-selector') ?> </h5>
            <div class="card-body pb-4" style="min-height: 72vh">
                <div class="d-flex align-items-center">
                    <h5 class="card-title"><i
                                class="hupa-color fa fa-arrow-circle-right"></i> <?= __('Post Selector', 'wp-post-selector') ?>
                        / <span id="currentSideTitle"><?= __('Übersicht', 'wp-post-selector') ?></span>
                    </h5>
                </div>
                <hr>
                <div class="settings-btn-group d-block d-md-flex flex-wrap">
                    <button data-site="<?= __('Slider', 'wp-post-selector') ?>"
                            type="button"
                            data-type="slider"
                            id="btnDataSlider"
                            data-bs-toggle="collapse" data-bs-target="#collapsePostSelectOverviewSite"
                            class="btn-post-collapse btn btn-hupa btn-outline-secondary btn-sm active" disabled>
                        <i class="fa fa-sliders"></i>&nbsp;
                        <?= __('Slider', 'wp-post-selector') ?>
                    </button>

                    <button data-site="<?= __('Galerie', 'wp-post-selector') ?>"
                            data-type="galerie"
                            type="button" id="postEditCollapseBtn"
                            data-bs-toggle="collapse" data-bs-target="#collapseGalerieSite"
                            class="btn-post-collapse btn btn-hupa btn-outline-secondary btn-sm">
                        <i class="fa fa-image"></i>&nbsp;
                        <?= __('Galerie', 'wp-post-selector') ?>
                    </button>
                </div>
                <hr>
                <div id="post_display_parent">
                    <!--  TODO JOB WARNING STARTSEITE -->
                    <div class="collapse show" id="collapsePostSelectOverviewSite"
                         data-bs-parent="#post_display_parent">
                        <div class="border rounded mt-1 mb-3 shadow-sm p-3 bg-custom-gray" style="min-height: 53vh">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title">
                                    <i class="font-blue fa fa-sliders"></i>&nbsp;<?= __('Post Selector Slider', 'wp-post-selector') ?>
                                </h5>
                                <div class="ajax-status-spinner ms-auto d-inline-block mb-2 pe-2"></div>
                            </div>
                            <hr class="mt-1">
                            <div class="d-flex flex-wrap">
                                <button data-type="insert" class="load-slider-temp btn btn-blue btn-sm"><i
                                            class="fa fa-plus"></i>&nbsp;Slider
                                    hinzufügen
                                </button>

                                <button data-bs-toggle="modal" data-bs-target="#demoModal"
                                        class="btn btn-blue-outline btn-sm ms-auto">
                                    Demo hinzufügen
                                </button>
                            </div>
                            <hr>
                            <div id="slideFormWrapper"></div>
                        </div>
                    </div>
                    <!--  TODO JOB WARNING Galerie -->
                    <div class="collapse" id="collapseGalerieSite" data-bs-parent="#post_display_parent"> </div>
                </div><!--parent-->
            </div>
            <small class="card-body-bottom" style="right: 1.5rem">DB: <i class="hupa-color"><?=POST_SELECT_PLUGIN_DB_VERSION?></i> | Version:
                <i class="hupa-color">v<?= POST_SELECTOR_PLUGIN_VERSION ?></i>
            </small>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formDeleteModal" tabindex="-1" aria-labelledby="formDeleteModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-hupa">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal"><i
                                class="text-danger fa fa-times"></i>&nbsp; Abbrechen
                    </button>
                    <button type="button" data-bs-dismiss="modal"
                            class="btn-delete-items btn btn-danger">
                        <i class="fa fa-trash-o"></i>&nbsp; löschen
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="demoModal" tabindex="-1" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel"><i class="fa fa-sliders"></i>&nbsp; Post Selector Demos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="form-modal mb-2 p-3">
                    <form class="send-bs-form-jquery-ajax-formular" action="#" method="post">
                        <input type="hidden" name="type" value="demo">
                        <input type="hidden" name="method" value="slider-form-handle">
                        <input class="modalAction" type="hidden" name="action">
                        <input class="modalNonce" type="hidden" name="_ajax_nonce">
                        <label for="inputDemoSlider" class="form-label">Demo auswählen</label>
                        <select class="form-select" name="demo_type" id="inputDemoSlider">
                            <option value="1">Beitrags Slider volle Breite</option>
                            <option value="2">wechselndes Einzelbild</option>
                        </select>
                        <button type="submit" data-bs-dismiss="modal" class="btn btn-blue btn-sm mt-3">auswählen und
                            Speichern
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL ADD GALERIE-->
    <div class="modal fade" id="galerieHandleModal" tabindex="-1" aria-labelledby="addGalerieModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>


</div>

<div id="snackbar-success"></div>
<div id="snackbar-warning"></div>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter="">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>