<?php get_header(); ?>
	

		<?php 
		if( is_front_page() ){ ?>
			<div class="col-12 col-md-12">
		<?php } elseif (is_cart()) { ?>
			<div class="col-12 col-lg-8">
		<?php }else{ ?>
			<div class="col-12 col-md-8 col-lg-9">
		<?php
			}
				if (have_posts()):
				  while (have_posts()) : the_post();
						the_content();
				  endwhile;
				endif;
				?>
				
			</div>

<?php get_footer(); ?>