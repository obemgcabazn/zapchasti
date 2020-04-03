<?php
/**
 * zapchasti-kotla functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package zapchasti
 */
if ( ! function_exists( 'zapchasti_setup' ) ){
  function zapchasti_setup() {
    define('WOOCOMMERCE_USE_CSS', false);
    add_theme_support( 'woocommerce' );
    add_theme_support( 'html5', array( 'search-form' ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-slider' );
  }
}
add_action( 'after_setup_theme', 'zapchasti_setup' );


// Добавляем Стили
if ( !is_admin() ) {
  add_action( 'wp_print_styles', 'zapchasti_style_method' );
}
function zapchasti_style_method () {
  wp_enqueue_style( 'bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css", '', '', '' );
  wp_enqueue_style( 'fancybox', "https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.css", '', '', '' );
  wp_enqueue_style( 'slick', get_template_directory_uri() . "/css/slick.css", '', '', '' );
  wp_enqueue_style( 'slickTheme', get_template_directory_uri() . "/css/slick-theme.css", '', '', '' );
  wp_enqueue_style( 'concat', get_template_directory_uri() . "/css/concat.css", '', '', '' );
}

// Удаляем стили WC
//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Добавляем Скрипты
add_action( 'wp_enqueue_scripts', 'zapchasti_scripts_method' );
function zapchasti_scripts_method(){
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', "https://yastatic.net/jquery/2.0.3/jquery.min.js", '', '', 'true');
  wp_enqueue_script( 'tether', "https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js", '', '', 'true');
  wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js', '', '', 'true' );
  wp_enqueue_script( 'fancybox',  'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js', '', '', 'true' );
  wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', '', '', 'true' );
}

add_action( 'wp_print_styles', 'front_page_style_method', 99 );
function front_page_style_method () {
  if(is_front_page()) {
    wp_enqueue_style( 'homepage-style', get_template_directory_uri() . "/css/homepage.css", '', '', '' );
  }
}

register_nav_menus( array( 
  'header_menu' => __( 'Верхнее меню' ), 
  'aside_menu' => __( 'Боковое меню' ), 
  ));

// Отключаем сам REST API
// add_filter('rest_enabled', '__return_false');

// Отключаем фильтры REST API
// remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
// remove_action( 'wp_head',                    'rest_output_link_wp_head', 10, 0 );
// remove_action( 'template_redirect',          'rest_output_link_header', 11, 0 );
// remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
// remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API
// remove_action( 'init',          'rest_api_init' );
// remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
// remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API
// remove_action( 'rest_api_init',          'wp_oembed_register_route'              );
// remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

// remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
// remove_action( 'wp_head',                'wp_oembed_add_host_js'                 );

remove_filter( 'the_content', 'wptexturize' ); /* убираем авотдобавление параграфиов */
remove_action( 'wp_head', 'wp_resource_hints', 2); /* удаляем dns-prefetch */

// Удаляем автоподстановку размера картинок
// function remove_thumbnail_dimensions( $html ) {
//   $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
//   return $html;
// }
// add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
// add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

// убираем emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Убираем мусор из шапки
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

/* удаляем shortlink и canonical */
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'rel_canonical' );

/* Сброс фильтра для html в описании категории */
remove_filter('pre_term_description', 'wp_filter_kses');
remove_filter('pre_term_description', 'wp_kses_data');

// Удаляем RSS ленту
function fb_disable_feed() {
  wp_redirect(get_option('siteurl'));//будет осуществляться редирект на главную страницу
}
//add_action('do_feed', 'fb_disable_feed', 1);
//add_action('do_feed_rdf', 'fb_disable_feed', 1);
//add_action('do_feed_rss', 'fb_disable_feed', 1);
//add_action('do_feed_rss2', 'fb_disable_feed', 1);
//add_action('do_feed_atom', 'fb_disable_feed', 1);
//add_action('do_feed_rss2_comments', 'fb_disable_feed', 1);
//add_action('do_feed_atom_comments', 'fb_disable_feed', 1);
//remove_action( 'wp_head', 'feed_links_extra', 3 );
//remove_action( 'wp_head', 'feed_links', 2 );