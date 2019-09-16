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

// Load Class
require_once(plugin_dir_path(__FILE__).'/includes/ng-carousel-scripts.php');


function wporg_shortcodes_init()
{
    add_shortcode('ng_carousel_enis', 'registerNgCarouselShortcode');
}
 

function registerNgCarouselShortcode ($attr){
    $newAtts = shortcode_atts(array(
      'kategorija'=> "eventi",
      'grupe'=> 'false',
      'naslov'=> "",
    ), $attr);

    $sirina = "66%";
    $shortcodeGroupValue = (int)$newAtts['grupe'];
    if($shortcodeGroupValue === 0){
      $sirina = "66%";
    } elseif ($shortcodeGroupValue > 0 && $shortcodeGroupValue < 6 ) {
      $calculatedWidth = 100/($shortcodeGroupValue); 
      $sirina = $calculatedWidth . "%";
    } else{
      $sirina = "66%";
    }

    $naslov =  $newAtts['naslov'];
    $grupe = $newAtts['grupe'];
    $htmlContent = "<h3> $naslov </h3>";
    $htmlContent .= "<div class='main-carousel' data-group=$shortcodeGroupValue style='width: 100%'>";
    $cat_id = get_cat_ID($newAtts['kategorija']);

    //need to get events passed
    $posts = get_posts(array("category"=>$cat_id, "numberposts"=>10));

      foreach ($posts as $key => $post) {
        $thumbnailUrl= get_the_post_thumbnail_url($post->ID);
        $post_excerpt = $post->post_excerpt;
        $link = $post->guid;
        print_r($link);
        $htmlContent .= "<div class='carousel-cell' style= 'background: no-repeat center/cover url($thumbnailUrl); width: $sirina;'>";
        $htmlContent .="<p style='display:block; width: 100%; background-color: white; color: black;'><a style='color: white;' href='$link'>$post_excerpt</a></p>";
        
        $htmlContent .="</div>";
      }
      $htmlContent .='</div>';
      wp_reset_query();
      return $htmlContent;
}

add_action('init', 'wporg_shortcodes_init');
