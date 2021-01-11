<?php
/*
Template Name: Шаблон главной страницы
*/

get_header(); 

$companies['lemax'] = 'lemaks.jpg';
$companies['bauertherm'] = 'bauertherm.png';
$companies['signal'] = 'signal.jpg';
$companies['sime'] = 'sime.jpg';
$companies['ariston'] = 'ariston.jpg';
$companies['atem'] = 'atem.jpg';
$companies['chaffoteaux'] = 'chaffoteaux.jpg';
$companies['beretta'] = 'beretta.jpg';
$companies['de-dietrich'] = 'dedietrich.jpg';
$companies['konord'] = 'konord.jpg';
$companies['mimax'] = 'mimax.png';
$companies['protherm'] = 'protherm.jpg';
// $companies['unical'] = 'unical.jpg';
$companies['vaillant'] = 'vaillant.jpg';
// $companies['baltgaz'] = 'baltgaz.png';
$companies['baxi'] = 'baxi.png';
$companies['borinskoe'] = 'borinskoe.png';
// $companies['buderus'] = 'buderus.png';
$companies['dani'] = 'dani.png';
$companies['danko'] = 'danko.png';
$companies['ferroli'] = 'ferroli.png';
$companies['hermann'] = 'hermann.png';
$companies['immergas'] = 'immergas.png';
$companies['rostovgazoapparat'] = 'rga.png';
$companies['thermona'] = 'thermona.png';
$companies['zhukovsky'] = 'zhukovsky.png';
$companies['innovita'] = 'innovita.jpg';
$companies['innovita'] = 'innovita.jpg';
$companies['nmz'] = 'nmz.jpg';
$companies['irbis'] = 'irbis.png';
$companies['rossen'] = 'rossen.jpg';
$companies['servisgaz'] = 'servisgaz.png';

?>

<div class="col-12 col-md-8 col-lg-9">
  <div class="row">
    <div class="col">
      <a class="d-block my-3" href="/category/gazovye-klapany/" title="Распродажа газовых клапанов Sit"><img src="/img/banners/sale-valves.jpg" alt=""></a>
    </div>
  </div>
  

  <div class="row">
    <div class="col-12">
      <h1>Запчасти для газовых котлов российского и импортного производства</h1>
    </div>
  </div>
  

  <div class="row">
  <?php 

  foreach ($companies as $key => $value) { ?>
    <div class="col-6 col-md-3">
      <div class="b__vendor-link-wrapper text-center">
    <?='<a href="/tag/' . $key . '/">
        <div class="ie-wrapper">
          <img src="' . get_template_directory_uri() . '/img/logo/' . $value . '" alt="Запчасти для котла ' . $key .'" >
          </div>
        </a>'?>
      </div>
    </div>
  <?php } ?>
  </div>

  <div class="row">
    <div class="col-12">
      <h2>Запчасти для газовых водонагревателей (колонок)</h2>
    </div>
  </div>

  <div class="row">
    <div class="col-6 col-md-3">
      <div class="b__vendor-link-wrapper text-center">
        <a href="/tag/kolonka-beretta/">
          <div class="ie-wrapper">
            <img src="<?=get_template_directory_uri()?>/img/logo/beretta.jpg" alt="Запчасти для колонок Beretta">
          </div>
        </a>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="b__vendor-link-wrapper text-center">
        <a href="/tag/kolonka-baxi/">
          <div class="ie-wrapper">
            <img src="<?=get_template_directory_uri()?>/img/logo/baxi.png" alt="Запчасти для колонок BAXI">
          </div>
        </a>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="b__vendor-link-wrapper text-center">
        <a href="/tag/kolonka-innovita/">
          <div class="ie-wrapper">
            <img src="<?=get_template_directory_uri()?>/img/logo/innovita.jpg" alt="Запчасти для колонок Innovita">
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <h2>Запчасти для профессионального газового кухонного оборудования</h2>
    </div>
  </div>

  <div class="row">
    <div class="col-6 col-md-3">
      <div class="b__vendor-link-wrapper text-center">
        <a href="/tag/vulkan/">
          <div class="ie-wrapper">
            <img src="<?=get_template_directory_uri()?>/img/logo/vulkan.png" alt="Запчасти для газовых плит Вулкан">
          </div>
        </a>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="b__vendor-link-wrapper text-center">
        <a href="/tag/abat/">
          <div class="ie-wrapper">
            <img src="<?=get_template_directory_uri()?>/img/logo/abat.jpg" alt="Запчасти для Абат">
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <h3 class="text-center">Популярные товары</h3>
      <?php echo do_shortcode('[slick]'); ?>
    </div>
  </div>

</div>
</div> <!-- row -->
</div><!-- container -->
</div><!-- wrapper -->

<h2 class="text-center">Наши преимущества</h2>

<div class="container">

  <div id="advantages-wrap">
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="wrapper" style="height:558px;">
          <h3 class="text-center">Прямые поставки</h3>
          <a data-fancybox="exclusives" href="/files/exclusive/polidoro.jpg"><img src="/files/exclusive/polidoro-min.jpg"></a>
          <a data-fancybox="exclusives" href="/files/exclusive/sit.jpg"><img src="/files/exclusive/sit-min.jpg"></a>
          <a data-fancybox="exclusives" href="/files/exclusive/zilmet.jpg"><img src="/files/exclusive/zilmet-min.jpg"></a>

          <p class="mt-3">Являясь <b>официальным дистрибьютором</b> европейских производителей Группа компаний «Электропомпа» осуществляет прямые поставки комплектующих на российский рынок.</p>
          <p>На все запасные части предоставляется гарантия.</p>
          <p>Обеспечиваем оперативное решение гарантийных случаев.</p>
          </p>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="wrapper">
          <h3 class="text-center">Большой современный склад</h3>
          <img src="/img/sklad-min.jpg" alt="Склад">
          <p class="mt-3">Текущие складские возможности позволяют гарантировать большой запас комплектующих и оптимальные сроки поставки.
            <ul>
              <li>Оперативная отгрузка заказов любых объемов</li>
              <li>Удобное расположение склада</li>
            </ul>
          </p>
        </div>
      </div>
    </div>

    <div class="wrapper">
      <div class="row">
        <div class="col-12 col-md-7">
          <h3>Техническая поддержка</h3>
          <p>Опытные специалисты Группы компаний «Электропомпа» оказывают техническую поддержку производителям отопительного оборудования в подборе комплектующих.</p>
          <p>Предоставляются услуги по созданию чертежей атмосферных газовых горелок в соответствии с техническими параметрами заказчика, а также осуществляется поставка опытных образцов горелок.</p>
          <p>Подробнее читайте в разделе <a href="/sotrudnichestvo/" title="Сотрудничество" target="_blank">Сотрудничество</a></p>
        </div>
        <div class="col-12 col-md-5">
          <img src="/img/sborka4.jpg" alt="Сборка газогорелочных устройств">
        </div>
      </div>
    </div>
  </div>
</div>



<?php get_footer(); ?>