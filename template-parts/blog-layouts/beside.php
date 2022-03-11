<?php
/**
 * Blog Layout | Beside.
 *
 * @package TheCreativityArchitect
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$template_parts         = blog_layout();
$template_parts_header  = $template_parts['template_parts_header'];
$template_parts_content = $template_parts['template_parts_content'];
$template_parts_footer  = $template_parts['template_parts_footer'];
$style                  = $template_parts['style'];
$post_classes           = array( 'blog-layout-beside' );
$post_classes[]         = 'post-style-' . $style;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?> <?php archive_schema_markup(); ?>>

	<?php if ( has_post_thumbnail() ) { ?>

	<div class="grid grid-medium">

		<header class="article-header large-2-5">

			<?php get_template_part( 'inc/template-parts/blog/blog-featured' ); ?>

		</header>

		<div class="large-3-5">

	<?php } ?>

		<section class="article-content">

			<?php
			if ( ! empty( $template_parts_header ) && is_array( $template_parts_header ) ) {
				foreach ( $template_parts_header as $part ) {
					if ( 'featured' !== $part ) {
						get_template_part( 'inc/template-parts/blog/blog-' . $part );
					}
				}
			}
			?>

			<div class="entry-summary" itemprop="text">

				<?php
				if ( ! empty( $template_parts_content ) && is_array( $template_parts_content ) ) {
					if ( in_array( 'post', $template_parts_content ) ) {
							the_content();
					} elseif ( in_array( 'excerpt', $template_parts_content ) ) {
							the_excerpt();
					}
				}
				?>

				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'TheCreativityArchitect' ),
					'after'  => '</div>',
				) );
				?>

			</div>

		</section>

		<?php if ( $template_parts_footer != false ) { ?>

		<footer class="article-footer">

			<?php
			if ( ! empty( $template_parts_footer ) && is_array( $template_parts_footer ) ) {
				foreach ( $template_parts_footer as $part ) {
					get_template_part( 'inc/template-parts/blog/blog-' . $part );
				}
			}
			?>

		</footer>

		<?php } ?>

	<?php if ( has_post_thumbnail() ) { ?>

		</div>

	</div>

	<?php } ?>

</article>
