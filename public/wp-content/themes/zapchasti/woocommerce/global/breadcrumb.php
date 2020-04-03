<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';

		} else {
			
			$queried_object = get_queried_object();
			$taxonomy = $queried_object->taxonomy;
			$term_id = $queried_object->term_id;
			
			if( get_field('breadcrumb_last_node', $taxonomy . '_' . $term_id) )
			{
				// Последний узел для тех категорий, где он указан
				echo the_field('breadcrumb_last_node', $taxonomy . '_' . $term_id);
			}
			elseif ( $taxonomy !== "product_cat" && $taxonomy !== "product_tag" && get_field('breadcrumb_last_node')) 
			{
				// Последний узел для тех товаров, где он указан
				echo the_field('breadcrumb_last_node'); 
			}
			elseif ( $taxonomy === "product_tag" ) 
			{
				echo "Запчасти для котла " . woocommerce_page_title(false); // false - отменяет echo внутри функции
			}else{
				echo esc_html( $crumb[0] );
			}

		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}
