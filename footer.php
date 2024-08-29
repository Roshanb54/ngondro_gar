<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ngondro_Gar
 */

    $ngondro_gar_settings = ngondro_gar_get_theme_options();
    	//know more button
	$cta_title = $ngondro_gar_settings['cta_title'] ?? null;
	$cta_content = $ngondro_gar_settings['cta_content'] ?? null;
	$cta_page_link = $ngondro_gar_settings['cta_page_link'] ?? null;
	$cta_button_text = $ngondro_gar_settings['cta_button_text'] ?? null;

	$sister_org = __('Sister Organization:','ngondro_gar');

?>
	<?php if(!is_user_logged_in()):?>
	<?php if(!is_page_template('page-templates/register-template.php')):?>
	<footer>
	<div class="footer-top bg-default py-5 d-none">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-md-7">
					<div class="footer-register-content text-white pe-12">
						<h3><?php echo ($cta_title) ? __($cta_title,'ngondro_gar') : __('Want to join Ngöndro Gar ?','ngondro_gar');?></h3>
						<p class="text-white"><?php echo ($cta_content) ? __($cta_content,'ngondro_gar') : '';?></p>
					</div>
				</div>
				<div class="col-md-5">
					<div class="footer-register-button">
					<?php if($cta_page_link):?>
						<div class="navbar-other d-flex align-items-center justify-content-center ms-4">
							<ul class="navbar-nav" data-sm-skip="true">
							<li class="nav-item">
								<a href="<?php echo get_the_permalink($cta_page_link);?>" class="px-10 btn btn-lg btn-white"><?php echo ($cta_button_text) ? __($cta_button_text,'ngondro_gar') : __('Register','ngondro_gar');?></a>
							</li>
							</ul>
							<!-- /.navbar-nav -->
						</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif;?>
	<div class="footer-bottom py-2">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-md-12 order-sm-2 d-lg-block d-md-block">
					<nav class="navbar navbar-expand justify-content-end justify-content-lg-end navbar-light">
						<div class="col-auto footer-items me-3 align-items-center">
							<span><?php echo $sister_org;?> </span>
							<?php
								if (is_active_sidebar( 'footer-2' ) ) {
									dynamic_sidebar( 'footer-2' );
								}
							?>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
</footer>
	<?php else:?>
        <footer class="footer-after-login mt-4 ">
            <nav class="navbar navbar-expand shadow justify-content-end justify-content-lg-end navbar-light">
                <div class="col-auto footer-items me-3 py-2">
                    <span><?php echo $sister_org;?> </span>
                    <?php
                        if (is_active_sidebar( 'footer-2' ) ) {
                            dynamic_sidebar( 'footer-2' );
                        }
                    ?>
                </div>
            </nav>
        </footer>
<!--	<footer class="py-5 bg-white mt-10">-->
<!--		<div class="footer-after-login">-->
<!--			<div class="container">-->
<!--				<div class="row">-->
<!--					<div class="col-md-3 text-center">-->
<!--						--><?php //
//						if( has_custom_logo() ):
//						// Get Custom Logo URL
//						$custom_logo_id = get_theme_mod( 'custom_logo' );
//						$custom_logo_data = wp_get_attachment_image_src( $custom_logo_id , 'full' );
//						$custom_logo_url = $custom_logo_data[0];
//						?>
<!--						<a class="logo me-6 black-logo" href="--><?php //echo esc_url( home_url( '/' ) ); ?><!--">-->
<!--						<img src="--><?php //echo esc_url( $custom_logo_url ); ?><!--" alt="--><?php //echo esc_attr( get_bloginfo( 'name' ) ); ?><!--">-->
<!--						</a>-->
<!--						--><?php //endif; ?>
<!--						<div class="copyright-text pt-5"><p>© --><?php //echo date('Y');?><!-- --><?php //echo __('Ngondro Gar. All rights reserved.','ngondro_gar');?><!--</p></div>-->
<!--					</div>-->
<!--					<div class="col-md-2 border-left ps-8">-->
<!--						<div class="landing-page-footer-menu after-login-menu">-->
<!--						--><?php //
//							if (is_active_sidebar( 'footer-1' ) ) {
//								dynamic_sidebar( 'footer-1' );
//							}
//						?>
<!--						</div>-->
<!--					</div>-->
<!--					<div class="col-md-2  ps-8">-->
<!--						<div class="landing-page-footer-menu after-login-menu">-->
<!--						--><?php //
//							if (is_active_sidebar( 'footer-2' ) ) {
//								dynamic_sidebar( 'footer-2' );
//							}
//						?>
<!--						</div>-->
<!--					</div>-->
<!--					<div class="col-md-5">-->
<!--					<div class="landing-page-footer-menu after-login-menu inline-menu">-->
<!--						--><?php //
//							if (is_active_sidebar( 'footer-3' ) ) {
//								dynamic_sidebar( 'footer-3' );
//							}
//						?>
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		</footer>-->
	<?php  endif;?>
	<div class="backtotop">
	<a href="#">
		<i class="fa fa-long-arrow-up" aria-hidden="true"></i>
	</a>
	</div>

<?php wp_footer(); ?>

</body>

<?php $status = get_user_meta(get_current_user_id(), 'ng_user_approve_status', true); 
 
	add_filter('onesignal_initialize_sdk', 'onesignal_initialize_sdk_filter', 10, 1);
	function onesignal_initialize_sdk_filter($onesignal_settings) {
			return false;
	}

  ?>
  
  <?php $status = get_user_meta(get_current_user_id(), 'ng_user_approve_status', true); 
   if(is_user_logged_in()):
  ?>

   <script>
    window.addEventListener('load', function() {
     	window.OneSignal = window.OneSignal || [];
			console.log("about to initialize OneSignal"); 
			var OneSignal = window.OneSignal || [];
			console.log(OneSignal);
			OneSignal.push(function() {
				OneSignal.init({
                    appId: "f4f0a361-b22f-43ff-ba84-6e3e26bb2492",
                    safari_web_id: "web.onesignal.auto.184c7445-8c69-4a83-85c0-51cef14a5d89",
                    notifyButton: {	enable: true},    
				});
                
                //OneSignal.showHttpPrompt();
                window.OneSignal.showNativePrompt();
                
			});
    });
  </script>
  <?php endif;?> 
  <script>
		var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
	var reset = getUrlParameter('reset');
	if(reset){
	jQuery('#resetPassword h3').text(ajaxObj.resetText);
	}
  </script>
 
  
</html>


