<?php
/*
Plugin Name: Wordpress Carousel
Plugin URI: http://enisjasarovic.me
Description: Display images and posts in any page or widget, like caraousel gallery
Version: 1.0.3
Author: Enis Jasarovic
Author URI: http://enisjasarovic.me
*/

// Exit if accessed directly
if(!defined('ABSPATH')){
  exit;
}

// Load Class
require_once(plugin_dir_path(__FILE__).'/includes/ng-carousel-scripts.php');
$pluginName = plugin_basename(__FILE__);
add_action('init', 'wporg_shortcodes_init');

add_filter("plugin_action_link_$pluginName", "settingsLink" );
function activate(){

}

function deactivate(){
  
}


function settingsLink ($links){

}

function wporg_shortcodes_init(){
    add_shortcode('ng_carousel_enis', 'registerNgCarouselShortcode');
}
 

function registerNgCarouselShortcode ($attr){
    $newAtts = shortcode_atts(array(
      'kategorija'=> "eventi",
      'grupe'=> 'false',
      'naslov'=> "",
      'type' => "grid",
      'visina'=> "200px"
    ), $attr);
    $htmlContent = "";

    if($newAtts["type"] === "grid"){
      $htmlContent = setupGridElements($newAtts["kategorija"], $newAtts["visina"]);
    } else {
      $htmlContent = setupCarouselElements($newAtts);
    }
    
      return $htmlContent;
}


function setupGridElements($cat, $height){
  $htmlContent = "<div class='glight-container'>";
  $cat_id = get_cat_ID($cat);
  $kategorijaURL = get_category_link( $cat_id );
  //need to get events passed
  $posts = get_posts(array("category"=>$cat_id, "numberposts"=>-1));
  if(! is_wp_error($posts)){
    foreach ($posts as $key => $post) {
      $thumbnailUrl= get_the_post_thumbnail_url($post->ID);
      $post_title = $post->post_title;
      $link = $post->guid;
      $htmlContent .= "<a href='$thumbnailUrl' class='glightbox' data-glightbox=title:$post_title>";
      $htmlContent .= "<img src='$thumbnailUrl' alt='$post_title'/>";
      $htmlContent .="</a>";
    }
  }
  $htmlContent .= "</div>";
  return $htmlContent;
}


function setupCarouselElements($newAtts){
  $sirina = "90%";
  $shortcodeGroupValue = (int)$newAtts['grupe'];
  if($shortcodeGroupValue === 0){
    $sirina = "90%";
  } elseif ($shortcodeGroupValue > 0 && $shortcodeGroupValue < 6 ) {
    $calculatedWidth = 100/($shortcodeGroupValue); 
    $sirina = $calculatedWidth . "%";
  } else{
    $sirina = "90%";
  }

  $naslov =  $newAtts['naslov'];
  $grupe = $newAtts['grupe'];
  $cat_id = get_cat_ID($newAtts['kategorija']);
  $kategorijaURL = get_category_link( $cat_id );
  $visina = $newAtts['visina'];
  $htmlContent = "<h3><a href='$kategorijaURL'>$naslov</a></h3>";
  $htmlContent .= "<div class='main-carousel' data-group=$shortcodeGroupValue style='width: 100%; min-height:$visina'>";

  //need to get events passed
  $posts = get_posts(array("category"=>$cat_id, "numberposts"=>10));
    foreach ($posts as $key => $post) {
      $thumbnailUrl= get_the_post_thumbnail_url($post->ID);
      $post_excerpt = $post->post_excerpt;
      $link = $post->guid;
      $htmlContent .= "<div class='carousel-cell' style= 'width: $sirina;'>";
  $htmlContent .= "<div style= 'background: no-repeat center/cover url($thumbnailUrl); width:100%; height:$visina; border-radius: 7px;'></div>";
      $htmlContent .="<p style='display:block; width: 100%; background-color: white; color: black;'><a style='color: white;' href='$link'>$post_excerpt</a></p>";
      
      $htmlContent .="</div>";
    }
    $htmlContent .='</div>';
    wp_reset_query();

    return $htmlContent;
}

function registerAdminPage(){
  add_menu_page('Enis', "Enis 2", "manage_options", "enis_plugin", "adminIndex", "dashicons-tickets-alt", 110);
}

function adminIndex(){
  require_once(plugin_dir_path(__FILE__).'/templates/admin.php');
}
add_action("admin_menu", "registerAdminPage");
register_activation_hook(plugin_dir_path(__FILE__)."/".$pluginName, "activate");
register_deactivation_hook(plugin_dir_path(__FILE__)."/".$pluginName, "deactivate");
