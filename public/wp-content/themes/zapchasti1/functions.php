<?php
require 'includes/styles_scripts.php';
require 'includes/disable.php';
require 'includes/woocommerce.php';

if (function_exists('register_sidebar')) register_sidebar(array(
		'id' => 'search',
		'name' => 'Поиск',
		'before_title' => '',
		'after_title' => '',
		'before_widget' => '<div id="%1$s" class="search widget %2$s">',
		'after_widget' => '</div>'
));

// Вывод верхнего меню
function print_top_menu()
{
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
function print_aside_menu()
{
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
function get_title()
{
	$queried_object = get_queried_object();

	if($title = get_field('wc_title', $queried_object->taxonomy . '_' . $queried_object->term_id))
	{
		return $title;
	}
	elseif ($title = get_field('wc_title'))
	{
		return $title;
	}
	else
	{
		echo ltrim(wp_title("",false));
	}
}

//Выводит Описание страницы Description
function get_description() {
	
	$queried_object = get_queried_object();
	
	if($desc = get_field('wc_description', $queried_object->taxonomy . '_' . $queried_object->taxonomy))
	{
		return $desc;
	}
	else
	{
		the_field('wc_description');
	}
}

//Выводит Keywords
function get_keywords()
{
	$queried_object = get_queried_object();
	
	if($keywords = get_field('wc_keywords', $queried_object->taxonomy . '_' . $queried_object->term_id))
	{
		return $keywords;
	}
	else
	{
		the_field('wc_keywords');
	}
}

add_action( 'wp_print_styles', 'homepage_style_method', 99 );
function homepage_style_method () {
	if(is_front_page())
	{
		wp_enqueue_style( 'homepage-style', get_template_directory_uri() . "/css/homepage.css", '', '', '' );
	}
}