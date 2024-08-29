<?php 
/**
 * Template Name: Instructors Page
 *  @desc Instructor Page
 *  @params {title} title of the page
 *  @params {short_content} content of the page
 *  @params {wpml_lang} get wpml current language
 *  @params {instructors} [Array] array of all instructor
 */ 

if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
}

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
<section class="inner-page-heading pt-15 pb-15 with-vector-curve">
	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4 text-center">
			<h2><?php if($page_title ): echo $page_title ; endif;?></h2>
			<p><?php if($short_content ): echo $short_content ; endif;?></p>
			</div>
		</div>
	</div>
</section>
<section class="instructors-section-wrapper pb-10">
<div class="container">
	<div class="row">
	<?php
		$type = "instructor";
		$wpml_lang = apply_filters( 'wpml_current_language', NULL );
		if($wpml_lang=="zh-hant" || $wpml_lang=="zh-hans"){
			$args = array (
				'post_type' => $type,
				'posts_per_page'=> -1,
				'meta_key' => 'first_name',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'hide_empty' => true,
				'meta_query' => array(
					array(
						'key' => 'availability',
						'value' => 'yes',
						'compare' => '='
					)					
				)
			);

			$instructors = new WP_Query( $args );
		}
		elseif($wpml_lang=="pt-pt"){
			$instructors = new WP_Query( 
				array(
					'post_type' => $type,
					'suppress_filters' => true,
					'posts_per_page'=> -1,
					'orderby' => 'title',
					'order' => 'ASC',
					'post_status' => 'publish',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
								array(
									'key' => 'primary_language',
									'value' => 'english',
									'compare' => '='
								),
								array(
									'key' => 'primary_language',
									'value' => 'portugues',
									'compare' => '='
								)
							),
						array(
							'key' => 'availability',
							'value' => 'yes',
							'compare' => '='
						)	
					)
				) 
			);

		}
		else{
			$instructors = new WP_Query( 
				array(
					'post_type' => $type,
					'posts_per_page'=> -1,
					'hide_empty' => true,
					'order' => 'ASC',
					'orderby' => 'title',
					'post_status' => 'publish',
					'meta_query' => array(
						array(
							'key' => 'availability',
							'value' => 'yes',
							'compare' => '='
						)					
					)
				) 
			);
		}

		if($instructors -> have_posts()) :	
			while ($instructors -> have_posts()) : $instructors ->the_post();
			$ins_image = get_field('instructor_photo', get_the_ID());
			$primary_lang[] = get_field('primary_language', get_the_ID());
			$plang = get_field('primary_language', get_the_ID());
			$secondary_lang = get_field('secondary_languages', get_the_ID());
			$ins_userid = get_field('instructor', get_the_ID());
			$languages = array_unique(array_merge($primary_lang, $secondary_lang));
			$languages = implode(', ', $languages);
		?>

		<div class="col-lg-3 col-md-3 col-sm-6 col-12">
			<div class="instructor-box-wrapper">
				<a class="ajax-popup" href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=instructor_popup_ajax&post_id=<?php echo get_the_ID(); ?>">
				<img class="instuctor-box" src="<?=$ins_image?>" alt="instructor name"/>
				<div class="instructor-details">
					<h4 class="instructor-name"><?php echo __(get_the_title(get_the_ID()), 'ngondro_gar');?></h4>
					<div class="languages">
						<?php echo __('Language: ', 'ngondro_gar');?><?php echo __($plang,'ngondro_gar');?>
					</div>
				</div>
			</a>
		</div>
	</div>
	<?php endwhile; endif; ?>
</section>
<?php
if(is_user_logged_in()) {
    get_footer();
    ?>
    </div>
<?php } else{
    get_footer();
}
    ?>