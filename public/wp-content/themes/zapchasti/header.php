<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title><?=get_title()?></title>
  <meta name="description" content="<?=get_description()?>">
  <meta name="keywords" content="<?=get_keywords()?>">

  <link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="yandex-verification" content="20538be11bc15f36" />

  <?php wp_head(); ?>
</head>
<body id="top">
  <header>
    <div class="top-header-menu-wrap">
      <div class="container">
        <div class="row">
         <div class="col-xl-9">
           <?=print_top_menu()?>
         </div>
	        <div class="col-xl-3">
		        <?php dynamic_sidebar( 'search' ); ?>
	        </div>
        </div>
      </div>
    </div>

    <div class="header-line">
      <div class="container">
        <div class="row align-items-center no-gutters">
          <div class="col-12 col-md-3 col-lg-3">
            <div class="logo">
              <a href="/"><img src="/img/logo.svg"></a>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 offset-lg-1 col-lg-4">
            <div class=" text-center text-sm-left">
              <a href="/contact/" title="Контакты" class="address">МО, г. Долгопрудный, Лихачевский пр-д, д.8</a>
              <br class="hidden-md-up">
              <p class="time">Пн-Чт: <span class="working-time">с 9:00 до 18:00</span>,
	              <br class="hidden-md-up">
	              Пт: <span class="working-time">с 9:00 до 17:00</span></p>
            </div>
          </div>
	        <div class="col-lg-2">
		        <a href="/cart/" class="cart">
			        <div class="cart-count"><?=cart_count()?></div>
			        <img src="/img/cart.svg" alt="Корзина" class="cart-icon">
			        Корзина</a>
	        </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-2">
            <div class="phones text-center text-sm-right">
              <p class="header-primary-phone">8 800 100 00 77</p>
              <small class="free-call-text">Звонок по России бесплатный</small>
	            <a href="mailto:info@zapchasti-kotla.ru" class="primary-email">info@zapchasti-kotla.ru</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="breadcrumbs-wrapper">
	  <div class="container">
		  <div class="row">
			  <div class="col-12">
				  <?php do_action('breadcrumbs'); ?>
			  </div>
		  </div>
	  </div>
  </div>
  
  <main <?=is_front_page()?'id="homepage"':''?>>
	  <div class="wrapper">
		  <div class="container">
			  <div class="row  justify-content-md-center">
				  <?php if (!is_front_page() && !is_cart() ){ ?>
				  <div class="col-12 col-md-4 col-lg-3">
					  <?=print_aside_menu()?>
				  </div>
				  <?php } ?>