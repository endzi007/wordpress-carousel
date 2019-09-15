<?php
/*
Plugin Name: Divi Carousel
Plugin URI: http://enisjasarovic.me
Description: Display post category in carousel
Version: 1.0.0
Author: Enis Jasarovic
Author URI: http://enisjasarovic.me
*/

// Exit if accessed directly
if(!defined('ABSPATH')){
  exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/ng-carousel-class.php');

// Load Class
require_once(plugin_dir_path(__FILE__).'/includes/ng-carousel-scripts.php');

// Register Widget
function register_ngCarouselWidget(){
  register_widget('NG_Carousel_widget');
}

// Hook in function
add_action('widgets_init', 'register_ngCarouselWidget');