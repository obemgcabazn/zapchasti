<?php

if ( !is_admin() )  show_admin_bar(false);

define('WOOCOMMERCE_USE_CSS', false);

add_action( 'wp_print_styles', 'my_style_method' );

function my_style_method () {
	// wp_enqueue_style( 'slick', get_template_directory_uri() . "/css/slick.css", '', '', '' );
  // wp_enqueue_style( 'slick-theme', get_template_directory_uri() . "/css/slick-theme.css", '', '', '' );
  wp_enqueue_style( 'style', get_template_directory_uri() . "/css/style.css", '', '', '' );
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function my_scripts_method(){
  wp_enqueue_script( 'tether', "https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js", '', '', 'true');
  wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js', '', '', 'true' );
  wp_enqueue_script( 'fancybox', '/wp-content/themes/intergaz/js/jquery.fancybox.min.js', '', '', 'true' );
  // wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', '', '', 'true' );
  // wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', '', '', 'true' );
}

register_nav_menus( array( 
  'header_menu' => __( 'Верхнее меню' ), 
  'aside_menu' => __( 'Боковое меню' ), 
  ));