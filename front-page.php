<?php 
$user = wp_get_current_user();
if( is_user_logged_in() && in_array( 'administrator', (array) $user->roles ) )
{
	wp_redirect(home_url('/dashboard/'));exit(); 
}
if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){
	wp_redirect(home_url('/dashboard/'));exit(); 
}
if(!in_array( 'instructor', (array) $user->roles )){
get_header();
}

$user = wp_get_current_user();
if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
<section class="landing-page-wrapper mt-10 logged-in-user">
<div class="container">
	<div class="row">
		<div class="col-md-3"> 
			<div class="left-sidebar-wrapper">
				<div class="course-progression-wrapper">
					<h3 class="sidebar-title"><?php echo __('Course Progression','ngondro_gar');?></h3>
					<div class="sidebar-inner-box text-center mb-10">
						<?php
							$uid = get_current_user_id();
							$first_day_of_month = date('Y-m-01');
							$last_day_of_month = date('Y-m-t');
							$user_course_id = get_the_author_meta( 'curriculum', get_current_user_id() );
							$user_report  = $wpdb->get_row("SELECT SUM(`preliminaries`) AS 'preliminaries', SUM(`refuge`) AS 'refuge', SUM(`vajrasattva`) AS 'vajrasattva', SUM(`mandala`) AS 'mandala', SUM(`guru_yoga`) AS 'guru_yoga', `user_id` from user_reporting WHERE `course_id` = '$user_course_id' AND user_id = '$uid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");

							$total_user_reporting = (int)$user_report->preliminaries + (int)$user_report->refuge + (int)$user_report->vajrasattva + (int)$user_report->mandala + (int)$user_report->guru_yoga;

							$total_required = (int)get_option('rpreliminaries') + (int)get_option('rrefuge') +(int)get_option('rvajrasattva') + (int)get_option('rmandala') + (int)get_option('rguru_yoga');
							$per = ($total_user_reporting * 100)/$total_required;
							
							$cdate = date('Y-m-d');
							$user_last_report  = $wpdb->get_results("SELECT * from user_reporting WHERE `course_id` = '$user_course_id' AND user_id = '$uid' AND `reporting_date` <= '$cdate' ORDER BY id DESC LIMIT 0,1");
							$last_due_msg = "hide_due_msg";
							if($user_last_report){
								$last_due_date = $user_last_report[0]->reporting_date;
								//$last_due_date = date_create($last_due_date);
								//$last_due_date = date_format($last_due_date, "m-d-Y");
								$last_due_date = date("m-d-Y", strtotime($last_due_date. "+ 1 day"));
								$last_due_msg = "show_due_msg";
							}
						?>
						<h4 class="course-title">
						<?php 	$curriculum = get_the_author_meta( 'curriculum', get_current_user_id() );
								$courses = $wpdb->get_row("Select * from ngondro_courses where course_id = $curriculum");
								if($courses){ echo $courses->title;}
						?> 
						</h4>
						<svg viewBox="0 0 36 36" class="circular-chart maroon">
						<path class="circle-bg"
							d="M18 2.0845
							a 15.9155 15.9155 0 0 1 0 31.831
							a 15.9155 15.9155 0 0 1 0 -31.831"
						/>
						<path class="circle"
							stroke-dasharray="<?=number_format($per,1);?>, 100"
							d="M18 2.0845
							a 15.9155 15.9155 0 0 1 0 31.831
							a 15.9155 15.9155 0 0 1 0 -31.831"
						/>
						<text x="18" y="20.35" class="percentage"><?=number_format($per,1);?>%</text>
						</svg>
						<div class="total-completed-hours"><span><?=$total_user_reporting?></span>/<?=$total_required?> Hrs</div>
						<div class="next-reporting-date <?=$last_due_msg?>"> <?php echo __('Next report due on','ngondro_gar');?> <br/><span class="reporting-date"><?=$last_due_date?></span></div>
						<a class="btn btn-lg btn-tranparent mt-7" href="<?php echo home_url('/dashboard/hours-reporting')?>"><?php echo __('Report hours','ngondro_gar');?></a>
					</div>
					<div class="visit-course-box d-flex justify-content-center">
						<?php if($courses):?>
							<a href="<?=home_url('/courses/details?cid='.$curriculum);?>">Visit <?=$courses->title?> <i class="icon feather icon-chevron-right"></i></a>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="center-box-wrapper">
				<div class="announcements-box-wrapper">
					<div class="box-title-wrapper">
					<h3><?php echo __('Recent announcements','ngondro_gar');?></h3>
					<a href="<?php echo home_url('/');?>announcements-events/"><?php echo __('See All','ngondro_gar');?></a>
					</div>
					<div class="announcements-content-wrapper">
						<?php
							$lang = get_the_author_meta( 'language', get_current_user_id() );
							$type = "announcement";
							$announcements = new WP_Query( 
								array(
									'post_type' => $type,
									'posts_per_page'=> -1,
									'orderby' => 'Id',
									'hide_empty' => true,
									'order' => 'DESC',
									'post_status' => 'publish',
									'meta_query'  => array(
										'relation' => 'AND',
											array(
												'key'     => "language",
												'value'   => array($lang,'und'),
												'compare' => 'IN'
											)
									),
								) 
							);
						?>
						<div class="announcements-slider">

							<?php
							if($announcements -> have_posts()) :	
								while ($announcements -> have_posts()) : $announcements ->the_post();
								$title = get_the_title(get_the_ID());
								$name = get_field('name', get_the_ID());
								$location = get_field('location', get_the_ID());
								$email = get_field('email', get_the_ID());
								$short_description = get_field('short_description', get_the_ID());
								$fdate = get_field('from_date', get_the_ID());
								$tdate = get_field('to_date', get_the_ID()); 
								$link = get_the_permalink(get_the_ID());
								$month = date('F', strtotime($date));
								$year = date('Y', strtotime($date));
								$day = date('d', strtotime($date));
							?>

							<div class="single-announcement-item">
								<div class="announcement-content-inner">
									<h4><?=$title?></h4>
									<p><?=$short_description?> <a href="<?=$link?>">Read More</a></p>
								<ul>
									<li><i class="icon feather icon-user"></i> <?=$name?></li>
									<li><i class="icon feather icon-map-pin"></i> <?=$location?></li>
									<li><i class="icon feather icon-mail"></i><?=$email?></li>
								</ul>
								</div> 
								<div class="accouncement-date-wrapper">
									<div class="calendar-date float-end"><?=$from_date?> </div>
								</div>
							</div>
						<?php endwhile; endif;?>

						</div>
					</div>
				</div>
				<div class="upcoming-events-section">
					
					<div class="upcoming-events-contents-wrapper">
							<div class="row">
								<div class="col-md-12">
									<div class="sidebar-inner-box">
										<div class="box-title-wrapper d-flex align-items-center justify-content-start">
											<div class="ellipse d-flex align-items-center justify-content-center me-2">
												<i class="icon feather icon-calendar"></i>
											</div>
											<h2><?php echo __('Upcoming Events','ngondro_gar');?></h2>
										</div>
										<?php echo do_shortcode( '[tribe_events view="month"]' ); ?>
									</div>
								</div>
							</div>
					</div>
				</div>
				<div class="message-section">
					<div class="box-title-wrapper mt-10">
						<div class="section-title">
						<h3><?php echo __('Messages from Riponche','ngondro_gar');?></h3>
						<p><?php echo __('Checkout what our guru himself has to say.','ngondro_gar');?></p>
						</div>
						<a href="<?=site_url('/about')?>"><?php echo __('See All','ngondro_gar');?></a>
						</div>
						<div class="video-message-wrapper">
							<?php
							$video_link = 'https://www.youtube.com/watch?v=opKgEVI7NRI';
							$video_thumbnail_url = get_video_thumbnail($video_link);
							 ?>
							<div class="videos-inner-image" style="background-image:url(<?php echo $video_thumbnail_url;?>);">
								<a href="<?php echo $video_link;?>" class="magnific-popup">
									<div class="overlay"></div>
									<div class="play-icon-img">
										<div class="play-icon"></div> 
									</div>
									<div class="videos-inner-content">
										<h3><?php echo __('Vesak Day Bodhisattva Vow','ngondro_gar');?></h3>
									</div>
								</a>
							</div>
							
						</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
		<div class="right-sidebar-wrapper mb-10" id="right-sidebar">
				<div class="your-instructor-wrapper">
					<h4 class="sidebar-title"><?php echo __('Your instructor','ngondro_gar');?></h4>
					<div class="instructor-profile">
					<?php $ins_id = (int) get_the_author_meta( 'instructor', get_current_user_id() );
						$args =  array(
							'post_type' => 'instructor',
							'posts_per_page'=> 1,
							'hide_empty' => true,
							'meta_key'=> 'instructor',
							'meta_value' =>	$ins_id					
						);
						$ins_post = get_posts($args)[0];
						$ins_post_id = $ins_post->ID;
						$ins_image = get_field('instructor_photo',$ins_post_id);
						$ins_name = get_the_title($ins_post_id);
					?>
						<img src="<?=$ins_image?>" alt="instructor image"/>
						<div class="your-instructor-name">
							<a class="ajax-popup" href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=instructor_popup_ajax&post_id=<?=$ins_post_id?>">
								<?=$ins_name?>
							</a>
						</div>
					</div>
				</div>
				<div class="suggested-box-wrapper mt-10">
					<h4 class="sidebar-title"><?php echo __('Suggested','ngondro_gar');?></h4>
					<div class="visit-course-box d-flex justify-content-start">
						<div class="suggested-content-inner">
						<p><?php echo __('Vist Our FAQ for New Students to learn more','ngondro_gar');?></p>
						<a href="<?=home_url('/faqs')?>"><?php echo __('Visit course ','ngondro_gar');?><i class="icon feather icon-chevron-right"></i></a>
						</div>
					</div>
				</div>
				<div class="introduction-box-wrapper mt-10">
					<h4 class="sidebar-title"><?php echo __('Introduction to Ngondro Gar','ngondro_gar');?></h4>
					<div class="introduction-content-inner clearfix">
					<?php
							$type = "wpdmpro";
							$downloads = new WP_Query( 
								array(
									'post_type' => $type,
									'posts_per_page'=> 3,
									'orderby' => 'Id',
									'hide_empty' => true,
									'order' => 'DESC',
									'post_status' => 'publish',
								) 
							);
							if($downloads -> have_posts()):	
						?>
						<ul>
							<?php while ($downloads -> have_posts()) : $downloads->the_post();
								$permalink = get_permalink(get_the_ID());
								$video = get_field('video_section', get_the_ID());
								$audio = get_field('audio_section', get_the_ID());
								$file = get_field('file_section', get_the_ID());
								if($video){
									$file_type = "Video";
								}
								else if($audio){
									$file_type = "Audio";
								}
								else{
									$file_type = "File";
								}
							?>
							<li><a href="<?=$permalink?>"><span><?=$file_type?></span><?=get_the_title(get_the_ID())?></a></li>
							<?php endwhile;?>
						</ul>
						<a href="<?=site_url('/courses')?>" class="float-end"><?php echo __('See All','ngondro_gar');?> <i class="icon feather icon-chevron-right"></i></a>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<?php
} 
else if( is_user_logged_in() && in_array( 'instructor', (array) $user->roles ) )
{
	get_template_part( 'page-templates/instructor-dashboard-template', 'page' ); 
}
else
{ 	
?>
<section class="landing-page-wrapper">
	<div class="container-fluid landing-page-full-height d-flex"><!--flex-column-->
		<div class="row flex-grow-1">
		<!-- flex-grow-1 sm-reverse-column -->
			<div class="col-xl-7 col-md-6 col-sm-12 bg-yellow">
				<div class="left-intro-box pt-8 px-15 mb-8 text-center">
					<img src="<?php echo get_the_post_thumbnail_url();?>" alt="Ngondro Gar"/>
					<?php the_content();?>
				</div>
			</div>
			<div class="col-xl-5 col-md-6 col-sm-12"> 
				<div class="landing-page-login-form-wrapper justify-content-center d-flex">
					<div class="login-form-inner">
					<h3><?php echo __('Login','custom_login');?></h3>
					<?php the_custom_form_login(); ?>
					</div>
					<!-- <div class="landing-page-footer-menu">
					<?php 
						// wp_nav_menu( 
						// 	array( 
						// 		'theme_location' => 'footer-menu'
						// 	) 
						// ); 
					?>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</section>

<?php } ?>

<?php get_footer();?>
