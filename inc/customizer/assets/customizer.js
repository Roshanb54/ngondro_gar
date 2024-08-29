/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery(document).ready(function () {
    jQuery("li#customize-control-robojob-banner_image").addClass('hide_banner');
    jQuery("li#customize-control-robojob-_show_search").addClass('hide_search');
    jQuery("#customize-control-robojob-contact_map_iframe").addClass('hide_contact_map');

    var product_or_callout = jQuery("#product-or-callout input[type='radio']:checked").val();

    if (product_or_callout == 'city-top-product-cat') {
        jQuery(".city-product-cat").show();
        for (var i = 1; i <= 3; i++) {
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_title_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_subtitle_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_top_custom_callouts_image_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_button_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_url_" + i + "").hide();
        }
    }
    else {
        jQuery(".city-product-cat").hide();
        for (var i = 1; i <= 3; i++) {
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_title_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_subtitle_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_top_custom_callouts_image_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_button_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_url_" + i + "").show();
        }
    }
    jQuery(document).on('click', '#customize-control-ngondro_gar_theme_options-ngondro_gar_product_cat_lists select>option', function (e) {

        if (jQuery(this).hasClass('cat_selected')) {
            jQuery(this).removeClass('cat_selected');
        }
        else {
            jQuery(this).addClass('cat_selected');
        }
        var last_valid_selection = null;
        jQuery('#customize-control-ngondro_gar_theme_options-ngondro_gar_product_cat_lists select').change(function (event) {
            if (jQuery(this).val().length > 5) {
                alert('Please Select Only Three Items');
                jQuery(this).val(last_valid_selection);
                jQuery(this).find('option').removeAttr('selected');
            } else {
                last_valid_selection = jQuery(this).val();
            }
        });
    });

});
jQuery(document).on('change', '[name="callout"]', function () {
    var topcall = jQuery("#product-or-callout input[type='radio']:checked").val();

    if (topcall == 'city-top-product-cat') {

        jQuery(".city-product-cat").show();
        for (var i = 1; i <= 3; i++) {
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_title_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_subtitle_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_top_custom_callouts_image_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_button_" + i + "").hide();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_url_" + i + "").hide();
        }
    }
    else {
        jQuery(".city-product-cat").hide();
        for (var i = 1; i <= 3; i++) {
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_title_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_subtitle_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_top_custom_callouts_image_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_button_" + i + "").show();
            jQuery("#customize-control-ngondro_gar_theme_options-ngondro_gar_top_custom_callouts_url_" + i + "").show();
        }
    }

});
