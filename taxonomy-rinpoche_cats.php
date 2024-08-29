<?php 
/**
 * Template Name: Single rinpoche Page
 * @desc Single Rinpoche page 
 * @params {section_title} title of the section
 */
get_header('loggedin');
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$terms = get_queried_object();
global $posts;
$my_current_lang = apply_filters( 'wpml_current_language', NULL );
?>

<div id="layoutSidenav_content" class="single-wpdm-category-page">
<div class="container-fluid">
<?php 
$arguments = array('taxonomy' => 'rinpoche_cats',
                    'orderby' => 'menu_order',
                    'order'   => 'ASC',  
                    'parent'=> $term->term_taxonomy_id,
                    'hide_empty' => 0);
                
    $sub_categories = get_categories($arguments);
    if($sub_categories){
    // echo "<pre>";
    // print_r($sub_categories);
	?>

<div class="row rinpoche-teaching-row">
    <div class="col-md-11">
        <div class="ps-sm-0">
			<?php
            //  foreach($types as $key=> $data){
                foreach($sub_categories as $sub){
            ?>
				
            <h5 class="mt-5"><?php echo $sub->cat_name;?></h5>
            <div class="sidebar-inner-box">
                <?php 

                    

                    $args3 = array(
                        'post_status' => 'publish',
                        'post_type' => 'wpdmpro', 
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array (
                                'taxonomy' => 'rinpoche_cats',
                                'field' => 'slug',
                                'terms' => $sub->category_nicename,
                            )
                        ),
                    );
                    $new_data = get_posts($args3);


				if($new_data):
				?>
                <ul>
                    <?php $index = 1; foreach($new_data as $resource):
                    $package_size = get_package_data($resource->ID, 'package_size');
                    $size_int = (int) filter_var($package_size, FILTER_SANITIZE_NUMBER_INT);
					?>
                    <li class="align-items-center justify-content-between py-3 <?php if($size_int == 0 ): echo 'zero-file-size';endif;?>">
                        <div class="d-block align-items-center justify-content-between py-3">
                            <p class="resource-title-wrapper py-2">
                                <?=$resource->post_title?> (
                                    <?php 
                                    if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                        echo date('Y年 n月 j日', strtotime($resource->post_date));
                                    }
                                    elseif($my_current_lang == 'pt-pt'){
                                        echo date('j \d\e F, Y', strtotime($resource->post_date));
                                    }
                                    else {
                                        echo date('j F Y', strtotime($resource->post_date));
                                    }?>
                                    )
                            </p>
                            <p> <?=$resource->post_content;?> </p>
                            <div class="d-block abcd">
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
			<?php } ?>
        </div>
    </div>
</div>
<style>
    /* .wpdm-download-link.btn.btn-primary {
        display: none!important;
        } */
</style>
<?php 
    }else{

        $argumets_msg = array(
            'post_status' => 'publish',
            'post_type' => 'wpdmpro', 
            'posts_per_page' => -1,
            'tax_query' => array(
                array (
                    'taxonomy' => 'rinpoche_cats',
                    'field' => 'slug',
                    'terms' => $term->slug,
                )
            ),
        );
        // $message_data = get_posts($argumets_msg);
        $message_data = new WP_Query( $argumets_msg );

        // echo "<pre>";
        // print_r($message_data);

  

    ?>
    <style>
    /* .wpdm-download-link.btn.btn-primary {
            display: none!important;
        } */
</style>
    <div class="row rinpoche-message-row">
    <div class="col-md-11">
        <div class="ps-10 ps-sm-0">
            <div class="page-header-content pb-2">
            <?php the_archive_title( '<h5 class="mt-5">', '</h5>' );?>
            </div>
            <div class="sidebar-inner-box mt-3">
                <?php 
                            if($message_data):?>
                <ul>
                    <?php $index = 1; while ( $message_data->have_posts() ):
                    $id = get_the_ID();
                    
                    $resource = get_post($id);
                    // $message_data->the_post();
                    $package_size = get_package_data(get_the_ID(), 'package_size');
                    $size_int = (int) filter_var($package_size, FILTER_SANITIZE_NUMBER_INT);
                    ?>
                    <li class="align-items-center justify-content-between py-3 <?php if($size_int == 0 ): echo 'zero-file-size';endif;?>">
                        <div class="d-block align-items-center justify-content-between">
                            <p class="resource-title-wrapper py-2">
                                <?=$message_data->the_post()?>
                            </p>
                            <p> <?=$resource->post_content;?> </p>
                            <div class="d-block">
                                <?php
									echo do_shortcode('[wpdm_package id='.get_the_ID().']')
								?>
                            </div>
                        </div>
                    </li>
                    <?php $index++; endwhile;?>
                </ul>
                <?php else:?>
                <p> No Data Found ! </p>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
    <?php

    } ?>
    </div>
    <?php get_footer() ?>
</div>
