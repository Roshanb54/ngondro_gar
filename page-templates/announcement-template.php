<?php 
/**
 * Template Name: Announcement Page
 * @desc Announcement Page
 * @params {page_title} title of the Page
 * @params {page_subtitle} Sub title of the Page
 * @params {short_content} Content of the Page
 */

get_header('loggedin');
$page_title = get_field('page_title');
$page_subtitle = get_field('page_subtitle');
$short_content = get_field('short_content');
?>
<!--<Section class="announcement-page innerpage-top-section bg-light-yellow pt-13 pb-15">
	<div class="container">
		<div class="row g-5 ">
			<div class="col-md-5">
				<div class="page-title-wrapper  d-flex align-items-center justify-content-center">
					<div class="innerpage-title-inner">
					<h4><?php /*if($page_subtitle ): echo $page_subtitle ; endif;*/?></h4>
					<h3><?php /*if($page_title ): echo $page_title ; endif;*/?></h3>
					<p><?php /*if($short_content ): echo $short_content ; endif;*/?>
  						</p>
					</div>
				</div>
			</div>
			<div class="col-md-6 offset-md-1">
				<div class="announcements-content-wrapper">
					<?php
/*						$type = "announcement";
						$announcements = new WP_Query( 
							array(
								'post_type' => $type,
								'posts_per_page'=> -1,
								'orderby' => 'Id',
								'hide_empty' => true,
								'order' => 'DESC',
								'post_status' => 'publish',
							) 
						);
					*/?>

					<div class="announcements-slider">
						<?php
/*						if($announcements -> have_posts()) :
							while ($announcements -> have_posts()) : $announcements ->the_post();
							$title = get_the_title(get_the_ID());
							$name = get_field('name', get_the_ID());
							$location = get_field('location', get_the_ID());
							$email = get_field('email', get_the_ID());
							$short_description = get_field('short_description', get_the_ID());
							$date = get_field('date', get_the_ID());
							$link = get_the_permalink(get_the_ID());
							$month = date('F', strtotime($date));
							$year = date('Y', strtotime($date));
							$day = date('d', strtotime($date));
						*/?>

						<div class="single-announcement-item">
							<div class="announcement-content-inner">
								<h4><?/*=$title*/?></h4>
								<p><?/*=$short_description*/?> <a href="<?/*=$link*/?>"><?php /*echo __('Read More','ngondro_gar');*/?></a></p>
							<ul>
								<li><i class="icon feather icon-user"></i> <?/*=$name*/?></li>
								<li><i class="icon feather icon-map-pin"></i> <?/*=$location*/?></li>
								<li><i class="icon feather icon-mail"></i><?/*=$email*/?></li>
							</ul>
							</div> 
							<div class="accouncement-date-wrapper">
								<div class="calendar-date float-end"><?/*=$date*/?> </div>
							</div>
						</div>
						<?php /*endwhile; endif;*/?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</Section>
<section class="upcoming-events-contents-wrapper py-12 bg-light">
	<div class="container">
		<div class="row">
			<div class="col-md-12"><div class="event-section-title pb-8"><h3><?php /*echo __('Upcoming events','ngondro_gar');*/?></h3></div></div>
			
			<?php
/*				$type = "tribe_events";
				$events = new WP_Query( 
					array(
						'post_type' => $type,
						'posts_per_page'=> -1,
						'orderby' => 'Id',
						'hide_empty' => true,
						'order' => 'DESC',
						'post_status' => 'publish',
					) 
				);

				if($events -> have_posts()) :	
					while ($events -> have_posts()) : $events ->the_post();
					$title = get_the_title(get_the_ID());
					$meta_data = get_post_meta(get_the_ID());
					$end_date = $meta_data['_EventEndDate'];
					$start_date = $meta_data['_EventStartDate'];

					if($start_date && $end_date){
						$sdate=date_create($start_date[0]);
						$event_start_time = date_format($sdate, "g:i:s A");
						$sdate = date_format($sdate, "M d");
						$edate=date_create($end_date[0]);
						$edate = date_format($edate, "M d");
						$event_date = $sdate. " - ".$edate;
						
					}
					else{
						$sdate=date_create($start_date[0]);
						$event_start_time = date_format($sdate, "g:i:s A");
						$sdate = date_format($sdate, "M d");
						$event_date = $sdate;
						
					}
					
					$orgs = $meta_data['_EventOrganizerID'];
					$timezone = $meta_data['_EventTimezone'][0];
			*/?>
			<div class="col-md-4">
				<div class="events-content-box">
				<a class="popup-link" data-effect="mfp-move-from-right" href="<?php /*echo admin_url( 'admin-ajax.php' ); */?>?action=events_ajax_slide&post_id=<?/*=get_the_ID()*/?>">
					<div class="event-date"><?/*=$event_date*/?></div>
					<div class="event-title py-10"><h4><?/*=$title*/?></h4></div>
					<div class="event-details">
						<ul>
							<?php /*foreach($orgs as $org):
								$org_name = get_the_title($org);
							*/?>
							<li><i class="icon feather icon-user"></i> <?/*=$org_name*/?></li>
							<?php /*endforeach;*/?>
							<li><i class="icon feather icon-clock"></i> <?php /*echo $event_start_time." ".$timezone;*/?></li>
						</ul>
					</div>
					</a>
				</div>
			</div>
			<?php /*endwhile; endif;*/?>

		</div>
	</div>
</section>-->
    <div id="layoutSidenav_content">
        <main>
            <Section class="announcement-page innerpage-top-section pt-12 pb-4">
                <div class="container px-10 px-sm-1">
                    <div class="row align-items-center g-5">
                        <div class="col-md-6 mx-sm-0">
                            <div class="page-title-wrapper d-flex align-items-start align-items-md-start justify-content-center py-8">
                                <div class="innerpage-title-inner">
                                    <h4><?php if($page_subtitle ): echo $page_subtitle ; endif;?></h4>
                                    <h3><?php if($page_title ): echo $page_title ; endif;?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mx-sm-0">
                            <p><?php if($short_content ): echo $short_content ; endif;?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <!--Announement Section-->
                        <?php get_template_part( 'template-parts/content', 'announcements' );?>
                    </div>
                </div>
            </Section>
            <div class="container px-10 px-sm-1">
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="sidebar-inner-box upcoming-event-box">
                            <div class="box-title-wrapper d-flex align-items-center justify-content-start">
                                <div class="ellipse d-flex align-items-center justify-content-center me-2">
                                    <i class="icon feather icon-calendar"></i>
                                </div>
                                <h2>Upcoming Events</h2>
                            </div>
							<?php echo do_shortcode( '[tribe_events view="month"]' ); ?>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php get_footer();?>
    </div>


