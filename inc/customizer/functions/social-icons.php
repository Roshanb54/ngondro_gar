<?php
/**
 * Theme Customizer Functions
 *
 * @package Roshan Banstola
 * @subpackage Benchmark
 * @since Benchmark 1.0
 */
$ngondro_gar_setting = ngondro_gar_get_theme_options();
/******************** Benchmark SOCIAL ICONS ******************************************/

$wp_customize->add_setting(
    'ngondro_gar_theme_options[ngondro_gar_social_show]',
    array(
        'default' => $ngondro_gar_setting['ngondro_gar_social_show'],
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'ngondro_gar_sanitize_checkbox',
    )
);

$wp_customize->add_control(new ngondro_gar_checkbox_Customize_Controls(
    $wp_customize, 'ngondro_gar_theme_options[ngondro_gar_social_show]',
        array(
            'label' => esc_html__('Show Social Icons ? ', 'ngondro_gar'),
            'section' => 'ngondro_gar_social_icons',
            'settings' => 'ngondro_gar_theme_options[ngondro_gar_social_show]',
            'priority' => 1,
        )
    )
);
$wp_customize->add_setting('ngondro_gar_theme_options[ngondro_gar_social_youtube]',
    array(
        'default' => $ngondro_gar_setting['ngondro_gar_social_youtube'],
        'sanitize_callback' => 'esc_url_raw',
        'type' => 'option',
        'capability' => 'manage_options'
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[ngondro_gar_social_youtube]',
    array(
        'priority' => 410,
        'label' => esc_html__('Youtube Link', 'ngondro_gar'),
        'section' => 'ngondro_gar_social_icons',
        'type' => 'text',
    )
);
$wp_customize->add_setting('ngondro_gar_theme_options[ngondro_gar_social_facebook]',
    array(
        'default' => $ngondro_gar_setting['ngondro_gar_social_facebook'],
        'sanitize_callback' => 'esc_url_raw',
        'type' => 'option',
        'capability' => 'manage_options'
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[ngondro_gar_social_facebook]',
    array(
        'priority' => 410,
        'label' => esc_html__('Facebook Link', 'ngondro_gar'),
        'section' => 'ngondro_gar_social_icons',
        'type' => 'text',
    )
);
$wp_customize->add_setting('ngondro_gar_theme_options[ngondro_gar_social_twitter]',
    array(
        'default' => $ngondro_gar_setting['ngondro_gar_social_twitter'],
        'sanitize_callback' => 'esc_url_raw',
        'type' => 'option',
        'capability' => 'manage_options'
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[ngondro_gar_social_twitter]',
    array(
        'priority' => 420,
        'label' => esc_html__('Twitter Link', 'ngondro_gar'),
        'section' => 'ngondro_gar_social_icons',
        'type' => 'text',
    )
);
// $wp_customize->add_setting('ngondro_gar_theme_options[ngondro_gar_social_googleplus]',
//     array(
//         'default' => $ngondro_gar_setting['ngondro_gar_social_googleplus'],
//         'sanitize_callback' => 'esc_url_raw',
//         'type' => 'option',
//         'capability' => 'manage_options'
//     )
// );
// $wp_customize->add_control('ngondro_gar_theme_options[ngondro_gar_social_googleplus]',
//     array(
//         'priority' => 470,
//         'label' => esc_html__('Google Plus Link', 'ngondro_gar'),
//         'section' => 'ngondro_gar_social_icons',
//         'type' => 'text',
//     )
// );
$wp_customize->add_setting('ngondro_gar_theme_options[ngondro_gar_social_instagram]',
    array(
        'default' => $ngondro_gar_setting['ngondro_gar_social_instagram'],
        'sanitize_callback' => 'esc_url_raw',
        'type' => 'option',
        'capability' => 'manage_options'
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[ngondro_gar_social_instagram]',
    array(
        'priority' => 480,
        'label' => esc_html__('Instagram Link', 'ngondro_gar'),
        'section' => 'ngondro_gar_social_icons',
        'type' => 'text',
    )
);

$wp_customize->add_setting('ngondro_gar_theme_options[ngondro_gar_social_linkedin]',
    array(
        'default' => $ngondro_gar_setting['ngondro_gar_social_linkedin'],
        'sanitize_callback' => 'esc_url_raw',
        'type' => 'option',
        'capability' => 'manage_options'
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[ngondro_gar_social_linkedin]',
    array(
        'priority' => 480,
        'label' => esc_html__('Linkedin Link', 'ngondro_gar'),
        'section' => 'ngondro_gar_social_icons',
        'type' => 'text',
    )
);
?>