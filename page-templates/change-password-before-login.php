<?php
/**
 * Template Name: Change Password Before Login Page
 * @desc: Change Password Before Login Page
 */
get_header()
?>

<section class="landing-page-wrapper">
    <div class="container-fluid landing-page-full-height d-flex flex-column">
        <div class="row flex-grow-1 sm-reverse-column">
            <div class="col-md-5 bg-grey">
                <div class="left-box pt-20 px-9 pb-16 text-center">
                    <img src="https://ngondrogarodev.wpengine.com/wp-content/uploads/2022/09/Group-1438.png" alt="Ngondro Gar"/>

                </div>
            </div>
            <div class="col-md-7">
                <div class="forgot-page-form-wrapper pt-15 pb-13 d-flex">
                    <div class="login-form-inner">
                        <img src="https://ngondrogarodev.wpengine.com/wp-content/uploads/2022/07/ngondro-gar-logo.png" alt="" class="pb-8">
                        <h3><?php echo __('Change password','custom_login');?></h3>
                        <p style="color: #272727CC; font-weight: 600;"><?php echo __('Your new password should be different from previous password.','ngondro_gar');?></p>
                        <div style="width: 70%; margin: 0 auto;">
                            <?php the_custom_form_change_password(); ?>
                        </div>
                    </div>
                    <!-- <div class="landing-page-footer-menu">
					<?php
                    // wp_nav_menu(
                    // 	array(
                    // 		'theme_location' => 'footer-menu'
                    // 	)
                    // );
                    ?>
					</div> -->
                </div>
            </div>
        </div>
    </div>
</section>
