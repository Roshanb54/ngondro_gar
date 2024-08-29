<?php 
/**
 * @desc Student monthly hour reporting
 * @params {instructor_name} Name of the Instructor 
 * @params {language} [Array] Primary Language of the Instructor 
 * @params {secondary_languages} [Array] Secondary Language of the Instructor
 * @params {image} Profile Image of the Instructor 
 * @returns {get_the_content} Returns of the page content
 */
$instructor_name = get_the_title();
$language[] = get_field('primary_language');
$secondary_languages = get_field('secondary_languages');
$image = get_field('instructor_photo');
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
			<div class="row g-5">
				<div class="col-md-4">
					<div class="instructor-image">
						<img src="<?php echo $image_url;?>"  alt="<?php echo get_the_title();?>"/>
					</div>
					<h4><?=$instructor_name?></h4>
					<div class="instructor-languages">
						<div class="primary-language">
						<h5><?php echo __('Primary','ngondro_gar');?></h5>
							<span class="btn rounded-pill btn-default"><?=get_field('primary_language')?></span>
						</div>
						<div class="secondary-language">
							<h5><?php echo __('Secondary','ngondro_gar');?></h5>
							<?php foreach ($secondary_languages as $value):?>
							<span class="btn rounded-pill btn-default"><?=$value?></span>
							<?php endforeach;?>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="instructor-bio">
						<h3><?php echo __('BIO','ngondro_gar');?></h3>
						<?=get_the_content();?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

