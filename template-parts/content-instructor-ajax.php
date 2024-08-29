<?php 
/*
 * @desc show instruction information on popup
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {get_user_meta} [object] Return all user meta values 
 * @params {get_the_title} [Value] Return title of the page/post
 * @returns {get_field()} [Value] Return acf field value base on field key
 * @returns {the_content()} Return content of the post
 */

$instructor_name = get_the_title();
$language[] = get_field('primary_language');
$secondary_languages = get_field('secondary_languages');
$image = get_field('instructor_photo');
$instructor_email = get_field('instructor_email');
if($image){
	$image_url = $image;
}
else {
	$image_url = 'https://via.placeholder.com/300X244';
}
?>
<div class="white-popup-block mfp-with-anim">
	<div cllass="instructor-inner-wrapper">
		<div class="container p-0">
			<div class="row g-5 g-custom">
				<div class="col-md-4 mobile-view-design">
					<div class="instructor-image">
						<img src="<?php echo $image_url;?>"  alt="<?php echo get_the_title();?>"/>
					</div>
					<div class="instructor-details-wrapper">
						<div class="instructor-details">
							<h4><?=$instructor_name?></h4>
							<?php if(is_user_logged_in() && $instructor_email){ ?>
								<a href="mailto:<?=$instructor_email?>" class="email"><i class="feather icon-mail"></i> <?=$instructor_email?></a>
							<?php } ?>
						</div>
						<div class="instructor-languages">
							<div class="primary-language">
							<h5><?php echo __('Primary','ngondro_gar');?></h5>
								<span class="btn rounded-pill btn-default"><?=get_field('primary_language')?></span>
							</div>
							<div class="secondary-language d-none d-md-block">
								<?php if(!empty($secondary_languages)){ ?>
								<h5><?php echo __('Secondary','ngondro_gar');?></h5>
								<?php foreach ($secondary_languages as $value):?>
								<span class="btn rounded-pill btn-default"><?=$value?></span>
								<?php endforeach;?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="instructor-languages-mobile d-block d-md-none">
					<div class="secondary-language">
							<?php if(!empty($secondary_languages)){ ?>
							<h5><?php echo __('Secondary','ngondro_gar');?></h5>
							<?php foreach ($secondary_languages as $value):?>
							<span class="btn rounded-pill btn-default"><?=$value?></span>
							<?php endforeach;?>
							<?php } ?>
						</div>
					</div>
					<div class="instructor-bio">
						<h3><?php echo __('BIO','ngondro_gar');?></h3>
						<?php the_content();?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>