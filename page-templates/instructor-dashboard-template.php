<?php 
/**
 * Template Name: Instructor Dashboard
 * @desc Dashboard of Instructor
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {subjects} [Array] Array of curriculum
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {get_users()} [object] Return users details
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 * @function {wp_safe_redirect} Performs a safe (local) redirect
 */
session_start();  

get_header('loggedin');

?>
<style>
.nav-link {
    padding: 0.5rem 0.5rem !important;
}

#your_students_filter {
    display: none;
}

.search-box {
    display: flex;
    margin-left: auto;
    justify-content: end;
    gap: 5px;
    flex-wrap: wrap;

}

.all-students input {
    visibility: visible;
    margin-left: 0 !important;
}

.all-students {
    display: flex;
    align-items: center;
    flex-direction: row-reverse;
    margin: 0 25px;
}

.all-students>span {
    margin: 0px 25px;
}
</style>
<?php if(is_user_logged_in()){
$current_user_id = get_current_user_id();	
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

<div id="layoutSidenav_content">
    <section class="landing-page-wrapper mt-10 logged-in-user instructor-dashboard">
        <div class="container px-sm-1 px-10">
            <!--Students List Begins-->
            <div class="row">
                <div class="col-md-12 offset-md-0">
                    <div class="sidebar-inner-box">
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center me-2">
                                    <i class="icon feather icon-users fw-bold fs-20"></i>
                                </div>
                                <h6 class="fw-bold mb-0 fs-23"><?php echo __('Your Students','ngondro_gar');?></h6>
                                <!-- <div class="show-hide-columns"> 
                                    <label>Show/Hide columns: </label>
                                    <a class="toggle-vis" data-column="1">Name</a> - 
                                    <a class="toggle-vis" data-column="2">Position</a> - 
                                    <a class="toggle-vis" data-column="3">Office</a> - 
                                    <a class="toggle-vis" data-column="4">Age</a> - 
                                    <a class="toggle-vis" data-column="5">Start date</a> - 
                                    <a class="toggle-vis" data-column="6">Salary</a>
                                    </div> -->
                            </div>
                            <div class="box-title-wrapper">
                                <?php
                                        $report_text = 'reports/all_student_report_'.$current_user_id.'.csv';
                                    ?>
                                <a href="<?php echo get_the_permalink(520);?>" class="d-flex align-items-center">
                                    <?php echo __('See All Students','ngondro_gar');?> <i
                                        class="icon feather icon-chevron-right fs-20 ps-1"></i></a>
                            </div>
                        </div>
                        <div class="students-list">
                            <div class="row">

                                <div class="table-responsive ">
                                    <table class="table table-hover" id="your_students">
                                        <div class="search-box">
                                            <?php if(isset($_POST['submit'])){
                                                $search = $_POST['search_student'];
                                                $selected = '';

                                                if(isset($_POST['all_ndg_students']) && $_POST['all_ndg_students'] == 1){
                                                    $selected = 'checked';
                                                }
                                            }else{
                                                $search = '';
                                            } ?>
                                            <form method="post">
                                                <div class="all-students">
                                                    <!-- <label for="all-ndg-students">All NDG Students</label> -->
                                                    <span>All NDG Students</span>
                                                    <input type="checkbox" name="all_ndg_students" id="all_ndg_students"
                                                        value="1" <?php echo $selected; ?>>
                                                </div>
                                                <input type="text" id="search-student-input" name="search_student"
                                                    value="<?=$search; ?>" autocomplete="off" required>
                                                <input type="submit" value="submit" name="submit">
                                            </form>
                                        </div>
                                        <div class="dropdown mt-2 mb-2 d-flex justify-content-end">
                                            <a id="download_instructor_student" data-uid="<?=get_current_user_id(); ?>" style="color : #bd5d72; cursor: pointer;">
                                                Export
                                        </a>
                                            
                                        </div>
                                        <thead>
                                            <th><?php echo __('No.','ngondro_gar');?></th>
                                            <th style="text-align: left;"><?php echo __('Name','ngondro_gar');?></th>
                                            <th><?php echo __('Commited Hrs','ngondro_gar');?></th>
                                            <th><?php echo __('Practice','ngondro_gar');?></th>
                                            <th><?php echo __('Instructor','ngondro_gar');?></th>
                                            <th><?php echo __('Section','ngondro_gar');?></th>
                                            <th style="text-align: right; padding-right: 10px;">
                                                <?php echo __('Completed Hrs','ngondro_gar');?></th>
                                            <th><?php echo __('Missed report','ngondro_gar');?></th>
                                            <th><?php echo __('Graduate','ngondro_gar');?></th>
                                            <th><?php echo __('Ept','ngondro_gar');?></th>
                                            <th><?php echo __('Action','ngondro_gar');?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                        /*Create user report csv file*/
                                        $cfile = fopen($report_text, 'w');
                                        $heading = array("Name", "Commited Hrs", "Practice", "Completed Hrs", "Missed report", "Graduate", "Ept");
                                        fputcsv($cfile,$heading);
                                        global $wpdb;
                                        // $students = get_users(
                                        //     array(
                                        //         'role' => 'student',
                                        //         'number' => -1,
                                        //         'meta_query' => array(
                                        //             array(
                                        //                 'key' => 'ng_user_approve_status',
                                        //                 'value' => 'approved',
                                        //                 'compare' => '='
                                        //             ),
                                        //             array(
                                        //                 'key' => 'instructor',
                                        //                 'value' => get_current_user_id(),
                                        //                 'compare' => '='
                                        //             )
                                        //         )
                                        //     )
                                        // );


                                        $number = 50;

                                        $paged = (get_query_var('page')) ? get_query_var('page') : 1;

                                        $offset = ($paged - 1) * $number;
                                        $args = array(
                                            'role' => 'student',
                                            'number' => -1,
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'ng_user_approve_status',
                                                    'value' => 'approved',
                                                    'compare' => '='
                                                ),
                                                array(
                                                    'key' => 'instructor',
                                                    'value' => get_current_user_id(),
                                                    'compare' => '='
                                                )
                                            )
                                        );

                                        if(isset($_POST['submit'])){

                                            $search = $_POST['search_student'];

                                            $args = array(
                                                'role' => 'student',
                                                'number' => -1,
                                                'search' => "*{$search}*",
                                                'search_columns' => array(
                                                'user_login',
                                                'user_nicename',
                                                'user_email',
                                                'display_name',
                                                ),
                                                'meta_query' => array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'key' => 'ng_user_approve_status',
                                                        'value' => 'approved',
                                                        'compare' => '='
                                                    ),
                                                    array(
                                                        'key' => 'instructor',
                                                        'value' => get_current_user_id(),
                                                        'compare' => '='
                                                    ),
                                                    
                                                   
                                                )
                                            );

                                            if(isset($_POST['all_ndg_students']) && $_POST['all_ndg_students'] == 1){

                                                $args = array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'search' => "*{$search}*",
                                                    'search_columns' => array(
                                                    'user_login',
                                                    'user_nicename',
                                                    'user_email',
                                                    'display_name',
                                                    ),
                                                    'meta_query' => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        )   
                                                    )
                                                );


                                            //     echo "<pre>";
                                            // var_dump($_POST);
                                            // echo "</pre>";
                                            }
                                           
    
                                        }
                                            

                                            $total_users_query = new WP_User_Query($args);
                                            $total_users = $total_users_query->total_users;

                                            $args['number'] = $number;
                                            $args['offset'] = $offset;

                                            $wp_user_query = new WP_User_Query($args);

                                            $total_query = $wp_user_query->total_users;
                                            $total_pages = intval($total_users / $number) + 1;

                                            $students = $wp_user_query->get_results();

                                            $students1 = get_users(
                                                array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'field' => 'ID',
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        )
                                                    )
                                                )
                                            );

                                            $subjects_total1 = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects`");
                                            $total_required1 = (int)$subjects_total->total_hour;

                                            $sum_subject1 = "SUM(";
                                            for($i=1; $i<=21; $i++){
                                                if($i<21)
                                                $sum_subject1.= 'sub_'.$i.' + ';
                                                else
                                                $sum_subject1.= 'sub_'.$i;
                                            }
                                            $sum_subject1 .= ") As hour_total";

                                            
                                            $_SESSION['students'] = $students1;
                                            $_SESSION['subjects_total'] = $subjects_total1;
                                            $_SESSION['total_required'] = $total_required1;
                                            $_SESSION['sum_subject'] = $sum_subject1;


                                            // var_dump($_SESSION['students']);
                                        $reported_students = [];
                                        $ontrack = 0;
                                        $not_reported = 0;
                                        $trailing = 0;
                                        $missed_report = 0;
                                        $subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects`");
                                        $total_required = (int)$subjects_total->total_hour;
                                        $total_students = count($students);
                                        $all_hrs_total = 0;

                                        if($students) :
                                           /*tracking report*/
                                            $sum_subject = "SUM(";
                                            for($i=1; $i<=22; $i++){
                                                if($i<22)
                                                $sum_subject.= 'sub_'.$i.' + ';
                                                else
                                                $sum_subject.= 'sub_'.$i;
                                            }
                                            $sum_subject .= ") As hour_total";
                                            
                                            foreach($students as $student):
                                                $missed_report = 0;
                                                if(!empty($student->first_name)){
                                                    $title = $student->first_name.' '.$student->last_name;
                                                }
                                                else {
                                                    $title = $student->display_name;
                                                }
                                                $email = $student->user_email;
                                                $sid = $student->ID;
                                                $reported_students[] = $sid;
                                                $track = get_the_author_meta( 'track', $sid );
                                                $curriculum = get_the_author_meta( 'curriculum', $sid );

                                                
                                                $instructor = get_user_by('id',$student->instructor);
                                                $instructor_name = $instructor->first_name .' '.$instructor->last_name;
                                                // echo "<pre>";
                                                // print_r($instructor->first_name .' '.$instructor->last_name);
                                                // echo "</pre>";

                                                $uid = $sid;
                                                $first_day_of_month = date('Y-m-01');
                                                $last_day_of_month = date('Y-m-t');
                                                $user_course_id = get_the_author_meta( 'curriculum', $sid );
												$cid = $user_course_id;

												$subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = '$curriculum'");
												$subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = '$curriculum'");

												$total_required = (int) $subjects_total->total_hour;
                                                $practice = $wpdb->get_row("Select * from ngondro_courses where id =".$user_course_id);

                                                $graduate = get_the_author_meta( 'graduate', $uid );
                                                $exempt = get_the_author_meta( 'exempt', $uid );

												/*tracking report*/
                                                $total_students = count($students);

                                                $reg_date = date("Y-m-d", strtotime($student->data->user_registered));
                                                $current_date = date('Y-m-d');

                                                $begin = new DateTime( $current_date );
                                                $end   = new DateTime( $reg_date );
                                                $months = [];
                                                $total_months = 0;
                                                //$begin = $begin->modify('-1 months');
                                                for($i = $begin; $i >= $end; $i->modify('-1 months')){
                                                    $months[] = $i->format("M Y");
                                                    $total_months++;
                                                }

                                                if($cid==""){$cid = 1;}
                                                $first_day_of_month = date('Y-m-01');
                                                $last_day_of_month = date('Y-m-t');

                                                $last_report  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
                                                if(count($last_report)>0){
                                                    $ontrack++;
                                                }
                                                else{
                                                    $last_12_months  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `reporting_date` > now() - INTERVAL 12 month");
                                                    if(count($last_12_months)>0){
                                                        $trailing++;
                                                    }
                                                    else{
                                                        $missed_report++;
                                                    }
                                                }
                                                $all_reported_entries = $wpdb->get_results("SELECT user_id, date_format(reporting_date, '%b %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " group by date_format(reporting_date, '%m-%Y') order by reporting_date desc");
                                                $total_reporting_hour  = $wpdb->get_row("SELECT $sum_subject from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' ");
                                                $all_hrs_total += (int)$total_reporting_hour->hour_total;
                                                $individual_total_user_reporting = (int)$total_reporting_hour->hour_total;

                                                $last_report_section = $wpdb->get_row("SELECT * from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' order by id DESC");
                                                $sections = array();
                                                foreach($subjects as $subs){
                                                     $sub_slug = $subs->slug;
                                                     $sub_hours = (int)$last_report_section->$sub_slug;
                                                     if($sub_hours>0){
                                                        $sections[] = $subs->title;
                                                     }
                                                }
                                                $sections_string  = implode(', ', $sections);

                                                $missed_report = get_user_meta($uid, 'missed_last_report')[0];
												 /*end*/
                                                ?>
                                            <tr>
                                                <td></td>
                                                <td style="text-align: left;">
                                                    <a class="student-link1" data-effect="mfp-move-from-right"
                                                        data-title="<?=$title?>" data-email="<?=$email?>"
                                                        href="<?=site_url('/student?sid='.$sid)?>">
                                                        <?=$title?>
                                                    </a>
                                                </td>
                                                <td><?=$track?></td>
                                                <td><?=$practice->short_name?></td>
                                                <td><?=$instructor_name?></td>
                                                <td><?=$sections_string?></td>
                                                <td style="text-align: right;">
                                                    <?=$individual_total_user_reporting?>/<?=$total_required?></td>
                                                <td><?=$missed_report;?></td>
                                                <td><?=$graduate?></td>
                                                <td><?=$exempt?></td>
                                                <td>
                                                    <a class="student-link1" data-effect="mfp-move-from-right"
                                                        data-title="<?=$title?>" data-email="<?=$email?>"
                                                        href="<?=site_url('/student?sid='.$sid)?>">
                                                        <?php echo __('View','ngondro_gar');?>
                                                    </a>
                                                </td>
                                            </tr>
                                                

                                            <?php
                                            
                                                if($total_required > 0){
                                                    $cmp_hrs = $total_user_reporting.'/'.$total_required;
                                                }
                                                else {
                                                    $cmp_hrs = 0; 
                                                }
                                                $row_data = array($title, $track, $practice->short_name, $cmp_hrs, $missed_report, $graduate, $exempt);
                                                fputcsv($cfile,$row_data);
                                            endforeach; 

                                            if ($total_users >= $total_query) {
                                                echo '<div id="pagination" class="clearfix um-members-pagi">';
                                                    echo '<span class="pages">Pages:</span>';
                                                    $current_page = max(1, get_query_var('page'));
                                            
                                                    echo paginate_links(array(
                                                      'base'      => get_pagenum_link(1) . '%_%',
                                                      'format'    => 'page/%#%/',
                                                      'current'   => $current_page,
                                                      'total'     => $total_pages,
                                                      'prev_next' => true,
                                                      'show_all'  => true,
                                                      'type'      => 'plain',
                                                    ));
                                                
                                                echo '</div>';
                                            }
                                        fclose($cfile);
                                        $rids = implode(',', $reported_students);
                                        $all_reporting_users  = $wpdb->get_results("SELECT * from `user_reporting` where user_id in ($rids) group by `user_id`");
                                        $not_reported =  $total_students - count($all_reporting_users);

                                        if($total_required > 0){
                                            $per = ($total_user_reporting * 100)/$total_required;
                                        }
										$per = ($all_hrs_total * 100 )/$total_required;
										//$trailing = $total_students - $ontrack;
                                        endif;


                                        

                                        ?>
                                        <tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Student Summary section Begins-->
            <div class="row mt-10">
                <div class="col-md-12 offset-md-0">
                    <div class="d-flex align-items-center justify-content-between pb-5">
                        <div class="d-flex align-items-center justify-content-center me-2">
                            <i class="icon feather icon-users fw-bold fs-20 me-2"></i>
                            <h6 class="fw-bold mb-0 fs-23"><?php echo __('Student Summary','ngondro_gar');?></h6>
                            <div class="d-block d-lg-none hide-show-btn"><a href="#">(Expand)</a></div>
                        </div>
                        <div class="box-title-wrapper mb-0">
                            <a class="d-flex align-items-center"
                                href="<?php echo get_the_permalink(259);?>"><?php echo __('See More','ngondro_gar');?>
                                <i class="icon feather icon-chevron-right fs-20 ps-1"></i></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Student Graph Summary Report  -->
            <div class="summary-section-wrapper">
                <div class="row">
                    <div class="col-md-6 offset-md-0">
                        <div class="sidebar-inner-box" style="height:500px;">
                            <div class="student-summary-filter-bar mb-2">
                                <!--<a href="#">Reported</a>
                                <a href="#">Missed</a>
                                <a href="#">Graduated</a>-->
                                <nav class="mb-10">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-reported-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-reported" type="button" role="tab"
                                            aria-controls="nav-reported" aria-selected="true">
                                            <?php echo __('Reported','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-missed-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-missed" type="button" role="tab"
                                            aria-controls="nav-missed" aria-selected="false">
                                            <?php echo __('Missed','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-graduated-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-graduated" type="button" role="tab"
                                            aria-controls="nav-graduated" aria-selected="false">
                                            <?php echo __('Graduated','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-exempt-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-exempt" type="button" role="tab"
                                            aria-controls="nav-exempt" aria-selected="false">
                                            <?php echo __('Exempt','ngondro_gar');?>
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content mt-4" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-reported" role="tabpanel"
                                        aria-labelledby="nav-reported-tab" tabindex="0">
                                        <div class="student-summary-bar-chart d-flex justify-content-around">
                                            <?php 
                                                //$sontrack = number_format( ($ontrack * 100 )/$total_students,0);
                                                //$strailing = number_format(($trailing * 100 )/$total_students,0);
                                                //$not_reported1 = number_format(($not_reported * 100 )/$total_students,0);
                                            ?>

                                            <div class="chart_section" style="height:300px;">
                                                <canvas id="summary_reported"></canvas>
                                                <div class="overall text-left" style="text-align:left;">
                                                    <p style="font-size:14px;" class="mtop-sm-n4"> <strong>
                                                            <?php echo __('Tracking:','ngondro_gar');?>
                                                        </strong><?=$ontrack?>
                                                        <?php echo __('students are on track while','ngondro_gar');?>
                                                        <?=$trailing?>
                                                        <?php echo __('students are behind in reporting hours.','ngondro_gar');?>
                                                    </p>
                                                </div>
                                            </div>

                                            <script>
                                            const bar_reported_labels = [
                                                'On Track',
                                                'Trailing'
                                            ];
                                            const bar_reported_data = {
                                                labels: bar_reported_labels,
                                                datasets: [{
                                                    label: "Reported Summary",
                                                    data: [<?=$ontrack?>, <?=$trailing?>],
                                                    backgroundColor: [
                                                        '#b13b55',
                                                        '#651a55e0',
                                                    ],
                                                    borderColor: [
                                                        '#BD5D72',
                                                        '#651A55',
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            };
                                            const bar_reported_config = {
                                                type: 'bar',
                                                data: bar_reported_data,
                                                options: {
                                                    maintainAspectRatio: false,
                                                    responsive: true,
                                                    layout: {
                                                        padding: 10
                                                    },
                                                    legend: {
                                                        display: false
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'Reported Summary'
                                                    },
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            //display:false
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position: 'bottom'
                                                        }
                                                    }
                                                },
                                            };
                                            const bar_summary_Chart = new Chart(
                                                document.getElementById('summary_reported'),
                                                bar_reported_config
                                            );

                                            var summary_chart_ele = document.getElementById('summary_reported');

                                            summary_chart_ele.onclick = function(e) {
                                                var slice = bar_summary_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'On Track':
                                                        window.open('student-tracking/?report=student');
                                                        break;
                                                    case 'Trailing':
                                                        window.open('student-tracking/?summary=trailing');
                                                        break;
                                                }
                                            }
                                            </script>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-missed" role="tabpanel"
                                        aria-labelledby="nav-missed-tab" tabindex="0">
                                        <div class="student-summary-bar-chart mt-4 d-flex justify-content-around">
                                            <div class="chart_section" style="height:400px;">
                                                <canvas id="summary_missed" height="300px"></canvas>
                                            </div>
                                            <script>
                                            const bar_missed_labels = [
                                                'Missed',
                                                'Not Reported',
                                            ];
                                            const bar_missed_data = {
                                                labels: bar_missed_labels,
                                                datasets: [{
                                                    label: 'Missed Report',
                                                    data: [<?=$missed_report?>, <?=$not_reported?>],
                                                    backgroundColor: [
                                                        '#cda86d',
                                                        '#b13b55',
                                                    ],
                                                    borderColor: [
                                                        '#E6C99A',
                                                        '#BD5D72',
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            };
                                            const bar_missed_config = {
                                                type: 'bar',
                                                data: bar_missed_data,
                                                options: {
                                                    maintainAspectRatio: false,
                                                    responsive: false,
                                                    layout: {
                                                        padding: 10
                                                    },
                                                    legend: {
                                                        display: false
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'Missed Report'
                                                    },
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position: 'bottom'
                                                        }
                                                    }
                                                },
                                            };

                                            const bar_missed_Chart = new Chart(
                                                document.getElementById('summary_missed'),
                                                bar_missed_config
                                            );

                                            var missed_chart_ele = document.getElementById('summary_missed');
                                            missed_chart_ele.onclick = function(e) {
                                                var slice = bar_missed_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Missed':
                                                        window.open('student-tracking/?mfilter=missed');
                                                        break;
                                                    case 'Not Reported':
                                                        window.open('student-tracking/?summary=not_reported');
                                                        break;
                                                }
                                            }
                                            </script>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-graduated" role="tabpanel"
                                        aria-labelledby="nav-graduated-tab" tabindex="0">
                                        <div class="student-summary-bar-chart d-flex justify-content-around mt-4">
                                            <?php $graduated = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                            array(
                                                                'key'     => "graduate",
                                                                'value'   => 'Yes',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            ),
                                                    ),
                                                ));
                                                $not_graduate = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                            array(
                                                                'key'     => "graduate",
                                                                'value'   => 'No',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            ),
                                                    ),
                                                ));
                                                $graduated = (int) count($graduated);
                                                
                                                if($total_students){
                                                    $total_graduate = (float)number_format( ($graduated * 100 )/$total_students,0);
                                                }
                                                else{
                                                    $total_graduate = 0;
                                                }
                                                
                                                //$not_graduate = 100 - $total_graduate;
                                                ?>

                                            <div class="chart_section" style="height:400px;">
                                                <canvas id="summary_graduated" height="300px"></canvas>
                                            </div>
                                            <script>
                                            const bar_graduated_labels = [
                                                'Yes',
                                                'No',
                                            ];
                                            const bar_graduated_data = {
                                                labels: bar_graduated_labels,
                                                datasets: [{
                                                    label: ['Graduated Summary'],
                                                    data: [<?=$graduated?>, <?=$not_graduate?>],
                                                    backgroundColor: [
                                                        '#b13b55',
                                                        '#651a55e0',
                                                    ],
                                                    borderColor: [
                                                        '#BD5D72',
                                                        '#651A55',
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            };
                                            const bar_graduated_config = {
                                                type: 'bar',
                                                data: bar_graduated_data,
                                                options: {
                                                    maintainAspectRatio: false,
                                                    responsive: false,
                                                    layout: {
                                                        padding: 10
                                                    },
                                                    legend: {
                                                        display: false
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'Graduated Summary'
                                                    },
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            //display:false
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position: 'bottom'
                                                        }
                                                    }
                                                },
                                            };

                                            const bar_graduated_Chart = new Chart(
                                                document.getElementById('summary_graduated'),
                                                bar_graduated_config
                                            );

                                            var graduate_chart_ele = document.getElementById('summary_graduated');

                                            graduate_chart_ele.onclick = function(e) {
                                                var slice = bar_graduated_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                console.log(label);
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Yes':
                                                        window.open('student-tracking/?filter=graduate&val=Yes');
                                                        break;
                                                    case 'No':
                                                        window.open('student-tracking/?filter=graduate&val=No');
                                                        break;
                                                }
                                            }
                                            </script>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-exempt" role="tabpanel"
                                        aria-labelledby="nav-exempt-tab" tabindex="0">
                                        <div class="student-summary-bar-chart d-flex justify-content-around mt-4">
                                            <?php $exempt = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                            array(
                                                                'key'     => "exempt",
                                                                'value'   => 'Yes',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            ),
                                                    ),
                                                ));
                                                $not_exempt = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                            array(
                                                                'key'     => "exempt",
                                                                'value'   => 'No',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            ),
                                                    ),
                                                ));
                                                $exempt = (int) count($exempt);
                                                $not_exempt = (int) count($not_exempt);
                                                ?>

                                            <div class="chart_section" style="height:400px;">
                                                <canvas id="summary_exempt" height="300px"></canvas>
                                            </div>
                                            <script>
                                            const bar_exempt_labels = [
                                                'Yes',
                                                'No',
                                            ];
                                            const bar_exempt_data = {
                                                labels: bar_exempt_labels,
                                                datasets: [{
                                                    label: ['Exempt'],
                                                    data: [<?=$exempt?>, <?=$not_exempt?>],
                                                    backgroundColor: [
                                                        '#b13b55',
                                                        '#651a55e0',
                                                    ],
                                                    borderColor: [
                                                        '#BD5D72',
                                                        '#651A55',
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            };
                                            const bar_exempt_config = {
                                                type: 'bar',
                                                data: bar_exempt_data,
                                                options: {
                                                    maintainAspectRatio: false,
                                                    responsive: false,
                                                    layout: {
                                                        padding: 10
                                                    },
                                                    legend: {
                                                        display: false
                                                    },
                                                    title: {
                                                        display: true,
                                                        text: 'Exempt'
                                                    },
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            //display:false
                                                        }
                                                    },
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position: 'bottom'
                                                        }
                                                    }
                                                },
                                            };

                                            const bar_exempt_Chart = new Chart(
                                                document.getElementById('summary_exempt'),
                                                bar_exempt_config
                                            );

                                            var exempt_chart_ele = document.getElementById('summary_exempt');

                                            exempt_chart_ele.onclick = function(e) {
                                                var slice = bar_exempt_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                console.log(label);
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Yes':
                                                        window.open('student-tracking/?filter=exempt&val=Yes');
                                                        break;
                                                    case 'No':
                                                        window.open('student-tracking/?filter=exempt&val=No');
                                                        break;
                                                }
                                            }
                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 mtop-sm-5">
                        <div class="sidebar-inner-box" style="height:500px;">
                            <div class="student-summary-filter-bar mb-2">
                                <!--<a href="#">Overall</a>
                                <a href="#">By Curriculum </a>
                                <a href="#">By Language</a>-->
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-overall-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-overall" type="button" role="tab"
                                            aria-controls="nav-overall" aria-selected="true">
                                            <?php echo __('Overall','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-curriculum-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-curriculum" type="button" role="tab"
                                            aria-controls="nav-curriculum" aria-selected="false">
                                            <?php echo __('Curriculum','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-language-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-language" type="button" role="tab"
                                            aria-controls="nav-language" aria-selected="false">
                                            <?php echo __('Language','ngondro_gar');?>
                                        </button>
                                    </div>

                                    <div class="tab-content mt-4" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-overall" role="tabpanel"
                                            aria-labelledby="nav-overall-tab" tabindex="0">
                                            <div class="student-summary-doughnut-chart text-center">
                                                <div class="chart_section" style="height:300px;width:auto;">
                                                    <canvas id="overall_chart"></canvas>
                                                </div>
                                                <div class="overall text-left" style="text-align:left;">
                                                    <p> <strong> <?php echo __('Overall:','ngondro_gar');?> </strong>
                                                        <?php echo __('Out of','ngondro_gar');?> <?=count($students)?>
                                                        <?php echo __('students,','ngondro_gar');?> <?=$ontrack?>
                                                        <?php echo __('have reported hours; they accumulated','ngondro_gar');?>
                                                        <?=number_format($all_hrs_total)?>
                                                        <?php echo __('hours for practice.','ngondro_gar');?></p>
                                                </div>
                                            </div>
                                            <script>
                                            const overall_data = {
                                                labels: [
                                                    'Total Students',
                                                    'Reported',
                                                ],
                                                datasets: [{
                                                    //label: 'Languages',
                                                    data: [<?=$total_students?>, <?=$ontrack?>],
                                                    backgroundColor: [
                                                        '#BD5D72',
                                                        '#CFB58B',
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            };
                                            const overall_config = {
                                                type: 'pie',
                                                data: overall_data,
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position: 'bottom'
                                                        }
                                                    }
                                                }
                                            };
                                            const overall_myChart = new Chart(
                                                document.getElementById('overall_chart'),
                                                overall_config
                                            );
                                            var overall_chart_ele = document.getElementById('overall_chart');

                                            overall_chart_ele.onclick = function(e) {
                                                var slice = overall_myChart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Total Students':
                                                        window.open('student-tracking/');
                                                        break;
                                                    case 'Reported':
                                                        window.open('student-tracking/?report=student');
                                                        break;
                                                }
                                            }
                                            </script>
                                        </div>
                                        <div class="tab-pane fade" id="nav-curriculum" role="tabpanel"
                                            aria-labelledby="nav-curriculum-tab" tabindex="0">
                                            <div class="student-summary-doughnut-chart text-center mt-4">
                                                <?php
                                                $all_students = get_users(
                                                    array(
                                                        'role' => 'student',
                                                        'number' => -1,
                                                        'meta_query' => array(
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            )
                                                        )
                                                    )
                                                );
                                                
        
                                                $lnn = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "curriculum",
                                                            'value'   => '2',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                       
                                                    ),
                                                ));
        
                                                $cnn = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "curriculum",
                                                            'value'   => '3',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                       
                                                    ),
                                                ));
        
                                                $kmn = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "curriculum",
                                                            'value'   => '4',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                       
                                                    ),
                                                ));
        
                                                $alt = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "curriculum",
                                                            'value'   => '1',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                       
                                                    ),
                                                ));
        
                                                $student_count = count($all_students);
                                                $lnn_count = count($lnn);
                                                $kmn_count = count($kmn);
                                                $cnn_count = count($cnn);
                                                $alt_count = count($alt);
        
                                                //$lnn_per = ($lnn_count*100)/$student_count;
                                                //$cnn_per = ($cnn_count*100)/$student_count;
                                                //$kmn_per = ($kmn_count*100)/$student_count;
                                                //$alt_per = ($alt_count*100)/$student_count;
                                            ?>
                                                <div class="chart_section" style="height:300px;">
                                                    <canvas id="curriculum_chart"></canvas>
                                                </div>
                                            </div>
                                            <script>
                                            const curr_data = {
                                                labels: [
                                                    'LNN',
                                                    'CNN',
                                                    'KMN',
                                                    'ALT'
                                                ],
                                                datasets: [{
                                                    //label: 'Curriculum',
                                                    data: [<?=$lnn_count?>, <?=$cnn_count?>,
                                                        <?=$kmn_count?>, <?=$alt_count?>
                                                    ],
                                                    backgroundColor: [
                                                        '#BD5D72',
                                                        '#651A55',
                                                        '#e1b672',
                                                        '#2271b1'
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            };
                                            const curr_config = {
                                                type: 'pie',
                                                data: curr_data,
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position: 'bottom'
                                                        }
                                                    }
                                                }
                                            };
                                            const curr_myChart = new Chart(
                                                document.getElementById('curriculum_chart'),
                                                curr_config
                                            );

                                            var curr_chart = document.getElementById('curriculum_chart');

                                            curr_chart.onclick = function(e) {
                                                var slice = curr_myChart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'LNN':
                                                        window.open('student-tracking/?filter=curriculum&val=2');
                                                        break;
                                                    case 'CNN':
                                                        window.open('student-tracking/?filter=curriculum&val=3');
                                                        break;
                                                    case 'KMN':
                                                        window.open('student-tracking/?filter=curriculum&val=4');
                                                        break;
                                                    case 'ALT':
                                                        window.open('student-tracking/?filter=curriculum&val=1');
                                                        break;
                                                }
                                            }
                                            </script>
                                        </div>

                                        <div class="tab-pane fade" id="nav-language" role="tabpanel"
                                            aria-labelledby="nav-language-tab" tabindex="0">
                                            <div class="student-summary-doughnut-chart text-center mt-4">
                                                <?php    
                                                $all_students = get_users(
                                                    array(
                                                        'role' => 'student',
                                                        'number' => -1,
                                                        'meta_query' => array(
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            )
                                                        )
                                                    )
                                                );

                                                $eng = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "language",
                                                            'value'   => 'en',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                    
                                                    ),
                                                ));

                                                $hant = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "language",
                                                            'value'   => 'zh-hant',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                    
                                                    ),
                                                ));

                                                $hans = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "language",
                                                            'value'   => 'zh-hans',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                    
                                                    ),
                                                ));

                                                $ptbr = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "language",
                                                            'value'   => 'pt-br',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                    
                                                    ),
                                                ));
                                                $es = get_users(array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query'  => array(
                                                        'relation' => 'AND',
                                                        array(
                                                            'key'     => "language",
                                                            'value'   => 'es',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                    
                                                    ),
                                                ));

                                                $student_count = count($all_students);
                                                $eng_count = count($eng);
                                                $hant_count = count($hant);
                                                $hans_count = count($hans);
                                                $ptbr_count = count($ptbr);
                                                $es_count = count($es);

                                                //$eng_per = ($eng_count*100)/$student_count;
                                                //$hant_per = ($hant_count*100)/$student_count;
                                                //$hans_per = ($hans_count*100)/$student_count;
                                                //$ptbr_per = ($ptbr_count*100)/$student_count;
                                            ?>
                                                <div class="chart_section" style="height:300px;">
                                                    <canvas id="language_chart"></canvas>
                                                </div>
                                                <script>
                                                const lang_data = {
                                                    labels: [
                                                        'EN',
                                                        '繁體',
                                                        '简体',
                                                        'PT',
                                                        'ES'
                                                    ],
                                                    datasets: [{
                                                        //label: 'Languages',
                                                        data: [<?=$eng_count?>, <?=$hant_count?>,
                                                            <?=$hans_count?>, <?=$ptbr_count?>,
                                                            <?=$es_count?>
                                                        ],
                                                        backgroundColor: [
                                                            '#BD5D72',
                                                            '#651A55',
                                                            '#e1b672',
                                                            '#2271b1',
                                                            '#EA6618'
                                                        ],
                                                        hoverOffset: 4
                                                    }]
                                                };
                                                const lang_config = {
                                                    type: 'pie',
                                                    data: lang_data,
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        plugins: {
                                                            legend: {
                                                                display: true,
                                                                position: 'bottom'
                                                            }
                                                        }
                                                    }
                                                };
                                                const lang_myChart = new Chart(
                                                    document.getElementById('language_chart'),
                                                    lang_config
                                                );

                                                var lang_chart = document.getElementById('language_chart');

                                                lang_chart.onclick = function(e) {
                                                    var slice = lang_myChart.getElementAtEvent(e);
                                                    if (!slice.length) return; // return if not clicked on slice
                                                    var label = slice[0]._model.label;
                                                    switch (label) {
                                                        // add case for each label/slice
                                                        case 'EN':
                                                            window.open('student-tracking/?filter=language&val=en');
                                                            break;
                                                        case '繁體':
                                                            window.open(
                                                                'student-tracking/?filter=language&val=zh-hant');
                                                            break;
                                                        case '简体':
                                                            window.open(
                                                                'student-tracking/?filter=language&val=zh-hans');
                                                            break;
                                                        case 'PT':
                                                            window.open(
                                                                'student-tracking/?filter=language&val=pt-br');
                                                            break;
                                                        case 'ES':
                                                            window.open(
                                                                'student-tracking/?filter=language&val=es');
                                                            break;
                                                    }
                                                }
                                                </script>
                                            </div>
                                        </div>

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--Announement Section-->
                <?php get_template_part( 'template-parts/content', 'announcements' );?>
            </div>
            <div class="event-row mt-5">
                <div class="col-md-12">
                    <div class="sidebar-inner-box">
                        <div class="box-title-wrapper d-flex align-items-center justify-content-start">
                            <div class="ellipse d-flex align-items-center justify-content-center me-2">
                                <i class="icon feather icon-calendar"></i>
                            </div>
                            <h2> <?php echo __('Upcoming Events','ngondro_gar');?></h2>
                        </div>
                        <!--Event Section-->
                        <?php
                            //  echo do_shortcode( '[tribe_events view="month"]' ); 
                            echo do_shortcode( '[tribe_events view="list"]' ); ?>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <?php get_footer();?>
</div>

<?php } else { ?>
<section class="landing-page-wrapper">
    <div class="container-fluid landing-page-full-height d-flex flex-column">
        <div class="row flex-grow-1">
            <div class="col-md-5 bg-yellow">
                <div class="left-intro-box pt-8 px-12 pb-16 text-center">
                    <img src="<?php echo get_the_post_thumbnail_url();?>" alt="Ngondro Gar" />
                    <?php the_content();?>
                </div>
            </div>
            <div class="col-md-7">
                <div class="landing-page-login-form-wrapper pt-18 d-flex">
                    <div class="login-form-inner">
                        <h3>Hello, Welcome</h3>
                        <div class="form-top-text"><span>Login</span> with your correct credentials to proceed.</div>
                        <?php the_custom_form_login(); ?>
                    </div>
                    <div class="landing-page-footer-menu">
                        <?php 
						wp_nav_menu( 
							array( 
								'theme_location' => 'footer-menu'
							) 
						); 
					?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php } ?>
<?php get_footer();?>

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js">
</script>

<script>
jQuery(document).ready(function() {
    var table = jQuery('#your_students').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        pageLength: 50,
        // language: {
        //     'paginate': {
        //         'previous': ajaxObj.previous,
        //         'next': ajaxObj.next
        //     }
        // },
        // columnDefs: [
        //         { responsivePriority: 1, targets: 0 },
        //         { responsivePriority: 2, targets: -1 },
        //     ],
        order: [
            [1, 'asc']
        ],
    });
    table.on('order.dt search.dt', function() {
        let i = 1;

        table.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();
    jQuery('a.toggle-vis').on('click', function(e) {
        e.preventDefault();
        // Get the column API object
        var column = table.column(jQuery(this).attr('data-column'));
        // Toggle the visibility
        column.visible(!column.visible());
    });

});
setTimeout(() => {

    document.querySelector('#your_students_info').style.visibility = 'hidden'
    document.querySelector('#your_students_paginate').style.display = 'none'
}, 1000);
</script>