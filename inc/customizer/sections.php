<?php
/**
 * Customizer sections.
 *
 * @package creativity architect
 */

/**
 * Register the section sections.
 *
 * @author WebDevStudios
 * @param object $wp_customize Instance of WP_Customize_Class.
 */
function customize_sections( $wp_customize ) {

	// Register additional scripts section.
	$wp_customize->add_section(
		'additional_scripts_section',
		[
			'title'    => esc_html__( 'Additional Scripts', 'creativityarchitect' ),
			'priority' => 10,
			'panel'    => 'site-options',
		]
	);

	// Register a social links section.
	$wp_customize->add_section(
		'social_links_section',
		[
			'title'       => esc_html__( 'Social Media', 'creativityarchitect' ),
			'description' => esc_html__( 'Links here power the display_social_network_links() template tag.', 'creativityarchitect' ),
			'priority'    => 90,
			'panel'       => 'site-options',
		]
	);

	// Register a header section.
	$wp_customize->add_section(
		'header_section',
		[
			'title'    => esc_html__( 'Header Customizations', 'creativityarchitect' ),
			'priority' => 90,
			'panel'    => 'site-options',
		]
	);

	// Register a footer section.
	$wp_customize->add_section(
		'footer_section',
		[
			'title'    => esc_html__( 'Footer Customizations', 'creativityarchitect' ),
			'priority' => 90,
			'panel'    => 'site-options',
		]
	);
}
add_action( 'customize_register', 'customize_sections' );

function display_scaffolding_section( $args = [] ) {
	// Set defaults.
	$defaults = [
		'title'       => '', // The scaffolding title.
		'description' => '', // The scaffolding description.
		'usage'       => '', // The template tag or markup needed to display the scaffolding.
		'parameters'  => [], // Does the scaffolding have params? Like $args?
		'arguments'   => [], // If the scaffolding has params, what are the $args?
		'output'      => '', // Use the template tag or scaffolding HTML markup here. It will be sanitized displayed.
	];

	// Parse arguments.
	$args = wp_parse_args( $args, $defaults );

	// Grab our allowed tags.
	$allowed_tags = scaffolding_allowed_html();

	// Add a unique class to the wrapper.
	$class = 'scaffolding-' . str_replace( ' ', '-', strtolower( $args['title'] ) ); ?>

	<div class="scaffolding-document accordion <?php echo esc_attr( $class ); ?>">

		<div class="accordion-item">
			<?php if ( $args['title'] ) : ?>
			<header class="scaffolding-document-header display-flex flex-start space-between accordion-item-header">
				<h3 class="scaffolding-document-title accordion-item-title"><?php echo esc_html( $args['title'] ); ?></h3>
				<button type="button" class="scaffolding-button"><?php esc_html_e( 'Details', 'creativityarchitect' ); ?></button>
			</header><!-- .scaffolding-document-header -->
			<?php endif; ?>

			<div class="scaffolding-document-content accordion-item-content">

				<div class="scaffolding-document-details">

				<?php if ( $args['description'] ) : ?>
					<p><strong><?php esc_html_e( 'Description', 'creativityarchitect' ); ?>:</strong></p>
					<p class="scaffolding-document-description"><?php echo esc_html( $args['description'] ); ?></p>
				<?php endif; ?>

				<?php if ( $args['parameters'] ) : ?>
					<p><strong><?php esc_html_e( 'Parameters', 'creativityarchitect' ); ?>:</strong></p>
					<?php foreach ( $args['parameters'] as $key => $value ) : ?>
						<p><code><?php echo esc_html( $key ); ?></code> <?php echo esc_html( $value ); ?></p>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php if ( $args['arguments'] ) : ?>
					<p><strong><?php esc_html_e( 'Arguments', 'creativityarchitect' ); ?>:</strong></p>
					<?php foreach ( $args['arguments'] as $key => $value ) : ?>
						<p><code><?php echo esc_html( $key ); ?></code> <?php echo esc_html( $value ); ?></p>
					<?php endforeach; ?>
				<?php endif; ?>

				</div><!-- .scaffolding-document-details -->

				<div class="scaffolding-document-usage">

				<?php if ( $args['usage'] ) : ?>
					<p><strong><?php esc_html_e( 'Usage', 'creativityarchitect' ); ?>:</strong></p>
					<pre><?php echo esc_html( $args['usage'] ); ?></pre>
				<?php endif; ?>

				<?php if ( $args['output'] ) : ?>
					<p><strong><?php esc_html_e( 'HTML Output', 'creativityarchitect' ); ?>:</strong></p>
					<pre><?php echo esc_html( $args['output'] ); ?></pre>
				<?php endif; ?>

				</div><!-- .scaffolding-document-usage -->
			</div><!-- .scaffolding-document-content -->
		</div>

		<div class="scaffolding-document-live">

		<?php if ( $args['output'] ) : ?>
			<?php echo do_shortcode( wp_kses( $args['output'], $allowed_tags ) ); ?>
		<?php endif; ?>

		</div><!-- .scaffolding-document-live -->
	</div><!-- .scaffolding-document -->

	<?php
}

function display_global_scaffolding_section( $args = [] ) {
	// Set defaults.
	$defaults = [
		'global_type' => '', // Can be 'colors' or 'fonts'.
		'title'       => '', // Give the section a title.
		'arguments'   => [], // Use key => value pairs to pass colors or fonts.
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Add a unique class to the wrapper.
	$class = 'scaffolding-' . str_replace( ' ', '-', strtolower( $args['title'] ) );
	?>

	<div class="scaffolding-document <?php echo esc_attr( $class ); ?>">
		<header class="scaffolding-document-header">
			<h3 class="scaffolding-document-title"><?php echo esc_html( $args['title'] ); ?></h3>
		</header>

		<div class="scaffolding-document-content">

			<?php
			// We'll alter the output slightly depending upon the global type.
			switch ( $args['global_type'] ) :
				case 'colors':
					?>

					<div class="swatch-container display-flex">

					<?php
					// Grab the array of colors.
					$colors = $args['arguments'];

					foreach ( $colors as $name => $hex ) :
						$color_var = '$color-' . str_replace( ' ', '-', strtolower( $name ) );
						?>

						<div class="swatch quarter" style="background-color: <?php echo esc_attr( $hex ); ?>;">
							<header><?php echo esc_html( $name ); ?></header>
							<footer><?php echo esc_html( $color_var ); ?></footer>
						</div><!-- .swatch -->

					<?php endforeach; ?>
					</div>

					<?php
					break;
				case 'fonts':
					?>

					<div class="font-container">

					<?php
					// Grab the array of fonts.
					$fonts = $args['arguments'];

					foreach ( $fonts as $name => $family ) :
						$font_var = '$font-' . str_replace( ' ', '-', strtolower( $name ) );
						?>

						<p><strong><?php echo esc_html( $font_var ); ?>:</strong> <span style="font-family: <?php echo esc_attr( $family ); ?>"><?php echo esc_html( $family ); ?></span></p>
					<?php endforeach; ?>
					</div>
					<?php
					break;
				default:
					?>
			<?php endswitch; ?>
		</div>
	</div>
	<?php
}
