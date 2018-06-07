<?php
/*
Template Name: Шаблон страницы контактов
*/
?>
<?php get_header(); ?>
	

	<div class="col-12 col-md-8 col-lg-9">
		<?php
		if (have_posts()):
		  while (have_posts()) : the_post();
				the_content();
		  endwhile;
		endif;
		?>
		
	</div>

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script>
ymaps.ready(init);
var dolMap, 
dolPlacemark,
samaraMap,
samaraPlacemark;

function init(){ 
  dolMap = new ymaps.Map ("map", {
    center: [55.921815, 37.512864],
    zoom: 13
  }); 

  dolPlacemark = new ymaps.Placemark([55.921791, 37.512234], {
    hintContent: 'ГК Электропомпа',
    balloonContent: 'г. Долгопрудный, Лихачевский пр-зд, д.8'
  });

  dolMap.geoObjects.add(dolPlacemark);
  dolMap.controls.add( new ymaps.control.ZoomControl() );
}
</script>

<?php get_footer(); ?>