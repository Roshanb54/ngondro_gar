<?php
/**
 * Theme Customizer Functions
 *
 * @package Roshan Banstola
 * @subpackage Benchmark
 * @since Benchmark 1.0
 */
/******************** Benchmark SLIDER SETTINGS ******************************************/
$ngondro_gar_setting = ngondro_gar_get_theme_options();

$wp_customize->add_section('ngondro_gar_page_post_options',
    array(
        'title' => esc_html__('Slider Option', 'ngondro_gar'),
        'priority' => 1,
        'panel' => 'ngondro_gar_options_panel'
    ));
for ($i = 1; $i <= $ngondro_gar_setting['ngondro_gar_slider_no']; $i++) {
    $wp_customize->add_setting('ngondro_gar_get_theme_options[ngondro_gar_featured_page_slider_' . $i . ']',
        array(
            'default' => '',
            'sanitize_callback' => 'ngondro_gar_sanitize_page',
            'type' => 'option',
            'capability' => 'manage_options'
        ));
    $wp_customize->add_control('ngondro_gar_theme_options[ngondro_gar_featured_page_slider_' . $i . ']',
        array(
            'priority' => 220 . $i,
            'label' => esc_html__(' Page Slider', 'ngondro_gar') . ' ' . $i,
            'section' => 'ngondro_gar_page_post_options',
            'type' => 'dropdown-pages',
        ));
}