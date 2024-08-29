<?php
/**
 * Template Name: Riponche Teaching Page
 * @desc Riponche's Teaching
 * @params {title} title of the page
 * @params {short_content} content of the page
 * @returns {get_field()} [Value] Return acf field value base on field key
 * @returns {get_the_post_thumbnail_url()} Return the post featured image url by post ID
 */
get_header('loggedin');
global $post;
$page_title = get_field('page_title');
$short_content = get_field('short_content');
$featured_image = get_the_post_thumbnail_url($post->ID, 'full');

/* Resources by type */
// $resources_tr = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'refuge'");
// $resources_tb = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'bodhicitta'");
// $resources_other = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'others'");

/*Teaching on Refuge*/
$args = array(
    'post_status' => 'publish',
    'post_type' => 'wpdmpro', 
    'posts_per_page' => -1,
    'tax_query' => array(
        array (
            'taxonomy' => 'wpdmtag',
            'field' => 'slug',
            'terms' => 'rinpoche',
        )
    ),
    'meta_query'      => array(
        'relation' => 'AND',
        array(
          'key'         => 'select_type',
          'value'       => 'teaching',
          'compare'     => '=',
        ),
        array(
            'key'         => 'select_section',
            'value'       => 'refuge',
            'compare'     => '=',
        ),
    ),
);

$resources_tr = get_posts($args);


/*Teaching on bodhicitta */
$args = array(
    'post_status' => 'publish',
    'post_type' => 'wpdmpro', 
    'posts_per_page' => -1,
    'tax_query' => array(
        array (
            'taxonomy' => 'wpdmtag',
            'field' => 'slug',
            'terms' => 'rinpoche',
        )
    ),
    'meta_query'      => array(
        'relation' => 'AND',
        array(
          'key'         => 'select_type',
          'value'       => 'teaching',
          'compare'     => '=',
        ),
        array(
            'key'         => 'select_section',
            'value'       => 'bodhicitta',
            'compare'     => '=',
        ),
    ),
);

$resources_tb = get_posts($args);


/*Other*/
$args = array(
    'post_status' => 'publish',
    'post_type' => 'wpdmpro', 
    'posts_per_page' => -1,
    'tax_query' => array(
        array (
            'taxonomy' => 'wpdmtag',
            'field' => 'slug',
            'terms' => 'rinpoche',
        )
    ),
    'meta_query'      => array(
        'relation' => 'AND',
        array(
          'key'         => 'select_type',
          'value'       => 'teaching',
          'compare'     => '=',
        ),
        array(
            'key'         => 'select_section',
            'value'       => 'others',
            'compare'     => '=',
        ),
    ),
);

$resources_other = get_posts($args);
?>

<div id="layoutSidenav_content">
    <section class="banner_bg d-flex align-items-end msg_teaching_banner">
        <div class="container d-none d-md-block">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php if($page_title ): echo $page_title ; endif;?></h2>
                    <p><?php if($short_content ): echo $short_content ; endif;?></p>
                </div>

            </div>
        </div>
    </section>
    <section class="rinpoche-teaching mt-7 mb-15">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11 border-bottom">
                    <a href="<?php echo home_url('rinpoche-messages');?>" class="btn btn-tabs"><?php echo __('Message from Rinpoche','ngondro_gar');?></a>
                    <a href="<?php echo home_url('rinpoche-teachings');?>" class="btn btn-tabs active"><?php echo __('Rinpoche\'s Teaching','ngondro_gar');?></a>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <div class="ps-10 ps-sm-0">
                            <h5 class="mt-5"><?php echo __('Teaching on Refuge','ngondro_gar');?></h5>
                            <div class="sidebar-inner-box">
                                <?php 
                                if($resources_tr):?>
                                    <ul>
                                        <?php $index = 1; foreach($resources_tr as $resource):
                                            ?>
                                            <li class="align-items-center justify-content-between py-3">
                                                <div class="d-block align-items-center justify-content-between py-3">
                                                    <p class="py-2">
                                                    <?=$resource->post_title?> (<?=$resource->post_date?>)
                                                    </p>
                                                    <p> <?=$resource->post_content;?> </p>
                                                    <div class="d-block">
                                                        <?php
                                                            echo do_shortcode('[wpdm_package id='.$resource->ID.']')
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php $index++; endforeach;?>
                                    </ul>
                                <?php else:?>
                                    <p> No Data Found ! </p>  
                                <?php endif;?>
                            </div>

                            <h5 class="mt-5">Teaching on Bodhicitta</h5>
                            <div class="sidebar-inner-box">
                                <?php 
                                    if($resources_tb):?>
                                        <ul>
                                            <?php $index = 1; foreach($resources_tb as $resource):
                                                ?>
                                                <li class="align-items-center justify-content-between py-3">
                                                    <div class="d-block align-items-center justify-content-between py-3">
                                                        <p class="py-2">
                                                        <?=$resource->post_title?> (<?=$resource->post_date?>)
                                                        </p>
                                                        <p> <?=$resource->post_content;?> </p>
                                                        <div class="d-block">
                                                            <?php
                                                                echo do_shortcode('[wpdm_package id='.$resource->ID.']')
                                                            ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php $index++; endforeach;?>
                                        </ul>
                                    <?php else:?>
                                        <p> No Data Found ! </p>  
                                    <?php endif;?>
                            </div>

                            <h5 class="mt-5">Other</h5>
                            <div class="sidebar-inner-box">
                                    
                                <?php 
                                if($resources_other):?>
                                    <ul>
                                        <?php $index = 1; foreach($resources_other as $resource):
                                            ?>
                                            <li class="align-items-center justify-content-between py-3">
                                                <div class="d-block align-items-center justify-content-between py-3">
                                                    <p class="py-2">
                                                    <?=$resource->post_title?> (<?=$resource->post_date?>)
                                                    </p>
                                                    <p> <?=$resource->post_content;?> </p>
                                                    <div class="d-block">
                                                        <?php
                                                            echo do_shortcode('[wpdm_package id='.$resource->ID.']')
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php $index++; endforeach;?>
                                    </ul>
                                <?php else:?>
                                    <p> No Data Found ! </p>  
                                <?php endif;?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php get_footer(); ?>
</div>