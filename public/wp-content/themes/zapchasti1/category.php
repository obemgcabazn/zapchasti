<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 31.07.2017
 * Time: 15:17
 */
get_header(); ?>

	<div class="col-12 col-md-9">
		<div class="row">
			<?php
			if (have_posts()):
				while (have_posts()) : the_post();?>
				
					<div class="col-12 col-md-6">
				
					<?php
					echo '<a href="' . get_permalink() .  '" class="category-article-title-link"><h2 class="category-article-title">' . get_the_title() . '</h2></a>';
					the_content(); ?>
					
					</div>
			
				<?php
				endwhile;
			endif;
			?>
		</div>
	</div>

<?php get_footer(); ?>