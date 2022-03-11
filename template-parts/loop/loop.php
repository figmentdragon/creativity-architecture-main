<?php if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>
			<?php the_title( '<h3>', '</h3>' );
			the_post_thumbnail();
			the_excerpt();
			?>
				<?php the_content(); ?>

		<?php endwhile; ?>

		<?php else:

			_e( 'Sorry, no posts matched your criter.', 'textdomain' ); ?>

<?php endif;
