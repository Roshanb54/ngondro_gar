<?php
/**
 * Theme Customizer Functions
 *
 * @package Roshan Banstola
 * @subpackage Benchmark
 * @since Benchmark 1.0
 */
$ngondro_gar_setting = ngondro_gar_get_theme_options();
/********************  Benchmark THEME OPTIONS ******************************************/
//white logo
// $wp_customize->add_setting(
//     'ngondro_gar_theme_options[white_logo]',
//     array(
//         'type' => 'option',
//         'default' => $ngondro_gar_setting['white_logo'],
//         'sanitize_callback' => 'esc_url_raw',
//         'capability' => 'edit_theme_options',
//     )
// );

// $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'white_logo', array(
//             'label' => esc_html__('White Logo', 'ngondro_gar'),
//             'section' => 'title_tagline',
//             'settings' => 'ngondro_gar_theme_options[white_logo]',
//             'priority' => 9,
//         )
//     )
// );

//login page
$wp_customize->add_setting('ngondro_gar_theme_options[login_page]',
    array(
        'capability' => 'edit_theme_options',
        'default' => $ngondro_gar_setting['login_page'] ?? null,
        'sanitize_callback' => 'esc_html',
        'type' => 'option',
    ));
$wp_customize->add_control('ngondro_gar_theme_options[login_page]',
    array(
        'label' => esc_html__('Select the Login Page:', 'ngondro_gar'),
        'priority' => 1,
        'section' => 'header_section',
        'type' => 'dropdown-pages',
    ));
    $wp_customize->add_setting('ngondro_gar_theme_options[login_page_button_text]',
    array(
        'type' => 'option',
        'default' => $ngondro_gar_setting['login_page_button_text'] ?? null,
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[login_page_button_text]',
    array(
        'priority' => 2,
        'label' => esc_html__('Login Button Text', 'ngondro_gar'),
        'type' => 'text',
        'section' => 'header_section',
        'settings' => 'ngondro_gar_theme_options[login_page_button_text]',
    )
);
//register page
$wp_customize->add_setting('ngondro_gar_theme_options[registration_page]',
    array(
        'capability' => 'edit_theme_options',
        'default' => $ngondro_gar_setting['registration_page'] ?? null,
        'sanitize_callback' => 'esc_html',
        'type' => 'option',
    ));
$wp_customize->add_control('ngondro_gar_theme_options[registration_page]',
    array(
        'label' => esc_html__('Select the Registration Page:', 'ngondro_gar'),
        'priority' => 3,
        'section' => 'header_section',
        'type' => 'dropdown-pages',
    ));
    $wp_customize->add_setting('ngondro_gar_theme_options[registration_page_button_text]',
    array(
        'type' => 'option',
        'default' => $ngondro_gar_setting['registration_page_button_text'] ?? null,
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[registration_page_button_text]',
    array(
        'priority' => 4,
        'label' => esc_html__('Register Button Text', 'ngondro_gar'),
        'type' => 'text',
        'section' => 'header_section',
        'settings' => 'ngondro_gar_theme_options[registration_page_button_text]',
    )
);
//about section
$wp_customize->add_setting('ngondro_gar_theme_options[about_page]',
    array(
        'capability' => 'edit_theme_options',
        'default' => $ngondro_gar_setting['about_page'] ?? null,
        'sanitize_callback' => 'esc_html',
        'type' => 'option',
    ));
$wp_customize->add_control('ngondro_gar_theme_options[about_page]',
    array(
        'label' => esc_html__('Select the About Page:', 'ngondro_gar'),
        'priority' => 1,
        'section' => 'about_section',
        'type' => 'dropdown-pages',
    ));
    $wp_customize->add_setting('ngondro_gar_theme_options[about_content_count]',
    array(
        'type' => 'option',
        'default' => $ngondro_gar_setting['about_content_count'] ?? null,
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[about_content_count]',
    array(
        'priority' => 2,
        'label' => esc_html__('No. of characters to show', 'ngondro_gar'),
        'type' => 'number',
        'section' => 'about_section',
        'settings' => 'ngondro_gar_theme_options[about_content_count]',
    )
);

//services section
$wp_customize->add_setting('ngondro_gar_theme_options[service_page]',
    array(
        'capability' => 'edit_theme_options',
        'default' => $ngondro_gar_setting['service_page'] ?? null,
        'sanitize_callback' => 'esc_html',
        'type' => 'option',
    ));
$wp_customize->add_control('ngondro_gar_theme_options[service_page]',
    array(
        'label' => esc_html__('Select the Service Page:', 'ngondro_gar'),
        'priority' => 1,
        'section' => 'service_section',
        'type' => 'dropdown-pages',
    ));
    $wp_customize->add_setting('ngondro_gar_theme_options[service_content_count]',
    array(
        'type' => 'option',
        'default' => $ngondro_gar_setting['service_content_count'] ?? null,
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[service_content_count]',
    array(
        'priority' => 2,
        'label' => esc_html__('No. of characters to show', 'ngondro_gar'),
        'type' => 'number',
        'section' => 'service_section',
        'settings' => 'ngondro_gar_theme_options[service_content_count]',
    )
);
//testimonial

//testimonial Options
$wp_customize->add_setting('ngondro_gar_theme_options[testimonial_page]',
    array(
        'capability' => 'edit_theme_options',
        'default' => $ngondro_gar_setting['testimonial_page'] ?? null,
        'sanitize_callback' => 'esc_html',
        'type' => 'option',
    ));
$wp_customize->add_control('ngondro_gar_theme_options[testimonial_page]',
    array(
        'label' => esc_html__('Select the Testimonial Page:', 'ngondro_gar'),
        'priority' => 1,
        'section' => 'testimonial_section',
        'type' => 'dropdown-pages',
    ));

$wp_customize->add_setting('ngondro_gar_theme_options[testimonial_limit]',
    array(
        'type' => 'option',
        'default' => $ngondro_gar_setting['testimonial_limit'] ?? null,
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[testimonial_limit]',
    array(
        'priority' => 3,
        'label' => esc_html__('No. Of Testimonails', 'ngondro_gar'),
        'type' => 'number',
        'section' => 'testimonial_section',
        'settings' => 'ngondro_gar_theme_options[testimonial_limit]',
    )
); 

/*media Page*/ 
$wp_customize->add_setting('ngondro_gar_theme_options[book_per_page]',
    array(
        'type' => 'option',
        'default' => $ngondro_gar_setting['book_per_page'] ?? null,
        'sanitize_callback' => 'esc_html',
    )
);
$wp_customize->add_control('ngondro_gar_theme_options[book_per_page]',
    array(
        'priority' => 3,
        'label' => esc_html__('Book Posts per Page', 'ngondro_gar'),
        'type' => 'number',
        'section' => 'book_options',
        'settings' => 'ngondro_gar_theme_options[book_per_page]',
    )
); 

$wp_customize->add_setting('mobile_menu_logo');
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mobile_menu_logo', array(
    'label'    => __('Mobile Menu Logo', 'ngondro_gar'),
    'section'  => 'title_tagline',
    'settings' => 'mobile_menu_logo',
    'priority'       => 9,
)));

//cta section
$wp_customize->add_setting('ngondro_gar_theme_options[cta_title]',
array(
    'type' => 'option',
    'default' => $ngondro_gar_setting['cta_title'] ?? null,
    'sanitize_callback' => 'wp_kses_post',
)
);
$wp_customize->add_control('ngondro_gar_theme_options[cta_title]',
array(
    'priority' => 1,
    'label' => esc_html__('CTA Section Title', 'ngondro_gar'),
    'type' => 'text',
    'section' => 'cta_section',
    'settings' => 'ngondro_gar_theme_options[cta_title]',
)
);

$wp_customize->add_setting('ngondro_gar_theme_options[cta_content]',
array(
    'type' => 'option',
    'default' => $ngondro_gar_setting['cta_content'] ?? null,
    'sanitize_callback' => 'wp_kses_post',
)
);
$wp_customize->add_control('ngondro_gar_theme_options[cta_content]',
array(
    'priority' => 2,
    'label' => esc_html__('CTA Section Title', 'ngondro_gar'),
    'type' => 'textarea',
    'section' => 'cta_section',
    'settings' => 'ngondro_gar_theme_options[cta_content]',
)
);

$wp_customize->add_setting('ngondro_gar_theme_options[cta_page_link]',
    array(
        'capability' => 'edit_theme_options',
        'default' => $ngondro_gar_setting['cta_page_link'] ?? null,
        'sanitize_callback' => 'esc_html',
        'type' => 'option',
    ));
$wp_customize->add_control('ngondro_gar_theme_options[cta_page_link]',
    array(
        'label' => esc_html__('Select the Page for button link', 'ngondro_gar'),
        'priority' => 3,
        'section' => 'cta_section',
        'type' => 'dropdown-pages',
    ));
    $wp_customize->add_setting('ngondro_gar_theme_options[cta_button_text]',
    array(
        'type' => 'option',
        'default' => $ngondro_gar_setting['cta_button_text'] ?? null,
        'sanitize_callback' => 'esc_html',
    )
    );
    $wp_customize->add_control('ngondro_gar_theme_options[cta_button_text]',
    array(
        'priority' => 4,
        'label' => esc_html__('CTA Button Text', 'ngondro_gar'),
        'type' => 'text',
        'section' => 'cta_section',
        'settings' => 'ngondro_gar_theme_options[cta_button_text]',
    )
    );

    $wp_customize->add_setting('ngondro_gar_theme_options[other_page_select]',
    array(
        'capability' => 'edit_theme_options',
        'default' => $ngondro_gar_setting['other_page_select'] ?? null,
        'sanitize_callback' => 'esc_html',
        'type' => 'option',
    ));
$wp_customize->add_control('ngondro_gar_theme_options[other_page_select]',
    array(
        'label' => esc_html__('Select the Others page for sidebar menu', 'ngondro_gar'),
        'priority' => 3,
        'section' => 'other_options',
        'type' => 'dropdown-pages',
    ));
?>