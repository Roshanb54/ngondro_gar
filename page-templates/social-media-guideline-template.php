<?php 
/**
 * Template Name: Social Media Guidelines Page
 * @desc Social Media Guidelines Page
 * @params {page_title} title of the page
 * @params {short_content} content of the page
 * @returns {the_content()} Return content of the page
 */
if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
}
$page_title = get_field('page_title');
$short_content = get_field('short_content');
if(is_user_logged_in()){
    ?>
    <div id="layoutSidenav_content">
    <?php
}
?>
<section class="social-media-page-wrapper pb-15">
	<div class="inner-page-heading pt-10 pb-12">
		<div class="container">
			<div class="row">
				<div class="col-md-10 offset-md-1">
				<div class="breadcrumb-wrapper">
				<?php roshan_breadcrumbs();?>
				</div>
				<h2><?php if($page_title ): echo $page_title ; endif;?></h2>
					<p><?php if($short_content ): echo $short_content ; endif;?>
  						</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<div class="guideline-content-inner">
				<?php the_content();?>
				</div>
			</div>
		</div>
	</div>
</section><?php
if(is_user_logged_in()){
    ?>
    <?php get_footer();?>
    </div>
    <?php
}
?>


<?php get_footer();?>