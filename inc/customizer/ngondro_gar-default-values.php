<?php
if(!function_exists('ngondro_gar_get_option_defaults_values')):
	/********************Benchmark DEFAULT OPTION VALUES ******************************************/
	function ngondro_gar_get_option_defaults_values() {
		global $ngondro_gar_default_values;
        $ngondro_gar_default_values = array(

            'ngondro_gar_reset_all' 				=> 0,
            /*header*/
            'white_logo' =>'',
            'limited_posts' =>3,
           'ngondro_gar_content_lenth' => 100,

           
            //social icons
            'ngondro_gar_social_show'				=> 0,
            'ngondro_gar_social_facebook'			=> '',
            'ngondro_gar_social_twitter'				=> '',
            'ngondro_gar_social_linkedin'				=> '',
            'ngondro_gar_social_googleplus'			=> '',
            'ngondro_gar_social_instagram'			=> '',
            'ngondro_gar_social_youtube'				=> '',
            
            /*Contact Us */
			'ngondro_gar_contact_address' 		=> '',
			'ngondro_gar_contact_phone' 			=> '',
			'ngondro_gar_contact_skype' 			=> '',
            'ngondro_gar_contact_email' 			=> '',

            //footer options
            'show_developer_footer'                 =>1,
            'footer_text'                           =>'',
			'footer_copyright'						=> esc_html__('Copyrights © Ngondro Gar 2022. All Rights Reserved.','ngondro_gar'),
			'developed_by_text'						=> esc_html__('Webpoint Solutions LLC','ngondro_gar'),
			'developed_by_link'						=> esc_url('https://webpoint.io/'),


            //contact section
            'contact_title' => '',
            'contact_address' => '',
            'contact_fphone' => '',
            'contact_work' => '',
            'contact_email' => '',
            'contact_map_iframe' =>'',
            //product page
            'products_per_page' =>12,

			);
		return apply_filters( 'ngondro_gar_get_option_defaults_values', $ngondro_gar_default_values );
	}
endif;
?>