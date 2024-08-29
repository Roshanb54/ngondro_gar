<?php
/**
 * Template Name: Riponche Messages Page
 * @desc Message from Rinpoche
 * @params {title} title of the page
 * @params {short_content} content of the page
 * @returns {get_field()} [Value] Return acf field value base on field key
 * @returns {get_the_post_thumbnail_url()} Return the post featured image url by post ID
 */

global $post, $wpdb;
get_header('loggedin');
$page_title = get_field('page_title');
$short_content = get_field('short_content');
$featured_image = get_the_post_thumbnail_url($post->ID, 'full');

/* Resources by page type */

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
        array(
          'key'         => 'select_type',
          'value'       => 'message',
          'compare'     => '=',
        ),
    ),
);

$resources = get_posts($args);

?>

<div id="layoutSidenav_content">
    <section class="banner_bg d-flex align-items-end msg_teaching_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php if($page_title ): echo $page_title ; endif;?></h2>
                    <p><?php if($short_content ): echo $short_content ; endif;?></p>
                </div>
                
            </div>
        </div>
    </section>
    <section class="rinpoche-message mt-7 mb-15">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11 border-bottom">
                    <a href="<?php echo home_url('rinpoche-messages');?>" class="btn btn-tabs active"><?php echo __('Message from Rinpoche','ngondro_gar');?> </a>
                    <a href="<?php echo home_url('rinpoche-teachings');?>" class="btn btn-tabs"><?php echo __('Rinpoche\'s Teaching','ngondro_gar');?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="ps-10 ps-sm-0">
                        <div class="sidebar-inner-box mt-3">
                            <?php 
                            if($resources):?>
                                <ul>
                                    <?php $index = 1; foreach($resources as $resource):
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
    </section>

    <?php get_footer(); ?>
</div>