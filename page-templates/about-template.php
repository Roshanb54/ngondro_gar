<?php 
/**
 * Template Name: About Page
 *  @desc About Page
 *  @params {title} title of the page
 *  @params {content} content of the page
 *  @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */
if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
}
$page_title = get_field('page_title');
$short_content = get_field('short_content');
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	if(has_post_thumbnail(get_the_ID())){
		$about_img = get_the_post_thumbnail_url(get_the_ID());
	} else {
	  $about_img = 'https://via.placeholder.com/1070X800';
	}
	if(!is_user_logged_in()){
	?>

<Section class="about-us-top-section pt-20 pb-20" style="background-image:url(<?php echo $about_img;?>);">
	<div class="container">
		<div class="row g-5">
			<div class="col-md-6">
				<div class="about-page-title-wrapper d-flex align-items-center justify-content-center pe-5">
					<div class="about-page-title-inner">
					<h3 class="pb-5"><?php if($page_title ): echo $page_title ; endif;?></h3>
					<p><?php the_content();?> <?php //if($short_content ): echo $short_content ; endif;?>
  						</p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="about-us-image-box float-end d-lg-none  d-md-none d-sm-block">
					<img src="<?php echo $about_img;?>" alt="<?php echo get_the_title();?>"/>
				</div>
			</div>
		</div>
	</div>
</Section>
<section class="about-content-section py-12 bg-white d-none">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="about-content-inner text-center">
					<h3><?php echo get_the_title();?></h3>
					<?php the_content();?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="custom-spacer pt-17 d-none">
</section>
<?php
	}
    else{
    ?>
        <div id="layoutSidenav_content">

            <Section class="about-us-top-section pt-15 pb-15" style="background-image:url(<?php echo $about_img;?>);">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-md-6">
                            <div class="about-page-title-wrapper d-flex align-items-center justify-content-center pe-5">
                                <div class="about-page-title-inner">
                                    <h3 class="pb-5"><?php if($page_title ): echo $page_title ; endif;?></h3>
                                    <p><p><?php the_content();?><?php //if($short_content ): echo $short_content ; endif;?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-us-image-box float-end d-lg-none  d-md-none d-sm-block">
                                <img src="<?php echo $about_img;?>" alt="<?php echo get_the_title();?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            </Section>
            <section class="about-content-section py-12 bg-white d-none">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="about-content-inner text-center">
                                <h3><?php echo get_the_title();?></h3>
                                <?php the_content();?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php get_footer()?>
        </div>

<?php }
    endwhile;
		else :
			_e( 'Sorry, no Contents were found.', 'ngondro_gar' );
		endif; ?>

<?php
if(!is_user_logged_in()){
    get_footer();
}
?>
