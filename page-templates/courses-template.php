<?php 
/**
 * Template Name: Courses Page
 * @desc curriculum page
 * @returns {get_current_user_id} Returns  
 * @params {terms} [object] Return all curriculums
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info 
 */
get_header(); 

global $wpdb;

$terms = $wpdb->get_results("Select * From ngondro_courses"); 

?>
<section class="courses-page-wrapper mt-10 logged-in-user">
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
							$user_report  = $wpdb->get_row("SELECT SUM(`preliminaries`) AS 'preliminaries', SUM(`refuge`) AS 'refuge', SUM(`vajrasattva`) AS 'vajrasattva', SUM(`mandala`) AS 'mandala', SUM(`guru_yoga`) AS 'guru_yoga', `user_id` from user_reporting WHERE user_id = '$uid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");

							$total_user_reporting = (int)$user_report->preliminaries + (int)$user_report->rrefuge + (int)$user_report->vajrasattva + (int)$user_report->mandala + (int)$user_report->guru_yoga;
							$total_required = (int)get_option('rpreliminaries') + (int)get_option('rrefuge') +(int)get_option('rvajrasattva') + (int)get_option('rmandala') + (int)get_option('rguru_yoga');
							$per = ($total_user_reporting * 100)/$total_required;
							$cdate = date('Y-m-d');
							$user_last_report  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `reporting_date` <= '$cdate' ORDER BY id DESC LIMIT 0,1");
							$last_due_msg = "hide_due_msg";
							if($user_last_report){
								$last_due_date = $user_last_report[0]->reporting_date;
								//$last_due_date = date_create($last_due_date);
								//$last_due_date = date_format($last_due_date, "m-d-Y");
								$last_due_date = date("m-d-Y", strtotime($last_due_date. "+ 1 day"));
								$last_due_msg = "show_due_msg";
							}
						?>
					
						<h4 class="course-title"><a href="<?=site_url('courses')?>">Longchen Nyingtik Ngondro (LNN)</a></h4>
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
						
					</div>
					<div class="visit-course-box d-flex justify-content-center">
						<a href="#">Visit LNN Resources <i class="icon feather icon-chevron-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="center-box-wrapper">
				<div class="courses-box-wrapper">
					<div class="box-title-wrapper d-block">
					<h2><?php echo __('Practice Resources','ngondro_gar');?></h2>
					</div>
					<div class="row">
					<?php
						foreach($terms as $term):
						$short_name = $term->short_name;
						$permalink = site_url('courses/details?cid='.$term->course_id);
					?>
						<div class="col-md-6">
							<div class="single-course-box">
								<a href="<?=$permalink?>">
								<h4><?=$term->title?> <br/> <?=$short_name?> </h4>
								<!--<div class="active-btn">Active</div>!-->
								<p><?=$term->description?></p>
								<div class="course-total-hrs">
								<i class="far fa-clock"></i> <?=$total_required?> <?php echo __('Hours','ngondro_gar');?>
								</div>
								</a>
							</div>
						</div>
						<?php endforeach;?>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<?php get_footer();?>