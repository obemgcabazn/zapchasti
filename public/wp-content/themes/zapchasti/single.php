<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 31.07.2017
 * Time: 15:41
 */
get_header(); ?>
	
	<div class="col-12 col-md-8 col-lg-9">
		<?php
		if (have_posts()):
			while (have_posts()) : the_post();
				the_title();
				the_content();
			endwhile;
		endif;
		?>
	
	</div>

<?php get_footer(); ?>