<?php 
/**
 * Template Name: Custom Elementor Page
 */
if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
} ?>
<?php 
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
if(!is_user_logged_in()){ ?>
	<?php the_content();?>
<?php
}
    else{
?>
 <div id="layoutSidenav_content" class="elementor-custom">
	<main>
	<?php the_content();?>
	</main>
	<?php get_footer();?>
</div>
<?php }	
    endwhile;
		else :
			_e( 'Sorry, no Contents were found.', 'ngondro_gar' );
	endif;
if(!is_user_logged_in()){
    get_footer();
}
?>