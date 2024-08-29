<?php 
/**
 * Template Name: Contact Page
 * @desc Contact us page template
 * @params {page_title} title of the page
 * @params {short_content} content of the page
 * @params {contact_form} shortcode of the form
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */
if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
}
$ngondro_gar_settings = ngondro_gar_get_theme_options();
$contact_form = $ngondro_gar_settings['contact_form'];

$page_title = get_field('page_title');
$short_content = get_field('short_content');
?>
<?php
if(is_user_logged_in()) {
    ?>
    <div id="layoutSidenav_content">
<?php
}
?>
<Section class="contact-form-section pt-15">
	<div class="container">
		<div class="row g-5">
			<div class="col-md-5 offset-md-1">
				<div class="contact-page-title-wrapper d-flex align-items-center justify-content-center">
					<div class="contact-page-title-inner">
					<h3><?php if($page_title ): echo $page_title ; endif;?></h3>
					<p><?php if($short_content ): echo $short_content ; endif;?></p>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<?php 
				/*shortcut of contact form*/
				if($contact_form):
				 echo do_shortcode($contact_form); 
				 endif;
				 ?>
			</div>
		</div>
	</div>
</Section>
<?php
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

