'<?php
/**
 * Basic Settings
 *
 * Register Basic Settings section, settings and controls for Theme Customizer
 *
 * @package TheCreativityArchitect
 */

/**
 * Adds post settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function customize_register_basic_settings( $wp_customize ) {

	$wp_customize->add_section( 'section_basic', array(
			'title'    => esc_html__( 'Basic Settings', 'TheCreativityArchitect' ),
			'priority' => 8,
			'panel' => 'options_panel',
		) );

	$wp_customize->add_setting( 'copyright', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	 );

	$wp_customize->add_control( 'copyright', array(
			'label'    => esc_html__( 'Copyright Name', 'TheCreativityArchitect' ),
			'section'  => 'section_basic',
			'type'     => 'text',
		) );

	$wp_customize->add_setting( 'attachment_comments', array(
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_checkbox',
		) );

	$wp_customize->add_control( 'attachment_comments', array(
			'label'    => esc_html__( 'Enable Gallery View Comments', 'TheCreativityArchitect' ),
			'section'  => 'section_basic',
			'type'     => 'checkbox',
		) );

	$wp_customize->add_setting( 'default_google_fonts',array(
		'default'           => true,
		'description' 			=> esc_html__( 'This theme has a couple Google Fonts included. If you choose to use a plugin for different fonts, you can disable them.', 'TheCreativityArchitect' ),
		'sanitize_callback' => 'sanitize_checkbox',
	)	);
}
add_action( 'customize_register', 'customize_register_basic_settings' );

function register_customize_header_control( $wp_customize ) {

$wp_customize->add_control( new Customize_Header_Control(
	$wp_customize, 'theme_options[basic_options]',array(
			'label' => esc_html__( 'WP Gallery Options', 'TheCreativityArchitect' ),
			'section' => 'section_basic',
			'settings' => array(),
		) );

$wp_customize->add_control(	new Customize_Header_Control(
		$wp_customize, 'google_fonts_option', array(
			'label' => esc_html__( 'Default Google Font Option', 'TheCreativityArchitect' ),
			'section' => 'section_basic',
			'settings' => array(),
		) );

$wp_customize->add_control( new	Customize_Header_Control(
	$wp_customize, 'default_google_fonts',.array(
		'label' => esc_html__( 'Default Google Fonts', 'TheCreativityArchitect' ),
		'section' => 'section_basic',
		'settings' => array(),
	) );
}
add_action( 'customize_register', 'register_customize_header_control' )
