<?php
$ngondro_gar_setting = ngondro_gar_get_theme_options();

$wp_customize->add_setting('ngondro_gar_theme_options[footer_copyright]',
    array(
        'default' => $ngondro_gar_setting['footer_copyright'] ?? null,
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    )
);

$wp_customize->add_control('footer_copyright',
    array(
        'label' => esc_html__('Footer copyright', 'ngondro_gar'),
        'type' => 'text',
        'section' => 'footer_section',
        'settings' => 'ngondro_gar_theme_options[footer_copyright]',
    ));