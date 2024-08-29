<?php 
/**
 * Template Name: Single Course Page
 * @desc Single curriculum page 
 * @params {section_title} title of the section
 * @params {cid} current curriculum ID
 * @params {subcatid} sub curriculum ID
 */
get_header('loggedin');

global $wpdb;
$cid = isset($_GET['cid'])?$_GET['cid']:1;
$secid = isset($_GET['secid'])?$_GET['secid']:1;
$subcatid = isset($_GET['sub'])?$_GET['sub']:"";
$secid = str_replace("/","",$secid);

$course = $wpdb->get_row("Select * from ngondro_courses where course_id =".$cid);
$section = $wpdb->get_row("Select * from ngondro_course_cats where course_id =".$cid. " AND cat_id=".$secid);
$section_title = $section->title;

$my_current_lang = apply_filters( 'wpml_current_language', NULL );

if($subcatid!="")
{
    $resources = $wpdb->get_results("Select * from ngondro_resources where category = '$cid' AND section ='$secid' AND subcat = '$subcatid'");
}
else{
    $resources = $wpdb->get_results('Select * from ngondro_resources where category = '.$cid.' AND section ='.$secid);
}


$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$terms = get_queried_object();

// global $posts, $paged, $wp_query;
if(! empty($_GET['page']) && is_numeric($_GET['page']) ){
    $paged = $_GET['page'];
}else{
    $paged = 1;
}
$posts_per_page = (get_option('posts_per_page')) ? get_option('posts_per_page') : 10;
// $posts_per_page = 3;
$resource_args = array(
    'post_status' => 'publish',
    'post_type' => 'wpdmpro', 
    'posts_per_page' => -1,
    'paged' => $paged,
    'tax_query' => array(
        array (
            'taxonomy' => get_query_var( 'taxonomy' ),
            'field' => 'slug',
            'terms' => get_query_var( 'term' ),
        )
    ),
);
$all_posts = get_posts($resource_args);
$post_count = count($all_posts);
$num_pages = ceil($post_count / $posts_per_page);
if($paged > $num_pages || $paged < 1){
    $paged = $num_pages;
}
$resource_args = array(
    'post_status' => 'publish',
    'post_type' => 'wpdmpro', 
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'tax_query' => array(
        array (
            'taxonomy' => get_query_var( 'taxonomy' ),
            'field' => 'slug',
            'terms' => get_query_var( 'term' ),
        )
    ),
);
$resource_posts = get_posts($resource_args);
?>
<div id="layoutSidenav_content" class="single-wpdm-category-page">
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
            <div class="container-xl">
                <div class="page-header-content pb-5">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"></div>
                                 <?=$terms->name;?>
                            </h1>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- Main page content-->
        <section class="liturgy-page mb-12">
            <div class="container-xl">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="sidebar-inner-box resource-taxonomy-box">
                            <?php 
                                if($resource_posts):?>
                                    <ul>
                                        <?php $index = 1; foreach($resource_posts as $post):
                                            ?>
                                            <li class="align-items-center justify-content-between py-3">
                                                <div class="d-block align-items-center justify-content-between">
                                                    <p class="py-2">
                                                        <?php 
                                                        if($paged > 1){
                                                            $index_num = ($posts_per_page * ($paged - 1)) + $index;
                                                        }
                                                        else {
                                                            $index_num = $index;  
                                                        }
                                                        ?>
                                                        <?=$index_num?>. <?=$post->post_title?>
                                                    </p>
                                                   
                                                    <div class="d-block">
                                                        <?php
                                                          echo do_shortcode('[wpdm_package id='.$post->ID.']')
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php if($resource->password!="") :?> <p> <strong> Password: </strong> <?=$resource->password ?></p> <?php endif;?>
                                            </li>
                                        <?php $index++; endforeach;?>
                                    </ul>
                                    <?php 
                                    if($post_count > $posts_per_page ){

                                        echo '<div class="pagination">
                                                <ul>';

                                        if($paged > 1){
                                            echo '<li><a class="first" href="?page=1">&laquo;</a></li>';
                                        }else{
                                            echo '<li><span class="first">&laquo;</span></li>';
                                        }

                                        for($p = 1; $p <= $num_pages; $p++){
                                            if ($paged == $p) {
                                                echo '<li><span class="current">'.$p.'</span></li>';
                                            }else{
                                                echo '<li><a href="?page='.$p.'">'.$p.'</a></li>';
                                            }
                                        }

                                        if($paged < $num_pages){
                                            echo '<li><a class="last" href="?page='.$num_pages.'">&raquo;</a></li>';
                                        }else{
                                            echo '<li><span class="last">&raquo;</span></li>';
                                        }

                                        echo '</ul></div>';
                                    } ?>
                                <?php else:?>
                                  <p> No Data Found ! </p>  
                                <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php get_footer() ?>
</div>
