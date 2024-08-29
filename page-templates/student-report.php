<?php 
/**
 * Template Name: Student Report Page
 * @desc Student Report Page
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {get_the_title} [Value] Return title of the page/post
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 */
get_header('loggedin');
global $wpdb;
$my_current_lang = apply_filters( 'wpml_current_language', NULL );
$current_user = wp_get_current_user();
$uid = $current_user->data->ID;
?>

<style>
    table.dataTable tfoot td {
        text-align: center!important;
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
<div id="layoutSidenav_content">
    <section class="courses-page-wrapper mt-10 logged-in-user">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="left-sidebar-wrapper">
                        <div class="course-progression-wrapper">
                            <h3 class="sidebar-title"> <?php echo __('Reporting History for','ngondro_gar');?> <?php echo __($current_user->data->display_name,'ngondro_gar');?></h3>
                            <div class="sidebar-inner-box text-center mb-10">
                                <?php
                                 $sid = isset($_GET['id']) ? $_GET['id'] : 1;
                                 $cid = get_the_author_meta( 'curriculum', $sid );
                                 $subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = ".$cid);

                                $uid = $sid;
                                $subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = ".$cid);
                        
                                $cols = "";
                                foreach($subjects as $subject){
                                    $cols .= "SUM(".$subject->slug.") as ".$subject->slug." ,"; 
                                }
                                $user_last_date = date("M 01, Y", strtotime($current_user->data->user_registered));
                                
								$current_date = date('Y-m-d');
                                $begin = new DateTime( $current_date );
                                $end   = new DateTime( $user_last_date );
                                $months = [];
                                $total_months = 0;
								// $begin = $begin->modify('-1 months');	

                                $request = $wpdb->get_row("SELECT * FROM ngondro_request where `type` = 'course' AND status = '1' AND user_id = ".$uid." ORDER BY id DESC");
                                

                                $entries = $wpdb->get_results("SELECT $cols course_id, date_format(reporting_date, '%b %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " AND `course_id`='".$cid."' group by YEAR(reporting_date), MONTH(reporting_date)");

                                
								for($i = $begin; $i >= $end; $i->modify('-1 months'))
                               {
                                    $filtered = array_filter($entries, function($value) use ($val, $i) {
                                        return $value->reporting_date == $i->format("M Y");
                                    });

                                    if($filtered)
                                    {
                                        foreach($filtered as $key => $entry){
                                            $data1['id']  = $entry->user_id;
                                            $data1['user_id']  = $entry->user_id;
                                            if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                                    $data1['month'] = date('Y年 n月 t日', strtotime($entry->reporting_date));
                                            }
                                            elseif($my_current_lang == 'pt-pt'){
                                                $data1['month'] = date('t \d\e F, Y', strtotime($entry->reporting_date));
                                            }
                                            else {
                                                $data1['month'] = date('t F Y', strtotime($entry->reporting_date));
                                            }
                                            $total = 0;
                                            foreach($subjects as $subject){
                                                $sub = $subject->slug;
                                                $data1[$sub] = $entry->$sub; 
                                                $total+= (int)$entry->$sub;
                                            }
                                            $data1['total'] = $total;
                                            $data[] = $data1;
                                        }
                                    }
                                    else{
                                        if($i->format('Y-m-d') > $request->date){
                                        $data1['id']  = $uid;
                                        $data1['user_id']  = $uid;
                                        if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                            $data1['month'] = $i->format('Y年 n月 t日');
                                       }
                                       elseif($my_current_lang == 'pt-pt'){
                                        $data1['month'] = $i->format('t \d\e F, Y');
                                       }
                                       else {
                                        $data1['month'] = $i->format('t F Y');
                                       }
                                        //$data1['month'] =  $i->format("M t, Y");
                                        $total = 0;
                                        foreach($subjects as $subject){
                                            $sub = $subject->slug;
                                            $data1[$sub] = 0; 
                                            $total+= 0;
                                        }
                                        $data1['total'] = 0;
                                        $data[] = $data1;
                                    }
                                    }


                               }
                                $track = get_the_author_meta( 'track', $uid );
                                $course = $wpdb->get_row("Select * from ngondro_courses where course_id=".$cid);
                                ?>
                                <div class="overall text-left" style="text-align:left;">
                                    <p><?php echo __('Curriculum:','ngondro_gar');?> <?php echo __($course->title, 'ngondro_gar')?>; <?php echo __('Commitment','ngondro_gar');?> <?=$track?> <?php echo __('hours per day.','ngondro_gar');?></p>
                                </div>

                            <?php 
                                $columns = array(
                                    'month' => "Date",
                                );
                                foreach($subjects as $sub){
                                    $columns[$sub->slug] = $sub->title;
                                }
                                $columns['total'] = "Total";
                            ?>
                                <div class="custom-table-responsive students-list">
                                    <table class="table table-striped report_history" id="">
                                        <thead>
                                            <tr>
                                                <?php foreach($columns as $col):?>
                                                    <th><?php echo __($col,'ngondro_gar');?></th>
                                                <?php endforeach;?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($data !=''){ ?>
                                            <?php
                                             $foot_total= [];
                                            foreach($data as $key => $entry):?>
                                                <tr>
                                                    <td><?=$entry['month']?></td>
                                                    <?php
                                                    foreach($subjects as $sub):
                                                    $foot_total[$sub->slug] += $entry[$sub->slug];
                                                    ?>
                                                        <td><?=$entry[$sub->slug]?></td>
                                                    <?php endforeach;?>
                                                    <td><?php 
                                                     $foot_total['total'] += $entry['total']; 
                                                     echo $entry['total'];
                                                    ?></td>
                                                </tr>
                                            <?php endforeach;?>
                                            <?php } ?>
                                            <?php if($foot_total != ''){ ?>
                                            <tr>
                                            <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                            <?php foreach($foot_total as $foot):?>
                                                    <td><strong><?=$foot?></strong>
                                                    </td>
                                            <?php endforeach;?>       
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php
                                    /*other course details*/	
                                    $course_ids = $wpdb->get_results("Select course_id from user_reporting where user_id = ".$uid." AND course_id != ".$cid." GROUP BY course_id");
                                    foreach($course_ids as $cids):
                                    $sel_course = $wpdb->get_row("Select * from ngondro_courses where course_id = '$cids->course_id'");
                                    echo "<h3 class='sidebar-title' style='text-align:left; margin-top:30px;'>".__('Reporting History of Curriculum','ngondro_gar')."[".$sel_course->short_name."] </h4>";
                                    get_template_part( 'template-parts/content', 'history', array("cid"=>$cids->course_id) );
                                    endforeach;
                                    /*end*/	
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php

    function filter_callback($element, $rdate) {
        if (isset($element->reporting_date) && $element->reporting_date == $rdate) {
            return TRUE;
        }
        return FALSE;
    }

    ?>
    <?php get_footer();?>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

<script>
    jQuery(document).ready( function () {

        var single_datatable = jQuery('.report_history').on( 'page.dt',   function () { 
            var info = single_datatable.page.info(); 
            let curr_page = info.page;
            let last_page = info.pages-1;
        if(curr_page==last_page){jQuery('.report_history tfoot').show()}else{jQuery('.report_history tfoot').hide()} 
        }).DataTable( {
            dom: 'Bfrtip',
            searching: false,
            "ordering": false,
            buttons: [
                'csv'
            ],
            responsive: true,
            language: {
                'paginate': {
                'previous': ajaxObj.previous,
                'next': ajaxObj.next
                }
            },
            "infoCallback": function( settings, start, end, max, total, pre ) {
            if(end == total){
                customEnd = end - 1;
            }
            else {
                customEnd = end;
            }
            if(total !== 0){
                total = total-1;
            }else {
                total = total;
            }
            if(max == 0){
                start = 0;
                customEnd = 0
            }
           return '<?php echo __('Showing','ngondro_gar');?> ' + start + ' <?php echo __('to','ngondro_gar');?> ' + customEnd + ' <?php echo __('of','ngondro_gar');?> ' + total + ' <?php echo __('entries','ngondro_gar');?>';
        }
         } );
        var pageinfo = single_datatable.page.info();  
        if(pageinfo.pages==1){
            jQuery('.report_history tfoot').show();
        }

    } );
</script>

