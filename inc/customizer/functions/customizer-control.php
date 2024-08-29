<?php
if (!class_exists('WP_Customize_Control'))
    return NULL;


/**
 * Multiple select customize control class.
 */
class ngondro_gar_Customize_Control_Multiple_Select extends WP_Customize_Control
{

    /**
     * The type of customize control being rendered.
     */
    public $type = 'multiple-select';

    /**
     * Displays the multiple select on the customize screen.
     */
    public function render_content()
    {

        if (empty($this->choices))
            return;
        $thisid = get_theme_mod($this->id);
        $getid = $thisid[0];
        $product_categories = get_terms('product_cat');

        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

                if (count($product_categories) < 1) {

                    echo esc_html__('Add Category And Assign Products To Woocommerce Category', 'ngondro_gar');
                }
                ?>
                <select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
                    <option value="none" <?php selected($getid, 'none'); ?>><?php echo esc_html__('All Product', 'ngondro_gar'); ?></option>
                    <?php
                    if (count($product_categories) >= 1) {

                        foreach ($this->choices as $value => $label) {
                            $selected = ($value == $this->value()) ? 'selected' : '';
                            echo '<option value="' . esc_attr($value) . '"' . esc_attr($selected) . '>' . esc_attr($label) . '</option>';
                        }
                    }
                    ?>
                </select>
            <?php }
            else{
                echo esc_html__('Please Install Woocommerce Plugin and Assign Product To Woocommerce Category', 'ngondro_gar');
            }
            ?>
        </label>
    <?php }
}

if (!class_exists('ngondro_gar_Layout_Picker_Custom_Control')) {
    class ngondro_gar_Layout_Picker_Custom_Control extends WP_Customize_Control
    {
        /**
         * Render the content on the theme customizer page
         */
        public function render_content()
        {
            ?>
            <label>
                <span class="customize-layout-control customize-control-title"><?php echo esc_html($this->label); ?></span>
                <ul>

                    <li><br>
                        <input type="radio" name="<?php echo esc_attr($this->id); ?>"
                               id="<?php echo esc_attr($this->id); ?>[right_sidebar]"
                               data-customize-setting-link="<?php echo esc_attr($this->id); ?>" value="3"/>
                        <label for="<?php echo esc_attr($this->id); ?>[right_sidebar]"><?php esc_html_e('Right Sidebar', 'ngondro_gar'); ?></label>

                    </li>
                    <li><br>
                        <input type="radio" name="<?php echo esc_attr($this->id); ?>"
                               id="<?php echo esc_attr($this->id); ?>[full_width]"
                               data-customize-setting-link="<?php echo esc_attr($this->id); ?>" value="1"/>
                        <label for="<?php echo esc_attr($this->id); ?>[full_width]"><?php esc_html_e('No Sidebar', 'ngondro_gar'); ?></label>
                    </li>
                    <li><br>
                        <input type="radio" name="<?php echo esc_attr($this->id); ?>"
                               id="<?php echo esc_attr($this->id); ?>[left_sidebar]"
                               data-customize-setting-link="<?php echo esc_attr($this->id); ?>" value="2"/>
                        <label for="<?php echo esc_attr($this->id); ?>[left_sidebar]"><?php esc_html_e('Left Sidebar', 'ngondro_gar'); ?></label>
                    </li>

                </ul>
            </label>
            <?php
        }
    }
}


/**
 * Adds radio support to the theme customizer
 */
class ngondro_gar_Customize_Radio_Control extends WP_Customize_Control
{
    public $type = 'radio';

    public function render_content()
    {
        $customizer_options = ngondro_gar_get_theme_options();
        $check = '';
        if ($customizer_options['top_callout_options'] == '') {
            $check = 'null';
        }
        ?>
        <span class="customize-control-title"><?php esc_html_e('Choose To Display', 'ngondro_gar'); ?></span>
        <div id="product-or-callout">
            <label class="input-group"></label>
            <span class="customize-inside-control-row">
                <input type="radio" name="callout" value="city-top-product-cat"
                       data-customize-setting-link="<?php echo esc_attr($this->id); ?>"><?php echo esc_html__('Display Product Categories', 'ngondro_gar'); ?>
        </span>
            <span class="customize-inside-control-row">

            <input type="radio" name="callout" value="city-custom-callouts"
                   data-customize-setting-link="<?php echo esc_attr($this->id); ?>" <?php echo($check == "null" ? 'checked="checked"' : '') ?>><?php echo esc_html__('Display Custom Callouts', 'ngondro_gar'); ?>
        </span>
        </div>

        <?php

    }
}

if (!class_exists('WP_Customize_Control')) {
    return null;
}

class ngondro_gar_checkbox_Customize_Controls extends WP_Customize_Control
{
    public function render_content()
    {
        ?>
        <h2><?php echo esc_html($this->label); ?></h2>
        <label class="switch">
            <input type="checkbox" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link();
            checked($this->value()); ?> />

            <span class="slider round"><?php echo esc_html($this->description); ?></span>
        </label>
        <?php
    }
}

if (!class_exists('WP_Customize_Control')) {
    return null;
}

/**
 * Adds textarea support to the theme customizer
 */
class ngondro_gar_Top_Dropdown_Customize_Control extends WP_Customize_Control
{
    public $type = 'select';

    public function render_content()
    {
        $terms = get_terms('product_cat');
        ?>
        <label>
            <span class="customize-control-title city-product-cat"><?php echo esc_html($this->label); ?></span>
            <?php if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) { ?>
                <select <?php $this->link(); ?> class="city-product-cat">
                    <?php
                    echo '<option value="' . esc_attr('none') . '"' . selected($this->value(), esc_attr('none'), false) . '>' . esc_attr('None') . '</option>';

                    foreach ($terms as $t)
                        echo '<option value="' . esc_attr($t->slug) . '"' . selected($this->value(), esc_attr($t->name), false) . '>' . esc_attr($t->name) . '</option>';
                    ?>
                </select>
            <?php } else {
                ?>
                <p class="customize-control-description city-product-cat"><?php echo esc_html__('Please Install Woocommerce Plugin and Assign Product To Woocommerce Category', 'ngondro_gar') ?></p>
            <?php }
            ?>
        </label>

        <?php
    }
}


if (!class_exists('WP_Customize_Control')) {
    return null;
}

/**
 * Adds textarea support to the theme customizer
 */
class ngondro_gar_Top_Callout_Customize_Controls extends WP_Customize_Control
{
    public $type = 'select';

    public function render_content()
    {
        ?>

        <label>
        <span class="customize-text_editor">
        <?php echo esc_html($this->label); ?>
        </span>
            <?php
            $settings = array(
                'textarea_name' => esc_attr($this->id)
            );
            wp_editor($this->value(), $this->id, $settings);
            ?>
        </label>

        <?php
    }

}

?>
