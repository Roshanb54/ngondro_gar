<?php
$ngondro_gar_setting = ngondro_gar_get_theme_options();

//contact address
$wp_customize->add_setting(
    'ngondro_gar_theme_options[contact_address]',
    array(
        'default' => $ngondro_gar_setting['contact_address'] ?? null,
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_kses_post',
    )
);

$wp_customize->add_control('ngondro_gar_theme_options[contact_address]',
    array(
        'label' => esc_html__('Address', 'ngondro_gar'),
        'type' => 'textarea',
        'section' => 'contact_options',
        'settings' => 'ngondro_gar_theme_options[contact_address]',
    )
);

$wp_customize->add_setting(
    'ngondro_gar_theme_options[contact_fphone]',
    array(
        'default' => $ngondro_gar_setting['contact_fphone'] ?? null,
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    )
);

$wp_customize->add_control('ngondro_gar_theme_options[contact_fphone]',
    array(
        'label' => esc_html__('Contact Phone Number', 'ngondro_gar'),
        'type' => 'text',
        'section' => 'contact_options',
        'settings' => 'ngondro_gar_theme_options[contact_fphone]',
    )
);

$wp_customize->add_setting(
    'ngondro_gar_theme_options[contact_email]',
    array(
        'default' => $ngondro_gar_setting['contact_email'] ?? null,
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    )
);

$wp_customize->add_control('ngondro_gar_theme_options[contact_email]',
    array(
        'label' => esc_html__('Email', 'ngondro_gar'),
        'type' => 'text',
        'section' => 'contact_options',
        'settings' => 'ngondro_gar_theme_options[contact_email]',
    )
);

//shortcode form
$wp_customize->add_setting(
    'ngondro_gar_theme_options[contact_form]',
    array(
        'default' => $ngondro_gar_setting['contact_form'] ?? null,
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_kses_post',
    )
);

$wp_customize->add_control('ngondro_gar_theme_options[contact_form]',
    array(
        'label' => esc_html__('Contact Form Shortcode', 'ngondro_gar'),
        'description'        => esc_html__( 'Get Contact Form Shortcode', 'ngondro_gar' ). "<a href=".esc_url(home_url('/').'wp-admin/admin.php?page=wpcf7')." target='_blank'>". ' ' .esc_html__('From Here', 'ngondro_gar'). '</a>',
        'type' => 'text',
        'section' => 'contact_options',
        'settings' => 'ngondro_gar_theme_options[contact_form]',
    )
);


// $wp_customize->add_setting(
//     'ngondro_gar_theme_options[contact_map_iframe]',
//     array(
//         'default' => $ngondro_gar_setting['contact_map_iframe'] ?? null,
//         'type' => 'option',
//         'capability' => 'edit_theme_options',
//     )
// );

// $wp_customize->add_control('ngondro_gar_theme_options[contact_map_iframe]',
//     array(
//         'label' => esc_html__('Google Map Iframe', 'ngondro_gar'),
//         'type' => 'textarea',
//         'description' => esc_html__( 'Get Google Map Iframe', 'ngondro_gar' ). "<a href='https://www.google.com/maps/' target='_blank'>". ' ' .esc_html__('From Here', 'ngondro_gar'). '</a>',
//         'section' => 'contact_options',
//         'settings' => 'ngondro_gar_theme_options[contact_map_iframe]',
//     )
// );
