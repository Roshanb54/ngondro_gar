<?php
/**
 * Ngondro Gar Theme Customizer
 *
 * @package Ngondro_Gar
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ngondro_gar_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'ngondro_gar_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'ngondro_gar_customize_partial_blogdescription',
			)
		);
	}

	$wp_customize->add_section('header_section', array(
		'title' => esc_html__('Header Options','ngondro_gar'),
		'priority' =>1,
		'panel' =>'ngondro_gar_options_panel'
	));
	
	$wp_customize->add_section('book_options', array(
		'title' => esc_html__('Book Page Options','ngondro_gar'),
		'priority' =>4,
		'panel' =>'ngondro_gar_options_panel'
	));	
	$wp_customize->add_section('ngondro_gar_social_icons',
		array(
			'title' => esc_html__('Social Media Options', 'ngondro_gar'),
			'priority' => 5,
			'panel' => 'ngondro_gar_options_panel'
	));
	$wp_customize->add_section('contact_options',
	array(
		'title' => esc_html__('Contact Options', 'ngondro_gar'),
		'priority' => 6,
		'panel' => 'ngondro_gar_options_panel'
	));	
	$wp_customize->add_section('cta_section', array(
		'title' => esc_html__('CTA Options','ngondro_gar'),
		'priority' =>6,
		'panel' =>'ngondro_gar_options_panel'
	));
	$wp_customize->add_section('other_options', array(
		'title' => esc_html__('Other Options','ngondro_gar'),
		'priority' =>6,
		'panel' =>'ngondro_gar_options_panel'
	));
	$wp_customize->add_section('footer_section',
	array(
		'title' => esc_html__('Footer Options', 'ngondro_gar'),
		'priority' => 7,
		'panel' => 'ngondro_gar_options_panel'
	));

require get_template_directory() . '/inc/customizer/functions/register-panel.php';
require get_template_directory() . '/inc/customizer/functions/theme-options.php';
require get_template_directory() . '/inc/customizer/functions/social-icons.php';
require get_template_directory() . '/inc/customizer/functions/banner-options.php';
require get_template_directory() . '/inc/customizer/functions/contact-options.php';
require get_template_directory() . '/inc/customizer/functions/footer-options.php';
}
add_action( 'customize_register', 'ngondro_gar_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ngondro_gar_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ngondro_gar_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ngondro_gar_customize_preview_js() {
	wp_enqueue_script( 'ngondro_gar-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'ngondro_gar_customize_preview_js' );

function theme_customize_style() {
    wp_enqueue_style( 'ngondro_gar-customizer-css', get_template_directory_uri() . '/inc/customizer/css/customizer-control.css', array(), '1.0.2' );
    wp_enqueue_style( 'ngondro_gar-sortable-css', get_template_directory_uri() . '/assets/sortable/customizer-control.css', array(), '1.0.2' );
    wp_enqueue_script( 'ngondro_gar-customizer-css', get_template_directory_uri() . '/inc/customizer/assets/customizer.js', array('jquery'), '20151215', true );
}
add_action( 'customize_controls_enqueue_scripts', 'theme_customize_style');
