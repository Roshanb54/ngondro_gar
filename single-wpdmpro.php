<?php 
/**
 * @desc Single Resources page 
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

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$terms = get_queried_object();

global $posts;

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
                                 <?php echo get_the_title();?>
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
                                while ( have_posts() ) :
                                    the_post();
                                    get_template_part( 'template-parts/wpdm', get_post_type() );
                                endwhile; // End of the loop.
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php get_footer() ?>
</div>

<style>
.nav-fixed .topnav {
    z-index: 1!important;
}
/* .col-md-7 .mt-0{
    display: none!important;
} */
</style>