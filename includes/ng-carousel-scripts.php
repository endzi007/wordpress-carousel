<?php
  // Add Scripts
  function ngcw_add_scrips(){
    // Add Main CSS
    wp_register_style('ngcw-main-style', plugins_url(). '/wordpress-carousel/css/style.css');
    wp_register_style('ngcw-flickity', plugins_url(). '/wordpress-carousel/css/flickity.css');
    wp_register_style('ngcw-glightbox', plugins_url(). '/wordpress-carousel/css/glightbox.min.css');
    wp_enqueue_style('ngcw-main-style');
    wp_enqueue_style('ngcw-flickity');
    wp_enqueue_style('ngcw-glightbox');
    // Add Main JS
    wp_enqueue_script('ngcw-main-script', plugins_url(). '/wordpress-carousel/js/main.js', array("jquery"), null, true);
    wp_enqueue_script("ngcw-flickity", plugins_url(). '/wordpress-carousel/js/flickity.pkgd.min.js');
    wp_enqueue_script('ngcw-glightbox', plugins_url().'/wordpress-carousel/js/glightbox.min.js');
    // Add Google Script
    //wp_register_script('google', 'https://apis.google.com/js/platform.js');
    //wp_enqueue_script('google');
  }

  add_action('wp_enqueue_scripts', 'ngcw_add_scrips');