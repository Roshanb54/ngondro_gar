<?php
/**
 * Theme Customizer Functions
 *
 * @package Roshan Banstola
 * @subpackage Benchmark
 * @since Benchmark 1.0
 */
/******************** Benchmark CUSTOMIZE REGISTER *********************************************/
add_action('customize_register', 'ngondro_gar_customize_register_options', 20);
function ngondro_gar_customize_register_options($wp_customize)
{
    $wp_customize->add_panel('ngondro_gar_options_panel',
        array(
            'priority' => 2,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__('Theme Options', 'ngondro_gar'),
            'description' => '',
        ));
}


?>