<?php
/**
 * Post Settings
 *
 * Register Post Settings section, settings and controls for Theme Customizer
 *
 * @package THEMENAME
 */

/**
 * Adds post settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function THEMENAME_customize_register_post_settings( $wp_customize ) {

	// Add Sections for Post Settings.
	$wp_customize->add_section( 'THEMENAME_section_post', array(
		'title'    => esc_html__( 'Post Settings', 'TheCreativityArchitect' ),
		'priority' => 40,
		'panel' => 'THEMENAME_options_panel',
	) );

	// Add Settings and Controls for Layout.
	$wp_customize->add_setting( 'THEMENAME_single_layout', array(
		'default'           => 'single-default',
		'sanitize_callback' => 'THEMENAME_sanitize_select',
	) );

	$wp_customize->add_control( 'THEMENAME_single_layout', array(
		'label'    => esc_html__( 'Full Post Layout', 'TheCreativityArchitect' ),
		'description' => esc_html__( 'This will let you choose your full post layout.', 'TheCreativityArchitect' ), 
		'section'  => 'THEMENAME_section_post',
		'type'     => 'radio',
		'choices'  => array(
			'single-default' => esc_html__( 'Post With Sidebar', 'TheCreativityArchitect' ),
			'single-centered' => esc_html__( 'Post Full Width Centered No Sidebar', 'TheCreativityArchitect' ),	
		),
	) );	

	// Add Partial for single Layout
	$wp_customize->selective_refresh->add_partial( 'THEMENAME_customize_partial_single_post', array(
		'selector'         => '#single-layout',
		'settings'         => array(
			'THEMENAME_single_layout',
		),
		'render_callback'  => 'THEMENAME_customize_partial_single_content',
		'fallback_refresh' => false,
	) );
	
	
	// Add Single Post Headline.
	$wp_customize->add_control( new THEMENAME_Customize_Header_Control(
		$wp_customize, 'THEMENAME_theme_options[single_post]', array(
			'label' => esc_html__( 'Show or Hide Post Elements', 'TheCreativityArchitect' ),
			'section' => 'THEMENAME_section_post',
			'settings' => array(),
		)
	) );

	// Add Setting and Control for showing summary image.
	$wp_customize->add_setting( 'THEMENAME_show_single_image', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_show_single_image', array(
		'label'    => esc_html__( 'Hide Full Post Featured Image', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );	
	
	// Add Setting and Control for showing post full meta info
	$wp_customize->add_setting( 'THEMENAME_single_meta_info', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'THEMENAME_single_meta_info', array(
		'label'    => esc_html__( 'Hide Full Post Meta Info', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );		

	// Add Setting and Control for showing summary author.
	$wp_customize->add_setting( 'THEMENAME_show_single_author', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_show_single_author', array(
		'label'    => esc_html__( 'Hide Full Post By Author', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing summary date.
	$wp_customize->add_setting( 'THEMENAME_show_single_date', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_show_single_date', array(
		'label'    => esc_html__( 'Hide Full Post Date', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );

	// Add Setting and Control for showing summary comments.
	$wp_customize->add_setting( 'THEMENAME_show_single_comments', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_show_single_comments', array(
		'label'    => esc_html__( 'Hide Full Post Comment Count', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );			

	// Add Setting and Control for showing post categories.
	$wp_customize->add_setting( 'THEMENAME_footer_categories', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_footer_categories', array(
		'label'    => esc_html__( 'Hide Categories', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );
	
	// Add Setting and Control for showing post tags.
	$wp_customize->add_setting( 'THEMENAME_footer_tags', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_footer_tags', array(
		'label'    => esc_html__( 'Hide Tags', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );		
	// Add Setting and Control for showing author avatar
	$wp_customize->add_setting( 'THEMENAME_display_author_bio', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_display_author_bio', array(
		'label'    => esc_html__( 'Hide Author Bio', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );	
	
	// Add Setting and Control for showing post navigation.
	$wp_customize->add_setting( 'THEMENAME_post_navigation', array(
		'default'           => false,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'THEMENAME_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'THEMENAME_post_navigation', array(
		'label'    => esc_html__( 'Hide previous/next post navigation', 'TheCreativityArchitect' ),
		'section'  => 'THEMENAME_section_post',
		'type'     => 'checkbox',
	) );

}
add_action( 'customize_register', 'THEMENAME_customize_register_post_settings' );


/**
 * Render single posts partial
 */
function THEMENAME_customize_partial_single_post() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/post/content', 'single' );
	}
}
