<?php

if (site_url() == "http://wordpress-theme-development.local"){
  define("VERSION", time());
}else{
  define("VERSION", wp_get_theme()->get("Version"));
}


function alpha_bootstrapping() {
  load_theme_textdomain("alpha");
  add_theme_support("title-tag");
  add_theme_support("post-thumbnails");
  register_nav_menu( "top_menu", __("Top Menu", "alpha") );
  register_nav_menu( "footer_menu", __("Footer Menu", "alpha") );
}
add_action("after_setup_theme", "alpha_bootstrapping");

function alpha_assets () {
  wp_enqueue_style("alpha", get_stylesheet_uri(), null, VERSION);
  wp_enqueue_style( "bootstrap", "//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
  wp_enqueue_style( "feather-light-css", "//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css");
  wp_enqueue_script("feather-light-js", "//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js", array("jquery"), "1.0", true);
  wp_enqueue_script("alpha-main", get_theme_file_uri( "/assets/js/main.js" ) , array("jquery","feather-light-js" ), VERSION, true);
}
add_action("wp_enqueue_scripts", "alpha_assets");

function alpha_sidebar(){
  register_sidebar(
      array(
          'name'          => __( 'Single Post Sidebar', 'alpha' ),
          'id'            => 'sidebar-1',
          'description'   => __( 'Right Sidebar', 'alpha' ),
          'before_widget' => '<section id="%1$s" class="widget %2$s">',
          'after_widget'  => '</section>',
          'before_title'  => '<h2 class="widget-title">',
          'after_title'   => '</h2>',
      )
  );
  register_sidebar(
      array(
          'name'          => __( 'Footer left Sidebar', 'alpha' ),
          'id'            => 'footer-left',
          'description'   => __( 'Footer left Sidebar', 'alpha' ),
          'before_widget' => '<section id="%1$s" class="widget %2$s">',
          'after_widget'  => '</section>',
          'before_title'  => '<h2 class="widget-title">',
          'after_title'   => '</h2>',
      )
  );
  register_sidebar(
      array(
          'name'          => __( 'Footer right Sidebar', 'alpha' ),
          'id'            => 'footer-right',
          'description'   => __( 'Footer right Sidebar', 'alpha' ),
          'before_widget' => '<section id="%1$s" class="widget %2$s">',
          'after_widget'  => '</section>',
          'before_title'  => '<h2 class="widget-title">',
          'after_title'   => '</h2>',
      )
  );
}

add_action("widgets_init","alpha_sidebar");
// if post password protected
function alpha_excerpt ($excerpt){
  if(!post_password_required(  )){
    return $excerpt;
  }else {
    echo get_the_password_form(  );
  }
}
add_filter( "the_excerpt", "alpha_excerpt" );


function alpha_protected_title_change(){
 return "Locked: %s";
}
add_filter ("protected_title_format", "alpha_protected_title_change");

function alpha_nav_menu_calss( $classes , $item ) { 
  $classes [] = "list-inline-item";
  return $classes;
 }
add_filter( 'nav_menu_css_class', 'alpha_nav_menu_calss', 10, 2 ); 