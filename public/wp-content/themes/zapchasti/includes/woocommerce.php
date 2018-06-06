<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 06.07.2017
 * Time: 9:45
 */

/* ХУКИ WOOCOMMERCE */

// Включить галерею твоаров
add_action( 'after_setup_theme', 'gallery_theme_setup' );
function gallery_theme_setup() {
	add_theme_support( 'woocommerce'/*, array(
  'thumbnail_image_width' => 200,
  'gallery_thumbnail_image_width' => 100,
  'single_image_width' => 500,
	)*/ );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );
	// add_theme_support( 'wc-product-gallery-lightbox' );
}

// Удаляем стили WC
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/* переносим артикул */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 6 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 6 );

// Заголовок товара в категории
function woocommerce_template_loop_category_title( $category ) {
	echo '<h2 class="woocommerce-loop-category__title">' . $category->name . '</h2>';
}

function woocommerce_subcategory_thumbnail( $category ) {
	$small_thumbnail_size   = apply_filters( 'subcategory_archive_thumbnail_size', 'shop_catalog' );
	$dimensions         = wc_get_image_size( $small_thumbnail_size );
	$thumbnail_id       = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
	
	if ( $thumbnail_id ) {
		$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
		$image = $image[0];
	} else {
		$image = wc_placeholder_img_src();
	}
	
	if ( $image ) {
		$image = str_replace( ' ', '%20', $image );
		echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" />';
	}
}

add_filter( 'woocommerce_product_thumbnails_columns', 'new_column' );
function new_column() {
	return '2';
}

//Обертка для формы оплаты
add_action( 'woocommerce_checkout_before_customer_details', 'open_checkout_wrap' );
function open_checkout_wrap() {
	echo '<div class="row">';
}

add_action( 'woocommerce_checkout_after_customer_details', 'close_checkout_wrap' );
function close_checkout_wrap() {
	echo '</div>';
}

// Формы для заказа
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_last_name']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_address_1']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_postcode']);
	$fields['billing']['billing_first_name']['label'] = 'ФИО';
	$fields['billing']['billing_first_name']['placeholder'] = 'Введите ФИО';
	return $fields;
}

// Обертка для количества и кнопки "В корзину" в карточке товара
add_action( 'woocommerce_before_add_to_cart_button', 'woocommerce_before_add_to_cart_button_bs_row' );
function woocommerce_before_add_to_cart_button_bs_row() {
	echo '<div class="row">';
}

add_action( 'woocommerce_after_add_to_cart_button', 'woocommerce_after_add_to_cart_button_bs_row' );
function woocommerce_after_add_to_cart_button_bs_row() {
	echo '</div>';
}

add_action( 'woocommerce_before_add_to_cart_quantity', 'woocommerce_before_add_to_cart_quantity_bs_wrapper' );
function woocommerce_before_add_to_cart_quantity_bs_wrapper() {
	echo '<div class="col-12 col-sm-5">';
}

add_action( 'woocommerce_after_add_to_cart_quantity', 'woocommerce_before_add_to_cart_quantity_bs_wrapper_close' );
function woocommerce_before_add_to_cart_quantity_bs_wrapper_close() {
	echo "</div>";
}

/**
 * Get order total html including inc tax if needed.
 *
 * @access public
 */
function wc_cart_totals_order_total_html_in_euro() {
	$value = WC()->cart->get_total();
	
	// If prices are tax inclusive, show taxes here
	if ( wc_tax_enabled() && WC()->cart->tax_display_cart == 'incl' ) {
		$tax_string_array = array();
		
		if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) {
			foreach ( WC()->cart->get_tax_totals() as $code => $tax )
				$tax_string_array[] = sprintf( '%s %s', $tax->formatted_amount, $tax->label );
		} else {
			$tax_string_array[] = sprintf( '%s %s', wc_price( WC()->cart->get_taxes_total( true, true ) ), WC()->countries->tax_or_vat() );
		}
		
		if ( ! empty( $tax_string_array ) ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
					? sprintf( ' ' . __( 'estimated for %s', 'woocommerce' ), WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
					: '';
			$value .= '<small class="includes_tax">' . sprintf( __( '(includes %s)', 'woocommerce' ), implode( ', ', $tax_string_array ) . $estimated_text ) . '</small>';
		}
	}
	
	echo apply_filters( 'woocommerce_cart_totals_order_total_html', $value );
}

// Перемножение на евро
add_filter('raw_woocommerce_price', 'raw_in_euro');
function raw_in_euro($val)
{
//	return($val);
	return $val * (float) get_field( 'cur_val', 'option' );
}

//add_filter('woocommerce_get_price_including_tax', 'in_euro');
//function in_euro($return_price){
//	return $return_price;
//}

// add_filter( 'woocommerce_cart_total', 'in_euro_total' );
function in_euro_total($value){
	return $value * (float) get_field( 'cur_val', 'option' );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'my_breadcrumbs_delimiter');
function my_breadcrumbs_delimiter($args) {
	$args['delimiter'] = '<span class="breadcrumb-delimiter"> | </span>';
	return $args;
}

// Количество товаров на странице категории
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 20;' ), 20 );

// Количество товаров в корзине
function cart_count()
{
	global $woocommerce;
	$count = $woocommerce->cart->cart_contents_count;
	return $count;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'breadcrumbs', 'woocommerce_breadcrumb', 10 );

add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 50;' ), 20 );

function woocommerce_template_loop_product_title() {
	echo '<span class="woocommerce-loop-product__title">' . get_the_title() . '</span>';
}