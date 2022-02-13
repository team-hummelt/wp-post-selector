<?php
defined( 'ABSPATH' ) or die();

/**
 * POST SELECTOR OPTIONEN
 * @package Hummelt & Partner WordPress Plugin
 * Copyright 2021, Jens Wiecker
 * License: Commercial - goto https://www.hummelt-werbeagentur.de/
 */


if(!get_option('ps_user_role')){
    update_option('ps_user_role', 'manage_options');
}
require 'filter/post-selector-filter.php';
require 'filter/post-galerie-filter.php';
require 'templates/post-slider.php';
require 'templates/news-template.php';
require 'templates/galerie-templates.php';


