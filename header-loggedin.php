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
    <script> const base_url = "<?php echo home_url('/') ?>"</script>

</head>
<body <?php body_class('nav-fixed'); ?>>
<?php wp_body_open(); ?>
<?php
$ngondro_gar_settings = ngondro_gar_get_theme_options();
//login button
$login_page = $ngondro_gar_settings['login_page'] ?? null;
$mobile_menu_logo = get_theme_mod( 'mobile_menu_logo' );
$login_page_button_text = $ngondro_gar_settings['login_page_button_text'] ?? null;
$other_page_select = $ngondro_gar_settings['other_page_select'] ?? null;
//register button
$registration_page = $ngondro_gar_settings['registration_page'] ?? null;
$registration_page_button_text = $ngondro_gar_settings['registration_page_button_text'] ?? null;
    $user = wp_get_current_user();
?>
<nav class="topnav navbar navbar-expand justify-content-xxl-end justify-content-xl-end justify-content-lg-end justify-content-end navbar-light bg-white" id="sidenavAccordion">
    <div class="header-menu-left order-1 order-lg-0 ms-md-2 me-lg-2 d-sm-block d-md-block d-lg-none d-xl-none d-xxl-none">
        <button class="btn btn-icon btn-transparent-dark" id="sidebarToggle">
            <i id="menu-icon" class="feather icon-menu"></i> 
        </button>
    </div>
    <div class="breadcumb-section">
        <div class="d-none d-lg-block">
        <?php if(is_page('dashboard') || is_front_page()){?>
        <span property="itemListElement" typeof="ListItem">
        <span property="name" class="current-item"><?php echo __('Dashboard','ngondro_gar');?></span>
        </span> 
        <?php
        } 
        elseif(is_page('hours-reporting')|| is_page('小时报告')|| is_page('小時報告') || is_page('relatorio-de-horas')){ ?>
        <span property="itemListElement" typeof="ListItem">
        <a property="item" typeof="WebPage" title="Go to Ngondro Gar." href="<?php echo home_url('/');?>" class="home">
        <span property="name"><?php echo __('Dashboard','ngondro_gar');?></span></a><meta property="position" content="1">
        </span><i class="icon feather icon-chevron-right"></i> 
        <span property="itemListElement" typeof="ListItem">
        <span property="name" class="post post-page current-item"><?php echo __('Hours Reporting','ngondro_gar');?></span>
        </span> 
        <?php } 
        elseif(is_page('student-report')|| is_page('学生报告')|| is_page('學生報告') || is_page('relatorio-do-aluno')){ ?>
        <span property="itemListElement" typeof="ListItem">
        <a property="item" typeof="WebPage" title="Go to Ngondro Gar." href="<?php echo home_url('/');?>" class="home">
        <span property="name"><?php echo __('Dashboard','ngondro_gar');?></span></a><meta property="position" content="1">
        </span><i class="icon feather icon-chevron-right"></i> 
        <span property="itemListElement" typeof="ListItem">
        <span property="name"><?php echo __('Hours Reporting','ngondro_gar');?></span>
        </span> <i class="icon feather icon-chevron-right"></i> 
        <span property="itemListElement" typeof="ListItem">
        <span property="name" class="current-item"><?php echo __('Reporting History','ngondro_gar');?></span>
        </span> 
        <?php } 
        elseif(is_tax('rinpoche_cats')){ ?>
        <span property="name"><?php echo __('Rinpoche','ngondro_gar');?></span>
        </span> <i class="icon feather icon-chevron-right"></i> 
        <?php 
        bcn_display($return = false, $linked = false, $reverse = false, $force = false);
        }
        elseif(is_tax('wpdmcategory')){ ?>
            <span property="name"><?php echo __('Resources','ngondro_gar');?></span>
            </span> <i class="icon feather icon-chevron-right"></i> 
            <?php 
            bcn_display($return = false, $linked = false, $reverse = false, $force = false);
            }
        else{ bcn_display($return = false, $linked = false, $reverse = false, $force = false); 
        } ?>
        </div>
    </div>
    <div class="header-menu-right order-2 order-lg-0 me-2 ms-lg-2 me-lg-0 d-flex justify-content-end align-items-center">
    <!-- Navbar Items-->
    <div class="language-switcher float-end">
        <?php echo do_shortcode('[wpml_language_switcher flags=0]');?>
    </div>
    <div class="user-profile-menu-wrapper me-3">
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
    </div>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
    <div class="sidenav-menu overflow-auto d-block d-lg-none d-md-none">
            <nav id="main-nav">
            <ul>
            <?php 
                $my_current_lang = apply_filters( 'wpml_current_language', NULL );
                if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ 
                if($my_current_lang == 'en'){ ?>
                    <li><a class="nav-link" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a></li>

               <?php }
               elseif($my_current_lang == 'zh-hans'){ ?>
                    <li><a class="nav-link" href="<?php echo home_url('/zh-hans/仪表板/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a></li>

              <?php }
               elseif($my_current_lang == 'zh-hant'){ ?>
                    <li><a class="nav-link" href="<?php echo home_url('/zh-hant/儀表板/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a></li>

              <?php }
               elseif($my_current_lang == 'pt-pt'){ ?>
                <li><a class="nav-link" href="<?php echo home_url('/pt-pt/painel/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a></li>
                    <li><a class="nav-link" href="<?php echo home_url('/pt-pt/painel/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a></li>

              <?php }
              else { ?>
                    <li><a class="nav-link" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a></li>

             <?php }
                } else { ?>
                    <li><a class="nav-link" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a></li>

               <?php }
                ?>
            <li>
            <?php 
            $rin_mob_args = array('taxonomy' => 'rinpoche_cats','orderby' => 'meta_value_num','order' => 'ASC', 'parent'=> 0,'hide_empty' => 0,);
            $parents_rinpoche = get_categories($rin_mob_args);
            global $wpdb; 
            ?>
             <a class="nav-link" href="#">
                    <div class="nav-link-icon"><i class="feather icon-user"></i></div>
                    <?php echo __('Rinpoche', 'ngondro_gar');?>
     
                </a>
                <ul>
             <?php foreach($parents_rinpoche as $cd): 
                $rin_sub_args = array('taxonomy' => 'rinpoche_cats','orderby' => 'menu_order','order'  => 'ASC',  'parent'=> $cd->term_id,'hide_empty' => 0);
                $sub_cates = get_categories($rin_sub_args);
                if($sub_cates):
            ?>
                <li>
                <a class="nav-link">
                    <?php echo __($cd->name,'ngondro_gar');?>
                </a>
                <ul>
                 <?php foreach($sub_cates as $cats):
                            $args = array('taxonomy' => 'rinpoche_cats','orderby' => 'menu_order','order' => 'ASC', 'parent'=> $cats->term_id,'hide_empty' => 0);
                            $check_sub = get_categories($args);
                                if($check_sub):
                            ?>
                            <li>
                            <a class="nav-link">
                                <?php echo __($cats->name,'ngondro_gar');?>
                            </a>
                            <ul>
                            <?php foreach($check_sub as $subcat):?>
                                <li><a class="nav-link" href="<?php  echo get_category_link($subcat->term_id); ?>"><?php echo __($subcat->name,'ngondro_gar');?></a></li>
                            <?php endforeach;?>
                            </ul>
                            <?php else:?>
                                <li><a class="nav-link" href="<?php  echo get_category_link($cats->term_id); ?>"><?php echo __($cats->name,'ngondro_gar');?></a></li>
                            </li>
                            
                    <?php endif; endforeach;?>
                    </ul>
                     </li>
                     <?php else: ?>
                        <li><a class="nav-link" href="<?php  echo get_category_link($cd->term_id); ?>"><?php echo __($cd->name,'ngondro_gar');?></a></li>

                     <?php endif; endforeach;?>
                    </ul>
                </li>
            <li>
            <?php 
            $args = array('taxonomy' => 'wpdmcategory','orderby' => 'meta_value_num','order' => 'ASC', 'parent'=> 0,'hide_empty' => 0, 'meta_key'=> 'priority',);
            $parents_courses = get_categories($args);
            global $wpdb; 
            ?>
             <a class="nav-link" href="#">
                    <div class="nav-link-icon"><i class="feather icon-book"></i></div>
                    <?php echo __('Resources', 'ngondro_gar');?>
     
                </a>
                <ul>
             <?php foreach($parents_courses as $pc): 
                $args = array('taxonomy' => 'wpdmcategory','orderby' => 'menu_order','order'   => 'ASC',  'parent'=> $pc->term_id,'hide_empty' => 0);
                $sub_cates = get_categories($args);
                $res_name = get_field('short_name',$pc);
                if($sub_cates):
            ?>
                <li>
                <a class="nav-link">
                    <?php echo __($res_name,'ngondro_gar');?>
                </a>
                <ul>
                 <?php foreach($sub_cates as $cats):
                            $args = array('taxonomy' => 'wpdmcategory','orderby' => 'menu_order','order' => 'ASC', 'parent'=> $cats->term_id,'hide_empty' => 0);
                            $check_sub = get_categories($args);
                                if($check_sub):
                            ?>
                            <li>
                            <a class="nav-link">
                                <?php echo __($cats->name,'ngondro_gar');?>
                            </a>
                            <ul>
                            <?php foreach($check_sub as $subcat):?>
                                <li><a class="nav-link" href="<?=home_url('downloads/').$subcat->slug?>"><?php echo __($subcat->name,'ngondro_gar');?></a></li>
                            <?php endforeach;?>
                            </ul>
                            <?php else:?>
                                <li><a class="nav-link" href="<?=home_url('downloads/').$cats->slug?>"><?php echo __($cats->name,'ngondro_gar');?></a></li>
                            </li>
                            
                    <?php endif; endforeach;?>
                    </ul>
                     </li>
                     <?php else: ?>
                        <li><a class="nav-link" href="<?=home_url('downloads/').$pc->slug?>"><?php echo __($pc->name,'ngondro_gar');?></a></li>
                     <?php endif; endforeach;?>
                    </ul>
                </li>
                <?php if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
                   <li> <a class="nav-link" href="<?php echo home_url('/instructors/');?>">
                        <div class="nav-link-icon"><i class="feather icon-users"></i></div>
                        <?php echo __('Instructors', 'ngondro_gar');?>
                    </a></li>
                    <?php } ?>
                   <?php if(is_user_logged_in() && in_array( 'instructor', (array) $user->roles )):?>
                    <li><a class="nav-link">
                        <div class="nav-link-icon"><i class="feather icon-users"></i></div>
                        <?php echo __('Students', 'ngondro_gar');?>
                        </a>
                        <ul>
                        <li><a class="nav-link" href="<?php echo home_url('/student-tracking/')?>"><?php echo __('Student Tracking', 'ngondro_gar');?></a></li>
                        <li><a class="nav-link" href="<?php echo home_url('/student-summary/')?>"><?php echo __('Student Summary', 'ngondro_gar');?></a></li>
                        <li><a class="nav-link" href="<?php echo home_url('/student-no-shows/')?>"><?php echo __('No shows', 'ngondro_gar');?></a></li>
                        </ul>
                    </li>
                    <?php endif;?>

                    <?php if(is_user_logged_in() && in_array( 'instructor', (array) $user->roles )):?>
                    <li><a class="nav-link" href="<?php echo home_url('/mail-students/')?>">
                        <div class="nav-link-icon"><i class="feather icon-users"></i></div>
                        <?php echo __('Mail Students', 'ngondro_gar');?>
                        </a>
                    </li>
                    <?php endif;?>

                    <?php
                            $args = array(
                                'post_type'      => 'page',
                                'posts_per_page' => -1,
                                'post_parent'    => $other_page_select,
                                'order'          => 'ASC',
                                'orderby'        => 'menu_order'
                            );
                            $parent = new WP_Query( $args );
                            if ( $parent->have_posts() ) : ?>
                                <?php while ( $parent->have_posts() ) : $parent->the_post(); 
                                $icon = get_field('menu_icon');
                                if($icon){
                                    $icon_image = $icon;
                                }
                                else {
                                    $icon_image = 'info';
                                }
                                $level_1_args = array(
                                        'post_type'=> 'page',
                                        'post_parent' => get_the_ID(), // Current post's ID
                                    );
                                    $children_of_leve_1= get_children( $level_1_args );
                                ?>
                                    <?php  if ($children_of_leve_1): ?>
                                    <li>
                                    <?php echo get_the_title(); ?>
                                    <ul>
                                    <?php
                                        foreach($children_of_leve_1 as $others_sub_single){
                                            $level_2_args = array(
                                                'post_type'=> 'page',
                                                'post_parent' => $others_sub_single->ID, // Current post's ID
                                            );
                                            $children_of_leve_2= get_children( $level_2_args ); 
                                            ?>
                                           <li> <a class="nav-link"  href="<?php echo get_the_permalink($others_sub_single->ID); ?>"><?php echo get_the_title($others_sub_single->ID); ?></a></li>
                                        <?php } ?>
                                        </ul>
                                        </li>
                                    <?php else:?>
                                 <li><a class="nav-link" href="<?php echo get_the_permalink(); ?>">                  
                                        <div class="nav-link-icon"><i class="feather icon-<?php echo $icon_image;?>"></i></div>
                                        <?php echo get_the_title(); ?>
                                    </a></li>
                                <?php endif; endwhile; ?>
                            <?php endif; wp_reset_postdata(); ?>

            </li>
            </nav>
        </div><!--sidebar menu end-->
        <nav class="sidenav sidenav-light">
            <div class="sidenav-menu overflow-auto">
                <!-- overflow-auto -->
                <div class="navbar-brand d-flex justify-content-center pt-5 pb-5 d-none d-smd-none d-md-block text-center">
                    <?php
                    if( has_custom_logo() ):
                        the_custom_logo();
                        // Get Custom Logo URL
                        // $custom_logo_id = get_theme_mod( 'custom_logo' );
                        // $custom_logo_data = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                        // $custom_logo_url = $custom_logo_data[0];
                        ?>
                        <!-- <a class="logo black-logo" href="<?php //echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php //echo esc_url( $custom_logo_url ); ?>" alt="<?php //echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a> -->
                    <?php endif; ?>

                </div>
                <div class="navbar-brand d-flex justify-content-center mb-10 d-block d-smd-block d-md-none">
                    <a class="custom-logo-link custom-logo-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">  
                    <?php 
                    if($mobile_menu_logo):
                        ?>
                    <img src="<?php echo $mobile_menu_logo;?>" alt="Ngondro Gar">
                        <?php endif;?>
                    </a>
                </div>

                <div class="nav accordion pt-15" id="accordionSidenav">
                <?php 
                $my_current_lang = apply_filters( 'wpml_current_language', NULL );
                if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ 
                if($my_current_lang == 'en'){ ?>
                    <a class="nav-link d-none d-lg-flex" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a>
                    <a class="nav-link d-flex d-lg-none" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                        <small class="d-flex d-lg-none"><?php echo __('Hours Reporting','ngondro_gar');?></small>
                    </a>

               <?php }
               elseif($my_current_lang == 'zh-hans'){ ?>
                <a class="nav-link d-none d-lg-flex" href="<?php echo home_url('/zh-hans/仪表板/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a>
                    <a class="nav-link d-flex d-lg-none" href="<?php echo home_url('/zh-hans/仪表板/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                        <small class="d-flex d-lg-none"><?php echo __('Hours Reporting','ngondro_gar');?></small>
                    </a>

              <?php }
               elseif($my_current_lang == 'zh-hant'){ ?>
                <a class="nav-link d-none d-lg-flex" href="<?php echo home_url('/zh-hant/儀表板/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a>
                    <a class="nav-link d-flex d-lg-none" href="<?php echo home_url('/zh-hant/儀表板/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                        <small class="d-flex d-lg-none"><?php echo __('Hours Reporting','ngondro_gar');?></small>
                    </a>

              <?php }
               elseif($my_current_lang == 'pt-pt'){ ?>
                <a class="nav-link d-none d-lg-flex" href="<?php echo home_url('/pt-pt/painel/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a>
                    <a class="nav-link d-flex d-lg-none" href="<?php echo home_url('/pt-pt/painel/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                        <small class="d-flex d-lg-none"><?php echo __('Hours Reporting','ngondro_gar');?></small>
                    </a>

              <?php }
              else { ?>
                <a class="nav-link d-none d-lg-flex" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a>
                    <a class="nav-link d-flex d-lg-none" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                        <small class="d-flex d-lg-none"><?php echo __('Hours Reporting','ngondro_gar');?></small>
                    </a>

             <?php }
                } else { ?>
                    <a class="nav-link d-none d-lg-flex" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                    </a>
                    <a class="nav-link d-flex d-lg-none" href="<?php echo home_url('/');?>">
                        <div class="nav-link-icon"><i class="feather icon-home"></i></div>
                        <?php echo __('Dashboard', 'ngondro_gar');?>
                        <small class="d-flex d-lg-none"><?php echo __('Hours Reporting','ngondro_gar');?></small>
                    </a>

               <?php }
                ?>
                     
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRin" aria-expanded="false" aria-controls="collapseRin">
                        <div class="nav-link-icon"><i class="feather icon-user"></i></div>
                        <?php echo __('Rinpoche', 'ngondro_gar')?>
                        <small class="d-flex d-lg-none"><?php echo __('Message and Teaching','ngondro_gar');?></small>
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <?php
                    $argument_cat = array('taxonomy' => 'rinpoche_cats','orderby' => 'meta_value_num','order' => 'ASC', 'parent'=> 0,'hide_empty' => 0,);
                    $category_data = get_categories($argument_cat);
                    ?>
                    <div class="collapse" id="collapseRin" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavRinMenu">                 
                        <?php foreach($category_data as $cd): 
                                $rin_args = array('taxonomy' => 'rinpoche_cats','orderby' => 'menu_order','order'   => 'ASC',  'parent'=> $cd->term_id,'hide_empty' => 0);
                                $rin_sub_cates = get_categories($rin_args);
                                if($rin_sub_cates):
                            ?>
                                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRin<?=$cd->term_id?>" aria-expanded="false" aria-controls="collapseRin<?=$cd->term_id?>">
                                <?php echo __($cd->cat_name,'ngondro_gar'); ?>
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseRin<?=$cd->term_id?>" data-bs-parent="#accordionSidenavRinMenu">
                                    <nav class="sidenav-menu-nested nav" id="accordionSidenavRinChildMenu<?=$cd->term_id?>">
                                        <?php foreach($rin_sub_cates as $cats):
                                            $args = array('taxonomy' => 'rinpoche_cats','orderby' => 'menu_order','order' => 'ASC', 'parent'=> $cats->term_id,'hide_empty' => 0);
                                            $check_sub = get_categories($args);
                                                if($check_sub):
                                            ?>
                                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRin<?=$cats->term_id?>" aria-expanded="false" aria-controls="collapseRin<?=$cats->term_id?>">
                                                <?php echo __($cats->name,'ngondro_gar');?>
                                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                            </a>
                                            <div class="collapse" id="collapseRin<?=$cats->term_id?>" data-bs-parent="#accordionSidenavRinChildMenu<?=$cd->term_id?>">
                                                <nav class="sidenav-menu-nested nav" id="accordionSidenavRinChildMenu">
                                                    <?php foreach($check_sub as $subcat):?>
                                                            <a class="nav-link" href="<?php  echo get_category_link($subcat->term_id); ?>"><?php echo __($subcat->name,'ngondro_gar');?></a>
                                                    <?php endforeach;?>
                                                </nav>
                                            </div>

                                            <?php else:?>
                                                <a class="nav-link" href="<?php  echo get_category_link($cats->term_id); ?>"><?php echo __($cats->name,'ngondro_gar');?></a>
                                        <?php endif; endforeach;?>
                                    </nav>
                                </div>
                                <?php else:?>
                                    <a class="nav-link" href="<?php  echo get_category_link($cd->term_id); ?>"><?php echo __($cd->name,'ngondro_gar');?></a>
                                <?php endif; endforeach;?>
                        </nav>
                    </div>

                    <?php 

                    $args = array('taxonomy' => 'wpdmcategory','orderby' => 'meta_value_num','order' => 'ASC', 'parent'=> 0,'hide_empty' => 0, 'meta_key'=> 'priority',);
                    $parents_courses = get_categories($args);
                    global $wpdb;
                    //$parents_courses = $wpdb->get_results("select * from ngondro_courses order by course_id");?>
                   
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRes" aria-expanded="false" aria-controls="collapseRes">
                        <div class="nav-link-icon"><i class="feather icon-book"></i></div>
                        <?php echo __('Resources', 'ngondro_gar');?>
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    
                    <div class="collapse" id="collapseRes" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavResMenu">

                            <?php foreach($parents_courses as $pc): 
                                $args = array('taxonomy' => 'wpdmcategory','orderby' => 'menu_order','order'   => 'ASC',  'parent'=> $pc->term_id,'hide_empty' => 0);
                                $sub_cates = get_categories($args);
                                $res_name = get_field('short_name',$pc);
                            ?>
                            <?php if($sub_cates == NULL){ ?>
                            <a class="nav-link" href="<?=home_url('/downloads/'.$pc->slug.'/')?>"><?php echo __($pc->name,'ngondro_gar');?></a>
                            <?php }else{ ?>
                                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRes<?=$pc->term_id?>" aria-expanded="false" aria-controls="collapseRes<?=$pc->term_id?>">
                                    <?php echo __($res_name,'ngondro_gar');?>
                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseRes<?=$pc->term_id?>" data-bs-parent="#accordionSidenavResMenu">
                                    <nav class="sidenav-menu-nested nav" id="accordionSidenavResChildMenu<?=$pc->term_id?>">
                                        <?php foreach($sub_cates as $cats):
                                            $args = array('taxonomy' => 'wpdmcategory','orderby' => 'menu_order','order' => 'ASC', 'parent'=> $cats->term_id,'hide_empty' => 0);
                                            $check_sub = get_categories($args);
                                                if($check_sub):
                                            ?>
                                            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRes<?=$cats->term_id?>" aria-expanded="false" aria-controls="collapseRes<?=$cats->term_id?>">
                                                <?php echo __($cats->name,'ngondro_gar');?>
                                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                            </a>
                                            <div class="collapse" id="collapseRes<?=$cats->term_id?>" data-bs-parent="#accordionSidenavResChildMenu<?=$pc->term_id?>">
                                                <nav class="sidenav-menu-nested nav" id="accordionSidenavResChildMenu">
                                                    <?php foreach($check_sub as $subcat):?>
                                                            <a class="nav-link" href="<?=home_url('/downloads/'.$subcat->slug.'/')?>"><?php echo __($subcat->name,'ngondro_gar');?></a>
                                                    <?php endforeach;?>
                                                </nav>
                                            </div>

                                            <?php else:?>
                                                <a class="nav-link" href="<?=home_url('/downloads/'.$cats->slug.'/')?>"><?php echo __($cats->name,'ngondro_gar');?></a>
                                        <?php endif; endforeach;?>
                                    </nav>
                                </div>
                                <?php } ?>
                            <?php endforeach;?>

                        </nav>
                    </div>
 
                    <?php if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
                    <a class="nav-link" href="<?php echo home_url('/instructors/');?>">
                        <div class="nav-link-icon"><i class="feather icon-users"></i></div>
                        <?php echo __('Instructors', 'ngondro_gar');?>
                    </a>
                    <?php } ?>
                   <?php if(is_user_logged_in() && in_array( 'instructor', (array) $user->roles )):?>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsestudent" aria-expanded="false" aria-controls="collapsestudent">
                        <div class="nav-link-icon"><i class="feather icon-users"></i></div>
                        <?php echo __('Students', 'ngondro_gar');?>
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsestudent" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavAboutMenu">
                            <a class="nav-link" href="<?php echo home_url('/student-tracking/')?>"><?php echo __('Student Tracking', 'ngondro_gar');?></a>
                            <a class="nav-link" href="<?php echo home_url('/student-summary/')?>"><?php echo __('Student Summary', 'ngondro_gar');?></a>
                            <a class="nav-link" href="<?php echo home_url('/student-no-shows/')?>"><?php echo __('No shows', 'ngondro_gar');?></a>
                        </nav>
                    </div>
                    <?php endif;?>

                    
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFaqs" aria-expanded="false" aria-controls="collapseFaqs">
                        <div class="nav-link-icon"><i class="feather icon-clipboard"></i></div>
                        <?php echo __('Others', 'ngondro_gar');?>
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseFaqs" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                        <?php
                            $args = array(
                                'post_type'      => 'page',
                                'posts_per_page' => -1,
                                'post_parent'    => $other_page_select,
                                'order'          => 'ASC',
                                'orderby'        => 'menu_order'
                            );
                            $parent = new WP_Query( $args );
                            if ( $parent->have_posts() ) : ?>
                                <?php while ( $parent->have_posts() ) : $parent->the_post(); 
                                	$level_1_args = array(
                                        'post_type'=> 'page',
                                        'post_parent' => get_the_ID(), // Current post's ID
                                    );
                                    $children_of_leve_1= get_children( $level_1_args );
                                ?>
                                    <?php  if ($children_of_leve_1): ?>
                                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseOT<?=get_the_ID()?>" aria-expanded="false" aria-controls="collapseOT<?=get_the_ID()?>">
                                    <?php echo get_the_title(); ?>
                                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="collapseOT<?=get_the_ID()?>" data-bs-parent="#accordionSidenavOTMenu">
                                    <nav class="sidenav-menu-nested nav" id="accordionSidenavOTChildMenu<?=get_the_ID()?>">
                                    <?php
                                        foreach($children_of_leve_1 as $others_sub_single){
                                            $level_2_args = array(
                                                'post_type'=> 'page',
                                                'post_parent' => $others_sub_single->ID, // Current post's ID
                                            );
                                            $children_of_leve_2= get_children( $level_2_args ); 
                                            ?>
                                            <a class="nav-link"  href="<?php echo get_the_permalink($others_sub_single->ID); ?>"><?php echo get_the_title($others_sub_single->ID); ?></a>
                                        <?php } ?>
                                        </nav>
                                           </div> 
                                    <?php else:?>
                                    <a class="nav-link"  href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                     <?php endif; endwhile; ?>
                            <?php endif; wp_reset_postdata(); ?>
                        </nav>
                    </div>
                    <?php if(is_user_logged_in() && in_array( 'instructor', (array) $user->roles )):?>
                    <a class="nav-link" href="<?php echo home_url('/mail-students/')?>" aria-expanded="false" aria-controls="collapsestudent">
                        <div class="nav-link-icon"><i class="feather icon-users"></i></div>
                        <?php echo __('Mail Students', 'ngondro_gar');?>
                        
                    </a>
                    <?php endif;?>
                </div>
            </div>
        </nav>
    </div>