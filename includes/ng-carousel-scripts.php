<?php
  // Add Scripts
  function ngcw_add_scrips(){
    // Add Main CSS
    wp_register_style('ngcw-main-style', plugins_url(). '/diviCarousel/css/style.css');
    wp_register_style('ngcw-flickity', plugins_url(). '/diviCarousel/css/flickity.css');
    wp_enqueue_style('ngcw-main-style');
    wp_enqueue_style('ngcw-flickity');
    // Add Main JS
    wp_enqueue_script('ngcw-main-script', plugins_url(). '/diviCarousel/js/main.js', array("jquery"), null, true);
    wp_enqueue_script("ngcw-flickity", plugins_url(). '/diviCarousel/js/flickity.pkgd.min.js');
    // Add Google Script
    //wp_register_script('google', 'https://apis.google.com/js/platform.js');
    //wp_enqueue_script('google');
  }

  add_action('wp_enqueue_scripts', 'ngcw_add_scrips');