<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ngondro_Gar
 */

 if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
}
?>
<?php
if(is_user_logged_in()) {
    ?>
    <div id="layoutSidenav_content">
<?php
}
?>
	<?php if ( have_posts() ) : ?>
		<header class="page-header page-header-dark bg-gradient-primary-to-secondary">
			<div class="container-xl">
				<div class="page-header-content pb-5">
					<div class="row align-items-center justify-content-between">
						<div class="col-auto mt-4">
						<?php the_archive_title( '<h1 class="page-header-title">', '</h1>' );?>
						</div>
					</div>

				</div>
			</div>
		</header>
		<section class="liturgy-page mb-12">
		<div class="container-xl">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="sidebar-inner-box resource-taxonomy-box">
					<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
				echo do_shortcode('[wpdm_package id='.get_the_ID().']');

				endwhile; ?>
					</div>
				</div>
			</div>
		</div>
</section>

<?php
endif;
if(is_user_logged_in()) {
    get_footer();
?>
    </div>
<?php } ?>

<?php
if(!is_user_logged_in()){
    get_footer();
}
?>