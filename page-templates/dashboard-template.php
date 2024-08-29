<?php
/**
 * Template Name: Dashboard Page
 * @desc User Dashboard page with latest announcement and events and user data graph and other info
 * @returns {wp_get_current_user()} [Array] Return current user details
 * @params {subjects} [Array] Array of curriculum
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 *  @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */

if(!is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}

get_header('loggedin');

global $wpdb;
$my_current_lang = apply_filters( 'wpml_current_language', NULL );
?>

            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-5 pt-10 d-none">
                        <div class="container-xl px-sm-1 px-10">
                            <div class="page-header-content">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto">
                                        <h1 class="page-header-title student-name-with-signout">
                                            <div class="page-header-icon"></div>
											<?php $user_data = wp_get_current_user();
											?>
                                            <?=$user_data->data->display_name;?><a href="<?php echo wp_logout_url( home_url() ); ?>">(Sign out)</a>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-sm-1 ps-5 pe-10 pb-5 pt-5">
                        <div class="row">
                            <div class="col-xl-7 col-xl-7 col-lg-7 col-md-7">
                                <!-- Dashboard graph section data -->
								<div class="course-progression-wrapper" style="min-height:345px;">
									<div class="sidebar-inner-box mb-6 dashboard-course-progress-box">
										<?php
											$uid = get_current_user_id();
											/*user reporting*/
											$first_day_of_month = date('Y-m-01');
											$last_day_of_month = date('Y-m-t');

											$month_ini = new DateTime("first day of last month");
											$month_end = new DateTime("last day of last month");

											$first_day_of_last_month = $month_ini->format('Y-m-d');
											$last_day_of_last_month = $month_end->format('Y-m-d');

											//$user_reports  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");

											$curriculum = get_the_author_meta( 'curriculum',  $uid ); 
											$subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = '$curriculum'");
											$subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = '$curriculum'");

											$cols = "";
											foreach($subjects as $subject){
												$cols .= "SUM(".$subject->slug.") as ".$subject->slug." ,";
											}
											$user_reports  = $wpdb->get_row("SELECT  $cols user_id from `user_reporting` WHERE user_id = '$uid' ", ARRAY_A);
											$total_user_reporting = 0;
											foreach($subjects as $subject){
												$total_user_reporting += (int)$user_reports[$subject->slug];
											}

											$total_required = (int) $subjects_total->total_hour;
                                            if($total_required > 0){
											$per = ($total_user_reporting * 100)/$total_required;
                                            }
                                            else {
                                            $per = 0; 
                                            }

											$cdate = date('Y-m-d');
											$user_last_report  = $wpdb->get_results("SELECT * from user_reporting WHERE `course_id` = '$curriculum' AND user_id = '$uid' AND `reporting_date` <= '$cdate' ORDER BY id DESC LIMIT 0,1");
											$last_due_msg = "hide_due_msg";
											if($user_last_report){
												$last_due_date = $user_last_report[0]->reporting_date;
												//$last_due_date = date_create($last_due_date);
												//$last_due_date = date_format($last_due_date, "m-d-Y");
												$last_due_date = date("m-d-Y", strtotime($last_due_date. "+ 1 day"));
												$last_due_msg = "show_due_msg";
											}

                                            if( $per > 100){$per= 100;}   
										?>
                                        <div class="box-title-wrapper d-flex align-items-center justify-content-start">
                                            <div class="ellipse activity-wrap d-flex align-items-center justify-content-center me-2">
                                                <i class="icon feather icon-activity"></i>
                                            </div>
                                            <h5 class="mb-0"><?php echo __('Course Progression','ngondro_gar');?></h5>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-around sm-flex-direction">
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
                                            <div class="text-left text-md-left ms-3">
                                                <h4 class="course-title">

                                                    <?php
                                                    $curriculum = get_the_author_meta( 'curriculum', get_current_user_id() );
                                                    $courses = $wpdb->get_row("Select * from ngondro_courses where course_id = $curriculum");
                                                    if($courses){ echo __($courses->title,'ngondro_gar');}
                                                    ?>
                                                </h4>
                                                <div class="total-completed-hours"><span><?php echo __('Total Hours:','ngondro_gar');?> </span><?=$total_required?>
                                                    <span><?php echo __('Hrs','ngondro_gar');?></span></div>
                                                <div class="total-completed-hours "><span><?php echo __('Hours Accumulated:','ngondro_gar');?> </span><?=$total_user_reporting?>/<?=$total_required?> <span><?php echo __('Hrs','ngondro_gar');?></span></div>
                                                <div class="total-completed-hours"><span><?php echo __('Hours Left:','ngondro_gar');?> </span><?=$total_required-$total_user_reporting?> <span><?php echo __('Hrs','ngondro_gar');?></span></div>
<!--                                            <a class="btn btn-lg btn-tranparent mt-7" href="--><?php //echo     home_url('/')?><!--hours-reporting">Report hours</a>-->
                                            </div>
                                        </div>

									</div>
                            	</div>
							</div>
                            <div class="col-xl-5 col-lg-5 col-md-5 mb-6">
                                <div class="row get-height-box">
                                    <div class="col-xl-12 report-due-box mb-6">
                                    <?php
                                    $uid = get_current_user_id();
                                    $first_day_of_month = date('Y-m-01');
                                    $last_day_of_month = date('Y-m-t');
                                    $user_course_id = get_the_author_meta( 'curriculum', $uid );
                                    $all_reports =  $wpdb->get_results("Select * from user_reporting where user_id =".$uid." order by id ASC");
                                    $pcount = count($all_reports);
                                    
                                    $last_reports =  $wpdb->get_results("Select * from user_reporting where user_id =".$uid." order by id DESC limit 0,1");
                                    
                                    if($pcount>=1){
                                        $start_date = $all_reports[0]->reporting_date;
                                        $last_element = $pcount-1;
                                        $last_date = date('Y-m-d');
                                        $date1=date_create($start_date);
                                        $date2=date_create($last_date);
                                        $diff=date_diff($date1,$date2);
                                        $total_days = $diff->d;
                                        
                                        if($total_days==0) {
                                            $missed_report = 0;
                                        }
                                        else{
                                            $missed_report = $total_days - $pcount;
                                        }
                                    }
                                    else{
                                        $missed_report = 0;
                                    }

                                    if($last_reports[0]->reporting_date){
                                        $last_date = date('Y-m-d');
                                        $date1 = date_create($last_reports[0]->reporting_date);
                                        $date2 = date_create($last_date);
                                        $diff = date_diff($date2,$date1);
                                        $total_days = $diff->d;
                                        $rdate = $last_reports[0]->reporting_date;
                                        $rdate = date_create($rdate);
                                        $rdate = date_format($rdate, 'M d, Y');
                                        $last_total = 0;
                                        $student_last_report = $last_reports[0];
                                        foreach($subjects as $subject){
                                            $sub = $subject->slug;
                                            $last_total += (float)$student_last_report->$sub;
                                        }
                                        //var_dump($last_total);
                                    }
                                    else{
                                        $rdate = date('M d, Y');
                                        $last_total = 0;
                                    }
                                    $curr_date = new DateTime(date('Y-m-d'));
                                    $last_date = new DateTime(date('Y-m-t'));
                                    $last_date->modify('+3 day');
                                    $rinterval = $curr_date->diff($last_date);
                                    $new_interval = strtotime($rinterval->d);
                                    
                                    // if(date('Y-m-d') < date("Y-m-01")){
                                    // echo date('t F Y', strtotime(date('Y-m-t', strtotime('last month')). ' +3 days'));
                                    // }else{
                                    //     echo $mydate = date('d F Y', strtotime(date('Y-m-t'). ' +3 days'));
                                    // }

                                    ?>
                                        <div class="alternate-inner-box">
                                            <div class="box-title-wrapper d-flex align-items-center justify-content-start">
                                                <div class="ellipse d-flex align-items-center justify-content-center me-2">
                                                    <i class="icon feather icon-calendar"></i>
                                                </div>
                                                <h5 class="mb-0"><?php echo __('Reports Due on','ngondro_gar');?></h5>
                                            </div>
                                            <div class="deadline">
                                                <h2>
                                                    <?php 
                                                     if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                                        // echo date('Y年 n月 t日');
                                                        if(date('Y-m-d') <= date("Y-m-03")){
                                                            echo date('Y年 n月 d日', strtotime(date('Y-m-t', strtotime('last month')). ' +3 days'));
                                                            }else{
                                                                echo date('Y年 n月 d日', strtotime(date('Y-m-t'). ' +3 days'));
                                                                
                                                            }
                                                    }
                                                    elseif($my_current_lang == 'pt-pt'){
                                                        // echo date('t \d\e F, Y');
                                                        if(date('Y-m-d') <= date("Y-m-03")){
                                                            echo date('d \d\e F, Y', strtotime(date('Y-m-t', strtotime('last month')). ' +3 days'));
                                                            }else{
                                                                echo date('d \d\e F, Y', strtotime(date('Y-m-t'). ' +3 days'));
                                                                
                                                            }
                                                    }
                                                    else {
                                                        // echo date('t F Y');
                                                        if(date('Y-m-d') <= date("Y-m-03")){
                                                            echo date('d F Y', strtotime(date('Y-m-t', strtotime('last month')). ' +3 days'));
                                                            }else{
                                                                echo date('d F Y', strtotime(date('Y-m-t'). ' +3 days'));
                                                                
                                                            }
                                                    }?>
                                                </h2>
                                            </div>
                                            <div class="days-count">
                                                <p><?=$rinterval->d?> <?php echo __('Days Remaining','ngondro_gar');?></p>
                                                <a class="btn btn-lg bg-white text-pink" href="<?php echo home_url('/hours-reporting')?>">
                                                <?php echo __('Report hours','ngondro_gar');?> &nbsp; &nbsp;&nbsp;<i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="visit-course-box ">
                                        <div class="row align-items-center">
                                        <!-- Instructor Details -->   
                                            <div class="col-md-12">
                                                <?php 
                                                $ins_id = (int) get_the_author_meta( 'instructor', get_current_user_id() );
                                                $instructor_user = get_user_by( 'id', $ins_id );
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
                                                    $instructor = get_field('instructor',$ins_post_id);
                                                    if($ins_post_id !==NULL){
                                                    $instructor_info = get_userdata($instructor);
                                                    $instructor_email = $instructor_info->user_email;
                                                    $ins_name = get_the_title($ins_post_id);
                                                    } else {
                                                        $instructor_email = $instructor_user->user_email;
                                                        $ins_name = $instructor_user->display_name;
                                                    }
                                                ?>
                                                    <a data-bs-toggle="modal" href="#contactModalToggle" role="button" class="d-flex align-items-center justify-content-start">
                                                        <div class="ellipse d-flex align-items-center justify-content-center me-2">
                                                        <i class="icon feather icon-user"></i>
                                                        </div>
                                                    <?php echo __('Contact Your Instructor','ngondro_gar');?> <i class="icon feather icon-chevron-right ms-2"></i></a>
                                                <div class="modal fade" id="contactModalToggle" aria-hidden="true" aria-labelledby="contactModalToggleLabel" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalToggleLabel"><?php echo __('Compose Your Message','ngondro_gar');?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="post" id="instructor_msg_submit" action="<?php echo home_url('/');?>request-for-help/">
                                                            <input type="hidden" name="email_to" id="email_to" value="<?php echo $instructor_email;?>" class="form-control">
                                                            <input type="hidden" name="instructor_id" id="instructor_id" value="<?php echo $ins_id;?>" class="form-control">
                                                            <input type="hidden" name="student_email" id="student_email" value="<?php echo $user_data->data->user_email;?>" class="form-control">
                                                            <input type="hidden" name="student_name" id="student_name" value="<?php echo $user_data->data->display_name;?>" class="form-control">
                                                            <div class="modal-body">
                                                                <table cellpadding="10px">
                                                                    <tr>
                                                                        <td><?php echo __('To:','ngondro_gar');?></td>
                                                                        <td class="send-to">
                                                                            <img src="<?=$ins_image?>" alt="instructor image" class="rounded-circle me-5" />
                                                                            <a href="javascript:void(0)">
                                                                                <?=$ins_name?>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?php echo __('Email:','ngondro_gar');?></td>
                                                                        <td class="email"><?php echo $instructor_email;?>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?php echo __('Subject:','ngondro_gar');?></td>
                                                                        <td><input type="text" name="subject" id="subject" maxlength="50" class="form-control"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>
                                                                            <textarea name="message" id="message" cols="30" maxlength="500" rows="4"
                                                                                    class="form-control"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>
                                                                            <div class="submit"><button class="btn btn-default instructor_email_submit"><?php echo __('Send','ngondro_gar');?></button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- Compose Message Model -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div><!--endcol-xl-5-->
                        </div>
                        <div class="row d-none">
                            <div class="col-xl-7 mb-6">
                                <div class="visit-course-box ">
                                    <div class="box-title-wrapper d-flex align-items-center justify-content-start">
                                        <div class="ellipse d-flex align-items-center justify-content-center me-2">
                                            <i class="icon feather icon-user"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0"><?php echo __('Your Instructor','ngondro_gar');?></h6>
                                    </div>
                                    <div class="row align-items-center">
                                     <!-- Instructor Details -->   
										<div class="col-md-8 d-flex align-items-center">
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
												$instructor = get_field('instructor',$ins_post_id);
                                                $instructor_info = get_userdata($instructor);
                                                $instructor_email = $instructor_info->user_email;
												$ins_name = get_the_title($ins_post_id);
											?>
												<div class="instructor-img">
													<img src="<?=$ins_image?>" alt="instructor image" class="w-100 h-100" />
												</div>
												<div class="instructor-name align-items-center">
													<a class="ajax-popup" href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=instructor_popup_ajax&post_id=<?=$ins_post_id?>">
														<?=$ins_name?>
													</a>
												</div>
										</div>
                                    <!-- Compose Message Model -->
                                        <div class="col-md-4">
                                            <a data-bs-toggle="modal" href="#contactModalToggle" role="button"><?php echo __('Contact','ngondro_gar');?> <i class="fa fa-angle-right"></i></a>
                                            <div class="modal fade" id="contactModalToggle" aria-hidden="true" aria-labelledby="contactModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalToggleLabel"><?php echo __('Compose Your Message','ngondro_gar');?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="post" id="instructor_msg_submit" action="<?php echo home_url('/');?>request-for-help/">
                                                        <input type="hidden" name="email_to" id="email_to" value="<?php echo $instructor_email;?>" class="form-control">
                                                        <input type="hidden" name="instructor_id" id="instructor_id" value="<?php echo $ins_id;?>" class="form-control">
                                                        <input type="hidden" name="student_email" id="student_email" value="<?php echo $user_data->data->user_email;?>" class="form-control">
                                                        <input type="hidden" name="student_name" id="student_name" value="<?php echo $user_data->data->display_name;?>" class="form-control">
                                                        <div class="modal-body">
                                                            <table cellpadding="10px">
                                                                <tr>
                                                                    <td><?php echo __('To:','ngondro_gar');?></td>
                                                                    <td class="send-to">
                                                                        <img src="<?=$ins_image?>" alt="instructor image" class="rounded-circle me-5" />
                                                                        <a href="javascript:void(0)">
                                                                            <?=$ins_name?>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo __('Email:','ngondro_gar');?></td>
                                                                    <td class="email"><?php echo $instructor_email;?>
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo __('Subject:','ngondro_gar');?></td>
                                                                    <td><input type="text" name="subject" id="subject" class="form-control"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>
                                                                        <textarea name="message" id="message" cols="30" rows="4"
                                                                                  class="form-control"></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>
                                                                        <div class="submit"><button class="btn btn-default instructor_email_submit"><?php echo __('Send','ngondro_gar');?></button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="visit-course-box d-flex justify-content-center">-->
<!--                                    <a href="--><?php //echo home_url('/');?><!--resources">Visit LNN Resources <i class="icon feather icon-chevron-right"></i></a>-->
<!--                                </div>-->
                            </div>
                            <div class="col-xl-5">
                                <div class="row">
                                    <div class="col-xl-6">
                                    <div class="reporting-box">
                                        <h4><?=$rdate?></h4>
                                        <p><?php echo __('Last reported date','ngondro_gar');?></p>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="reporting-box">
                                        <?php 
                                        /*Display Last reported hours*/
                                        $last_reported_hour = get_the_author_meta( 'last_reported_hour', get_current_user_id() );
                                        if($last_reported_hour==Null) {$last_reported_hour = $last_total;}
                                        ?>
                                        <h4 class="">+ <?=abs($last_reported_hour)?> <?php echo __('hours','ngondro_gar');?></h4>
                                        <p><?php echo __('Last reported hours','ngondro_gar');?></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--Announement Section-->
                            <?php get_template_part( 'template-parts/content', 'announcements' );?>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="sidebar-inner-box" id="event_calander_parent">
                                    <div class="box-title-wrapper d-flex align-items-center justify-content-start">
                                            <div class="ellipse d-flex align-items-center justify-content-center me-2">
                                                <i class="icon feather icon-calendar"></i>
                                            </div>
                                        <h2><?php echo __('Upcoming Events','ngondro_gar');?></h2>
                                    </div>
                                 <!--Events Section-->
                                    <?php 
                                    /* Display all events */
                                    echo do_shortcode( '[tribe_events view="list"]' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php get_footer();?>
            </div>
        </div>

        <script>

    //  jQuery(document).ready(function() 
    //  {
         
    // 	function site_init(listsel,monthsel, daysel)
    //     {
    //         let listele = listsel;
    //         let monthele = monthsel;
    //         let dayele = daysel;
    //         let shortcode_val = ""; 
    //         let listele_href = listele.getAttribute('href');
    //          if(listele_href != undefined){ shortcode_val = listele_href.split('=')[1]; }
            
    //          let list_url = `${window.location.origin}/eventos/lista/?shortcode=${shortcode_val}`;
    //          let month_url =`${window.location.origin}/eventos/ms/?shortcode=${shortcode_val}`;
    //          let day_url = `${window.location.origin}/eventos/hoje/?shortcode=${shortcode_val}`;
    //          listele.setAttribute('href',list_url);
    //          monthele.setAttribute('href',month_url);
    //          dayele.setAttribute('href',day_url);
    //     }
        
         
    //      let listSelector = document.querySelector('#event_calander_parent');
         
    //      listSelector.addEventListener('click', function (event) {
    //         	let cal = listSelector.querySelector('.tribe-events-c-events-bar__views .tribe-events-c-view-selector #tribe-events-view-selector-content .tribe-events-c-view-selector__list li');
            
    //          let curr_sel = event.target.closest('.tribe-common .tribe-common-l-container header .tribe-events-c-view-selector');
    //          if(curr_sel==null) return;
             
    //         let listele = listSelector.querySelector('#tribe-events-view-selector-content .tribe-events-c-view-selector__list-item--list a');
    //         let monthele = listSelector.querySelector('#tribe-events-view-selector-content .tribe-events-c-view-selector__list-item--month a');
    //         let dayele = listSelector.querySelector('#tribe-events-view-selector-content .tribe-events-c-view-selector__list-item--day a');
    //         site_init(listele,monthele,dayele);
             

    //      }); 
		
    
	//  }); 


   </script>

   