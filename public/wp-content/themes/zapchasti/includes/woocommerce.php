<?php
/* ХУКИ WOOCOMMERCE */

/* убираем разброс цен */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

//Убираем "Найдено результатов" из категории
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

//Убрать кнопку добавить в корзину в Категории
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

/* переносим артикул */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 6 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 6 );

/* убираем похожие товары */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


// Заголовок товара в категории
function woocommerce_template_loop_category_title( $category ) {
  echo '<h2 class="woocommerce-loop-category__title">' . $category->name . '</h2>';
}

function woocommerce_subcategory_thumbnail( $category ) {
  $small_thumbnail_size   = apply_filters( 'subcategory_archive_thumbnail_size', 'shop_catalog' );
  $dimensions             = wc_get_image_size( $small_thumbnail_size );
  $thumbnail_id           = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
  
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
//add_filter('raw_woocommerce_price', 'raw_in_euro');
function raw_in_euro($val)
{
//  return($val);
  return $val * (float) get_field( 'cur_val', 'option' );
}

//add_filter('woocommerce_get_price_including_tax', 'in_euro');
//function in_euro($return_price){
//  return $return_price;
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
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 80;' ), 20 );

// Посчет количества товаров в корзине
function cart_count()
{
  global $woocommerce;
  $count = $woocommerce->cart->cart_contents_count;
  return $count;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'breadcrumbs', 'woocommerce_breadcrumb', 10 );

add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

function woocommerce_template_loop_product_title() {
  echo '<span class="woocommerce-loop-product__title">' . get_the_title() . '</span>';
}


if ( ! function_exists( 'woocommerce_form_field' ) ) {

  /**
   * Outputs a checkout/address form field.
   *
   * @param string $key Key.
   * @param mixed  $args Arguments.
   * @param string $value (default: null).
   * @return string
   */
  function woocommerce_form_field( $key, $args, $value = null ) {
    $defaults = array(
      'type'              => 'text',
      'label'             => '',
      'description'       => '',
      'placeholder'       => '',
      'maxlength'         => false,
      'required'          => false,
      'autocomplete'      => false,
      'id'                => $key,
      'class'             => array(),
      'label_class'       => array(),
      'input_class'       => array(),
      'return'            => false,
      'options'           => array(),
      'custom_attributes' => array(),
      'validate'          => array(),
      'default'           => '',
      'autofocus'         => '',
      'priority'          => '',
    );

    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

    if ( $args['required'] ) {
      $args['class'][] = 'validate-required';
      $required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
    } else {
      $required = '';
    }

    if ( is_string( $args['label_class'] ) ) {
      $args['label_class'] = array( $args['label_class'] );
    }

    if ( is_null( $value ) ) {
      $value = $args['default'];
    }

    // Custom attribute handling.
    $custom_attributes         = array();
    $args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

    if ( $args['maxlength'] ) {
      $args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
    }

    if ( ! empty( $args['autocomplete'] ) ) {
      $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
    }

    if ( true === $args['autofocus'] ) {
      $args['custom_attributes']['autofocus'] = 'autofocus';
    }

    if ( $args['description'] ) {
      $args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
    }

    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
      foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
      }
    }

    if ( ! empty( $args['validate'] ) ) {
      foreach ( $args['validate'] as $validate ) {
        $args['class'][] = 'validate-' . $validate;
      }
    }

    $field           = '';
    $label_id        = $args['id'];
    $sort            = $args['priority'] ? $args['priority'] : '';
    $field_container = '<div class="%1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div>';

    switch ( $args['type'] ) {
      case 'country':
        $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

        if ( 1 === count( $countries ) ) {

          $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

          $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';

        } else {

          $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '><option value="">' . esc_html__( 'Select a country&hellip;', 'woocommerce' ) . '</option>';

          foreach ( $countries as $ckey => $cvalue ) {
            $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
          }

          $field .= '</select>';

          $field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '">' . esc_html__( 'Update country', 'woocommerce' ) . '</button></noscript>';

        }

        break;
      case 'state':
        /* Get country this state field is representing */
        $for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
        $states      = WC()->countries->get_states( $for_country );

        if ( is_array( $states ) && empty( $states ) ) {

          $field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

          $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" />';

        } elseif ( ! is_null( $for_country ) && is_array( $states ) ) {

          $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
            <option value="">' . esc_html__( 'Select a state&hellip;', 'woocommerce' ) . '</option>';

          foreach ( $states as $ckey => $cvalue ) {
            $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
          }

          $field .= '</select>';

        } else {

          $field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

        }

        break;
      case 'textarea':
        $field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';

        break;
      case 'checkbox':
        $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
            <input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

        break;
      case 'text':
      case 'password':
      case 'datetime':
      case 'datetime-local':
      case 'date':
      case 'month':
      case 'time':
      case 'week':
      case 'number':
      case 'email':
      case 'url':
      case 'tel':
        $field .= '<div class="col-12"><input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' /></div>';

        break;
      case 'select':
        $field   = '';
        $options = '';

        if ( ! empty( $args['options'] ) ) {
          foreach ( $args['options'] as $option_key => $option_text ) {
            if ( '' === $option_key ) {
              // If we have a blank option, select2 needs a placeholder.
              if ( empty( $args['placeholder'] ) ) {
                $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
              }
              $custom_attributes[] = 'data-allow_clear="true"';
            }
            $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
          }

          $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
              ' . $options . '
            </select>';
        }

        break;
      case 'radio':
        $label_id = current( array_keys( $args['options'] ) );

        if ( ! empty( $args['options'] ) ) {
          foreach ( $args['options'] as $option_key => $option_text ) {
            $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
            $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>';
          }
        }

        break;
    }

    if ( ! empty( $field ) ) {
      $field_html = '';

      if ( $args['label'] && 'checkbox' !== $args['type'] ) {
        $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
      }

      $field_html .= /*'<span class="woocommerce-input-wrapper">' . */ $field;

      if ( $args['description'] ) {
        $field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
      }

      //$field_html .= '</span>';

      $container_class = esc_attr( implode( ' ', $args['class'] ) );
      $container_id    = esc_attr( $args['id'] ) . '_field';
      $field           = sprintf( $field_container, $container_class, $container_id, $field_html );
    }

    /**
     * Filter by type.
     */
    $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

    /**
     * General filter on form fields.
     *
     * @since 3.4.0
     */
    $field = apply_filters( 'woocommerce_form_field', $field, $key, $args, $value );

    if ( $args['return'] ) {
      return $field;
    } else {
      echo $field; // WPCS: XSS ok.
    }
  }
}

// Формы для заказа
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $f ) {
    unset($f['billing']['billing_company']);
    unset($f['billing']['billing_last_name']);
    // unset($f['billing']['billing_country']);
    // unset($f['billing']['billing_city']);
    // unset($f['billing']['billing_address_1']);
    // unset($f['billing']['billing_address_2']);
    unset($f['billing']['billing_state']);
    unset($f['billing']['billing_postcode']);

    $f['billing']['billing_first_name']['label'] = 'Имя и фамилия';
    $f['billing']['billing_first_name']['placeholder'] = 'Введите ФИО';
    $f['billing']['billing_first_name']['class'][0] = '';
    $f['billing']['billing_first_name']['class'][1] = 'col-lg-6 mb-3';
    $f['billing']['billing_first_name']['label_class'][0] = 'col-12';
    $f['billing']['billing_first_name']['input_class'][0] = 'col-12';

    $f['billing']['billing_city']['class'][0] = '';
    $f['billing']['billing_city']['class'][1] = 'col-lg-6 mb-3';
    $f['billing']['billing_city']['label_class'][0] = 'col-12';
    $f['billing']['billing_city']['input_class'][0] = 'col-12';
    $f['billing']['billing_city']['required'] = false;

    // $f['billing']['billing_postcode']['class'][0] = '';
    // $f['billing']['billing_postcode']['class'][1] = 'col-lg-6 mb-3';
    // $f['billing']['billing_postcode']['label_class'][0] = 'col-12';
    // $f['billing']['billing_postcode']['input_class'][0] = 'col-12';

    $f['billing']['billing_country']['class'][0] = '';
    $f['billing']['billing_country']['class'][2] = 'col-lg-6 mb-3 d-none';
    $f['billing']['billing_country']['label_class'][0] = 'col-12';
    $f['billing']['billing_country']['input_class'][0] = 'col-12';

    $f['billing']['billing_address_1']['class'][0] = '';
    $f['billing']['billing_address_1']['class'][2] = 'col-lg-6 mb-3 d-none';
    $f['billing']['billing_address_1']['label_class'][0] = 'col-12';
    $f['billing']['billing_address_1']['input_class'][0] = 'col-12';
    $f['billing']['billing_address_1']['label'] = 'Адрес доставки';
    $f['billing']['billing_address_1']['required'] = false;

    $f['billing']['billing_phone']['class'][0] = '';
    $f['billing']['billing_phone']['class'][2] = 'col-lg-6 mb-3';
    $f['billing']['billing_phone']['label_class'][0] = 'col-12';
    $f['billing']['billing_phone']['input_class'][0] = 'col-12';

    $f['billing']['billing_email']['class'][0] = '';
    $f['billing']['billing_email']['class'][2] = 'col-lg-6 mb-3';
    $f['billing']['billing_email']['label_class'][0] = 'col-12';
    $f['billing']['billing_email']['input_class'][0] = 'col-12';

    $f['order']['order_comments']['label'] = 'Комментарий к доставке';
    $f['order']['order_comments']['placeholder'] = 'По возможности, укажите марку и модель котла для которого покупаете запчасть';
    $f['order']['order_comments']['class'][2] = 'col-lg-12';
    $f['order']['order_comments']['label_class'][0] = 'd-block';
    $f['order']['order_comments']['input_class'][0] = 'w-100 mb-3';
    $f['order']['order_comments']['custom_attributes']['rows'] = '4';
    $f['order']['order_comments']['custom_attributes']['cols'] = '4';
    $f['order']['order_comments']['required'] = false;
    $f['order']['order_comments']['clear'] = true;

    // print_pre( $f );
    return $f;
}

function custom_override_default_address_fields( $address_fields ) {
  $address_fields['city'][ 'required' ] = 0;

  // print_pre( $address_fields );
  return $address_fields;
}
add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );

add_filter( 'woocommerce_cart_totals_order_total_html', 'delete_nds_tax_from_checkout', 10 );
function delete_nds_tax_from_checkout( $value ) {
  return preg_replace("/<small[^>]+?[^>]+>(.*?)<\/small>/i", '', $value);
}