<?php
/**
 * Blog Settings
 *
 * Register Blog Settings section, settings and controls for Theme Customizer
 *
 * @package THEMENAME
 */

/**
 * Adds blog settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function customize_register_blog_settings( $wp_customize ) {

	// Add Sections for Post Settings.
	$wp_customize->add_section( 'section_bcay(
		'title'    => esc_html__( 'Blog Settings', 'TheCreativityArchitect' ),
		'priority' => 30,
		'panel' => 'options_panel',
	) );


	// Add Settings and Controls for blog layout.
	$wp_customize->add_setting( 'blog_layout', array(
		'default'           => 'default',
		'sanitize_callback' => 'sanitize_select',
	) );

	$wp_customize->add_control( 'blog_layout', array(
		'label'    => esc_html__( 'Blog Layout', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'settings' => 'blog_layout',
		'type'     => 'select',
		'choices'  => array(
			'default' => esc_html__( 'Default With Sidebar', 'TheCreativityArchitect' ),
			'large'  => esc_html__( 'Large Full Width No Sidebar', 'TheCreativityArchitect' ),
		),
	) );

	// Add Settings and Controls for blog content.
	$wp_customize->add_setting( 'blog_content', array(
		'default'           => 'excerpt',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_select',
	) );

	$wp_customize->add_control( 'blog_content', array(
		'label'    => esc_html__( 'Blog Summary Type', 'TheCreativityArchitect' ),
		'description' => esc_html__( 'This will let you choose to use excerpts for your blog summaries. This is ONLY for the Default Right Sidebar blog layout.', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'settings' => 'blog_content',
		'type'     => 'radio',
		'choices'  => array(
			'index'   => esc_html__( 'Post Summary', 'TheCreativityArchitect' ),
			'excerpt' => esc_html__( 'Post Excerpt', 'TheCreativityArchitect' ),
		),
	) );

	// Add Setting and Control for Excerpt Length.
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => 35,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => esc_html__( 'Excerpt Length', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'number',
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 1,
        ),
	) );

	// Add Partial for Blog Layout and Excerpt Length.
	$wp_customize->selective_refresh->add_partial( 'blog_content_partial', array(
		'selector'         => '.blog-summary',
		'settings'         => array(
			'blog_layout',
			'blog_content',
			'excerpt_length',
		),
		'render_callback'  => 'customize_partial_blog_content',
		'fallback_refresh' => false,
	) );

	// Add Post Layout Headline.
	$wp_customize->add_control( new Customize_Header_Control(
		$wp_customize, 'summary_showhide_option', array(
			'label' => esc_html__( 'Summary Show or Hide Elements', 'TheCreativityArchitect' ),
			'section' => 'section_blog',
			'settings' => array(),
		)
	) );


	// Add Setting and Control for showing featured label.
	$wp_customize->add_setting( 'show_featured_label', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_featured_label', array(
		'label'    => esc_html__( 'Hide Featured Label', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing summary meta.
	$wp_customize->add_setting( 'show_summary_meta', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_summary_meta', array(
		'label'    => esc_html__( 'Hide Post Summary Meta Info', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing summary image.
	$wp_customize->add_setting( 'show_summary_image', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_summary_image', array(
		'label'    => esc_html__( 'Hide Post Summary Featured Image', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing summary author.
	$wp_customize->add_setting( 'show_summary_author', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_summary_author', array(
		'label'    => esc_html__( 'Hide Post Summary By Author', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing summary date.
	$wp_customize->add_setting( 'show_summary_date', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_summary_date', array(
		'label'    => esc_html__( 'Hide Post Summary Date', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing summary comments.
	$wp_customize->add_setting( 'show_summary_comments', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_summary_comments', array(
		'label'    => esc_html__( 'Hide Post Summary Comment Count', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing edit link
	$wp_customize->add_setting( 'show_edit', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_checkbox',
	) );

	$wp_customize->add_control( 'show_edit', array(
		'label'    => esc_html__( 'Hide Edit Links on Pages &amp; Posts', 'TheCreativityArchitect' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',
	) );

}
add_action( 'customize_register', 'customize_register_blog_settings' );

/**
 * Render the blog content for the selective refresh partial.
 */
function customize_partial_blog_content() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/post/content', get_post_format() );
	}
}
