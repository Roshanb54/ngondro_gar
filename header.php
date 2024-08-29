<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ngondro_Gar
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
    $ngondro_gar_settings = ngondro_gar_get_theme_options();
    //login button
    $login_page = $ngondro_gar_settings['login_page'] ?? null;
    $login_page_button_text = $ngondro_gar_settings['login_page_button_text'] ?? null;
    //register button
    $registration_page = $ngondro_gar_settings['registration_page'] ?? null;
    $registration_page_button_text = $ngondro_gar_settings['registration_page_button_text'] ?? null;
    $mobile_menu_logo = get_theme_mod( 'mobile_menu_logo' );

?>
<header id="masthead" class="site-header">
	<nav class="before-login-nav navbar navbar-expand-md static-nav transparent navbar-light pt-1 pb-3
	<?php if(is_page('forgot-password') || is_page('change-password-before-login')){ echo 'd-none' ;} ?>">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand d-flex  d-none d-smd-none d-md-block">
            <?php
            if( has_custom_logo() ):
            the_custom_logo();
            // Get Custom Logo URL
            // $custom_logo_id = get_theme_mod( 'custom_logo' );
            // $custom_logo_data = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            // $custom_logo_url = $custom_logo_data[0];
            ?>
            <!-- <a class="custom-logo-link custom-logo-image" href="<?php //echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php //echo esc_url( $custom_logo_url ); ?>" alt="<?php //echo esc_attr( get_bloginfo( 'name' ) ); ?>">
            </a> -->
            <?php endif; ?>
            <!-- Logo -->

            </div>
            <div class="navbar-brand d-flex justify-content-between d-block d-smd-block d-md-none mobile-logo-wrapper">
              <a class="custom-logo-link custom-logo-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php
                if($mobile_menu_logo):
                    ?>
                    <img src="<?php echo $mobile_menu_logo;?>" alt="Ngondro Gar">
                <?php endif;?>
                </a>
                <a href="javascript:void(0)" class="d-inline-block sidemenu_btn" id="sidemenu_toggle">
                    <span></span> <span></span> <span></span><span></span>
                </a>
            </div>
            <!-- Mobile Logo Ends -->
         
          <!-- /.navbar-collapse -->
          <?php if(is_user_logged_in()){ ?>
            <div class="navbar-collapse collapse">
            <?php 
              wp_nav_menu( array(
                  'theme_location' => 'menu-2',
                  'menu_class' => 'navbar-nav d-flex w-100 justify-content-center', 
                  'container' =>'ul',
                  'add_a_class'    => 'nav-link',
                  'depth' => 2,
                  'walker' => new bootstrap_5_wp_nav_menu_walker()
              ) );
              ?>
            <!-- /.navbar-nav -->
          </div>
            <div class="user-profile-menu-wrapper">
            <?php
              wp_nav_menu( array(
                  'theme_location' => 'user-profile',
                  'menu_class' => 'navbar-nav', 
                  'container' =>'ul',
                  'add_a_class'    => 'nav-link',
                  'depth' => 2,
                  'walker' => new bootstrap_5_wp_nav_menu_walker()
              ) ); ?>
            </div>
            <?php
            }
          else { ?>
           <div class="navbar-collapse collapse justify-content-center pe-6 <?php if(is_front_page()): echo 'pe-15'; endif;?>">
            <?php 
              wp_nav_menu( array(
                  'theme_location' => 'menu-1',
                  'menu_class' => 'navbar-nav d-flex w-100 primary-menu-before-login', 
                  'container' =>'ul',
                  'add_a_class'    => 'nav-link',
                  'depth' => 2,
                  'walker' => new bootstrap_5_wp_nav_menu_walker()
              ) );
              ?>
            <!-- /.navbar-nav -->
          </div>
          <?php if($login_page && !is_front_page()): ?>
          <div class="navbar-other d-flex">
            <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
              <li class="nav-item d-none d-md-block">
                <a href="<?php echo get_the_permalink($login_page);?>" class="btn btn-lg btn-default"><?php echo ($login_page_button_text) ? __($login_page_button_text,'ngondro_gar') : __('Login','ngondro_gar');?></a>
              </li>
            </ul>
            <!-- /.navbar-nav -->
          </div>
          <?php endif;?>
          <div class="navbar-other d-flex ms-3">
            <div class="language-switcher float-end">
              <?php echo do_shortcode('[wpml_language_switcher flags=0]');?>
            </div>
            <!-- /.navbar-nav -->
          </div>
          <?php if($registration_page):?>
          <div class="navbar-other d-flex ms-3">
            <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
              <li class="nav-item d-none d-lg-block">
                <a href="<?php echo get_the_permalink($registration_page);?>" class="btn btn-lg btn-tranparent"><?php echo ($registration_page_button_text) ? __($registration_page_button_text,'ngondro_gar') : __('Register','ngondro_gar');?></a>
              </li>
            </ul>
            <!-- /.navbar-nav -->
          </div>
          <?php endif; } ?>

          <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
      </nav>
       <!-- side menu -->
	<div class="side-menu opacity-0 bg-white">
		<div class="overlay"></div>
		<div class="inner-wrapper">
      <div class="mobile-menu-logo">
        <a class="custom-logo-link custom-logo-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">  
        <img src="<?php echo get_theme_mod('mobile_menu_logo');?>" alt="mobile menu logo"/>
          </a>
    </div>
			<span class="btn-close btn-close-no-padding" id="btn_sideNavClose"><i></i><i></i></span>
			<nav class="side-nav w-100">
        <?php 
            wp_nav_menu( array(
                'theme_location' => 'menu-mobile',
                'menu_class' => 'navbar-nav', 
                'container' =>'ul',
                'add_a_class'    => 'nav-link',
                'walker' => new bootstrap_5_wp_nav_menu_walker()
                
            ) );
            ?>
          <?php if($login_page && !is_front_page()): ?>
          <div class="navbar-other d-flex justify-content-end">
            <ul class="navbar-nav p-0" data-sm-skip="true">
              <li class="nav-item">
                <a href="<?php echo get_the_permalink($login_page);?>" class="btn btn-lg btn-default"><?php echo ($login_page_button_text) ? __($login_page_button_text,'ngondro_gar') : __('Login','ngondro_gar');?></a>
              </li>
            </ul>
            <!-- /.navbar-nav -->
          </div>
          <?php endif;?>
          <?php if($registration_page):?>
          <div class="navbar-other d-none">
            <ul class="navbar-nav p-0" data-sm-skip="true">
              <li class="nav-item">
                <a href="<?php echo get_the_permalink($registration_page);?>" class="btn btn-lg btn-default w-100"><?php echo ($registration_page_button_text) ? __($registration_page_button_text,'ngondro_gar') : __('Register','ngondro_gar');?></a>
              </li>
            </ul>
            <!-- /.navbar-nav comment -->
          </div>
          <?php endif;?>
			</nav>
      
		</div>
	</div>
	<div id="close_side_menu" class="tooltip"></div>
	<!-- End side menu -->
	</header><!-- #masthead -->
