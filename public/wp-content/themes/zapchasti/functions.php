<?php
require 'includes/init.php';
require 'includes/woocommerce.php';

if ( !is_admin() )  show_admin_bar(false);

function print_pre($val){
  echo '<pre>';
  print_r($val);
  echo  '</pre>';
}

function var_dump_pre($val){
  echo '<pre>';
  var_dump($val);
  echo  '</pre>';
}

function list_object($object){
  if(is_array($object) || is_object($object)){
    foreach ($object as $key => $value){
      list_object($value);
    }
  }else{
    echo $object . "<br>";
  }
}

if (function_exists('register_sidebar')) register_sidebar(array(
    'id' => 'search',
    'name' => 'Поиск',
    'before_title' => '',
    'after_title' => '',
    'before_widget' => '<div id="%1$s" class="search widget %2$s">',
    'after_widget' => '</div>'
));

// Вывод верхнего меню
function print_top_menu() {
  $header_menu = wp_nav_menu( array(
      'theme_location'  => 'header_menu',
      'container'       => 'nav',
      'container_class' => 'navbar navbar-light',
      'container_id'    => 'top-header-menu',
      'menu'            => 'div',
      'menu_class'      => 'navbar-nav mr-auto',
      'fallback_cb'     => 'wp_page_menu',
      'items_wrap'      => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
      'depth'           => 0,
      'echo'            => 0
  ) );
  $header_menu = str_replace('class="menu-item', 'class="menu-item nav-item', $header_menu);
  $header_menu = str_replace('<a href', '<a class="nav-link" href', $header_menu);
  return $header_menu;
}

// Вывод бокового меню
function print_aside_menu() {
  $aside_menu = wp_nav_menu( array(
      'theme_location'  => 'aside_menu',
      'container'       => 'nav',
      'container_class' => 'navbar navbar-light',
      'container_id'    => 'aside-menu-container',
      'menu_class'      => 'left-menu',
      'fallback_cb'     => 'wp_page_menu',
      'items_wrap'      => '<div class="menu-title">Каталог</div>
            <ul id="%1$s" class="nav %2$s" role="navigation">%3$s</ul>',
      'depth'           => 1,
      'echo'            => 0
  ) );
  $aside_menu = str_replace('class="menu-item', 'class="menu-item nav-item', $aside_menu);
  $aside_menu = str_replace('<a', '<a class="nav-link"', $aside_menu);
  return $aside_menu;
}

//Выводит Заголовок страницы Title
function get_title() {
  $queried_object = get_queried_object();

  if($title = get_field('wc_title', $queried_object->taxonomy . '_' . $queried_object->term_id)) {
    return $title;
  } elseif ($title = get_field('wc_title')) {
    return $title;
  } else {
    echo ltrim(wp_title("",false));
  }
}

//Выводит Описание страницы Description
function get_description() {
  
  $queried_object = get_queried_object();
  
  if($desc = get_field('wc_description', $queried_object->taxonomy . '_' . $queried_object->taxonomy)) {
    return $desc;
  } else {
    the_field('wc_description');
  }
}

//Выводит Keywords
function get_keywords() {
  $queried_object = get_queried_object();
  
  if($keywords = get_field('wc_keywords', $queried_object->taxonomy . '_' . $queried_object->term_id)) {
    return $keywords;
  } else {
    the_field('wc_keywords');
  }
}

add_image_size( 'my_cart_image_size', 60, 60, false );
// function my_cart_image_size( $product_image, $cart_item, $cart_item_key ){
//  $product_image ='cart_image_size';
//  return $product_image;

// }
// add_filter('woocommerce_cart_item_thumbnail', 'my_cart_image_size', 10, 3);


function slick_gallery()
{
    global $woocommerce_loop;
    $params = array(
        'posts_per_page' => 7,
        'post_type' => 'product',
        //'product_cat' => 'gazovye-klapany',
        'orderby' => 'title',
        'order' => 'ASC',
        'product_tag' => 'rostovgazoapparat',
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock'
            ),
         )
    );

    $products = new WP_Query($params);

    ob_start();
    if ($products->have_posts()) {

        echo '<div id="slick-products-gallery">';

        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'slider');
        }

        echo '</div>';

    } else {
        echo '<p>' . _e('No Products') . '</p>';
    }
    woocommerce_reset_loop();
    wp_reset_postdata();

    // add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );
    // add_action( 'woocommerce_template_loop_product_title', 'woocommerce_template_loop_product_link_open', 5 );
    // remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

    add_action('wp_footer', 'slick_init');
    function slick_init()
    {
        wp_enqueue_script('slick', "//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js", '', '', 'true');
        wp_enqueue_script('slick-init', get_template_directory_uri() . "/js/slick-init.js", '', '', 'true');
    }

    return ob_get_clean();
}
add_shortcode('slick', 'slick_gallery');

// Display variation's price even if min and max prices are the same
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
  if ($value['price_html'] == '') {
    $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
  }
  return $value;
}, 10, 3);

// add_filter( 'woocommerce_get_price_html', 'my_price_html' );

// function the_custom_field( $item_id, $item, $order, $plain_text){
  // echo "<pre>";
  // print_r($item_id);
  // echo "<br>";
  // print_r($item->get_product_id());
  // echo "<br>";
  // print_r($order);
  // echo "<br>";
  // print_r($plain_text);
  // echo "</pre>";

  //if( $wc_title = get_field( 'wc_title',  $item->get_product_id() )) {
    //echo $wc_title;
  //}
//}
// add_action('woocommerce_order_item_meta_start', /*'the_custom_field'*/ function(){ echo "1";}, 10);
// add_action('woocommerce_order_item_meta_end', /*'the_custom_field'*/ function(){ echo "2";}, 10);