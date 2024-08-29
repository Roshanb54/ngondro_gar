<?php 
/**
 * Template Name: Hours Reporting Page
 * @desc Student Hour Reporting Page
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @function {wp_safe_redirect} Performs a safe (local) redirect
 * @params {terms} [object] Return all curriculums 
 * @params {subjects} [Array] Array of curriculum
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if(!is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}

get_header('loggedin');
$my_current_lang = apply_filters( 'wpml_current_language', NULL );
$user_info = wp_get_current_user();
$user_info  = $user_info->data;
global $wpdb;
$after_submit_report="";

$empty = 1;
/*Save student hour report*/
if( isset($_POST['report_submit']) )
{
	$data = $_POST;
    unset($data['report_submit']);
    unset($data['username']);
    foreach($data as $key=>$check){
        if($key!="user_id" && strlen($check)!=0){$empty = 0;break;}
    }

    if( isset($_POST['prev_month']) )
    {
        /*prev month*/
        unset($data['prev_month']);
        $month_ini = new DateTime("first day of last month");
        $month_end = new DateTime("last day of last month");

        $first_day_of_last_month = $month_ini->format('Y-m-d');
        $last_day_of_last_month = $month_end->format('Y-m-d');

        $data['reporting_date'] = $last_day_of_last_month;
        $data['course_id'] = get_the_author_meta( 'curriculum', get_current_user_id() );
        $user_course_id = get_the_author_meta( 'curriculum', get_current_user_id() );

        $current_date = date('Y-m-d');
        $userid = $data['user_id'];

        $data_report = $wpdb->get_row("SELECT * from `user_reporting` where `user_id` = '$userid' AND `course_id` = '$user_course_id' AND `reporting_date` BETWEEN '$first_day_of_last_month' AND '$last_day_of_last_month'");
        $new_total = 0;
        $data_sub = $data;
        unset($data_sub['reporting_date']);
        unset($data_sub['course_id']);
        unset($data_sub['user_id']);

        foreach($data_sub as $total){
        $new_total += (int) $total;  
        }

        if($data_report){
            $entry_id = $data_report->id;
            
            $old_total = 0;
            for($i=1; $i<=21; $i++){
                $slug = 'sub_'.$i;
                $old_total += (int)$data_report->$slug;
            }
            $last_reported_hour = $new_total - $old_total;
            update_user_meta( $userid, 'last_reported_hour', $last_reported_hour );

            $wpdb->update('user_reporting', $data, array('id'=>$entry_id));
        }
        else{
            update_user_meta( $userid, 'last_reported_hour', $new_total );
            $wpdb->insert('user_reporting', $data);
        }
        $status = "inserted";
        /*end*/
        $after_submit_report="prev";

    }
    else
    {

        /*current month*/
        $data['reporting_date'] = date('Y-m-d');

        // if(date('Y-m-d') <= date('Y-m-03')){
        //     $month_end_date = new DateTime("last day of last month");
        //     $data['reporting_date'] = $month_end_date->format('Y-m-d');
        //     var_dump($data['reporting_date']);
        //     var_dump(date('Y-m-03'));
        // }
        $data['course_id'] = get_the_author_meta( 'curriculum', get_current_user_id() );
        $user_course_id = get_the_author_meta( 'curriculum', get_current_user_id() );

        $current_date = date('Y-m-d');
        $userid = $data['user_id'];

        $first_day_of_month = date('Y-m-01');
        $last_day_of_month = date('Y-m-t');

        if(date('Y-m-d') <= date('Y-m-03')){
            $month_end_date = new DateTime("last day of last month");
            $data['reporting_date'] = $month_end_date->format('Y-m-d');
            $first_day_of_month = date('Y-m-01', strtotime('-1 MONTH')); 
            $last_day_of_month = date('Y-m-t', strtotime('-1 MONTH'));

            // var_dump($data['reporting_date']);
            // var_dump(date('Y-m-03'));
        }

        // echo date('Y-m-28');

        // if(date("Y-m-d") <= date("Y-m-28")){
        //     echo $first_day_of_month = date('Y-m-01', strtotime('-1 MONTH'));    
        //     echo $last_day_of_month = date('Y-m-t', strtotime('-1 MONTH'));    
        // }
        
        

        $data_report = $wpdb->get_row("SELECT * from `user_reporting` where `user_id` = '$userid' AND `course_id` = '$user_course_id' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
        $new_total = 0;
        $data_sub = $data;
        unset($data_sub['reporting_date']);
        unset($data_sub['course_id']);
        unset($data_sub['user_id']);

        foreach($data_sub as $total){
        $new_total += (int) $total;  
        }

        if($data_report){
            $entry_id = $data_report->id;
            
            $old_total = 0;
            for($i=1; $i<=21; $i++){
                $slug = 'sub_'.$i;
                $old_total += (int)$data_report->$slug;
            }
            $last_reported_hour = $new_total - $old_total;
            update_user_meta( $userid, 'last_reported_hour', $last_reported_hour );

            $wpdb->update('user_reporting', $data, array('id'=>$entry_id));
        }
        else{
            update_user_meta( $userid, 'last_reported_hour', $new_total );
            $wpdb->insert('user_reporting', $data);
        }
        $status = "inserted";
        /*end*/
        $after_submit_report="current";

    }
   	
}
?>
<div id="layoutSidenav_content">
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
            <div class="container-xl px-9">
                <div class="page-header-content pt-4">
                    <div class="row align-items-end justify-content-start">
                        <div class="col-xl-8 col-md-6 col-12 mt-4">
                            <h3><?php echo __('Hours reporting','ngondro_gar');?></h3>
                            <?php
                            if(date('y-m-d') <= date('y-m-03')){
                                ?>
                                <p><?php echo __('Use this page to report hours accumulated between :','ngondro_gar');?> <span>
                                    <?php 
                                    // echo date('Y年 n月 t日', strtotime('-1 MONTH'));
                                    
                                    ?>
                            <?php 
                                if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                // echo date('Y年 n月 01日');
                                echo date('Y年 n月 01日', strtotime('-1 MONTH'));
                            }
                            elseif($my_current_lang == 'pt-pt'){
                                // echo date('01 \d\e F, Y');
                                echo date('01 \d\e F, Y', strtotime('-1 MONTH'));
                            }
                            else {
                                echo date('01 F Y', strtotime('-1 MONTH'));
                            }?>
                            </span> <?php echo __('and','ngondro_gar');?> <span>
                            <?php 
                                if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                // echo date('Y年 n月 t日');
                                echo date('Y年 n月 t日', strtotime('-1 MONTH'));
                            }
                            elseif($my_current_lang == 'pt-pt'){
                                // echo date('t \d\e F, Y');
                                echo date('t \d\e F, Y', strtotime('-1 MONTH'));
                            }
                            else {
                                // echo date('t F Y');
                                echo date('t F Y', strtotime('-1 MONTH'));
                            }?>
                            . This Report Due <?php echo date('03 F Y') ?></p>
                                
                            <?php
                            }else{
                            ?>

                            <p><?php echo __('Report your hours accumulated between:','ngondro_gar');?> <span>
                            <?php 
                                if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                echo date('Y年 n月 01日');
                            }
                            elseif($my_current_lang == 'pt-pt'){
                                echo date('01 \d\e F, Y');
                            }
                            else {
                                echo date('01 F Y');
                            }?>
                            </span> <?php echo __('and','ngondro_gar');?> <span>
                            <?php 
                                if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                echo date('Y年 n月 t日');
                            }
                            elseif($my_current_lang == 'pt-pt'){
                                echo date('t \d\e F, Y');
                            }
                            else {
                                echo date('t F Y');
                            }?>
                            .</p>
                            <?php } ?>
                        </div>
                        <div class="col-xl-4 col-md-6 d-flex justify-content-lg-end justify-content-md-end justify-content-sm-start mb-3">
                        <div class="view-reporting-history-btn">
                        <a href="<?php echo home_url('student-report?id=').$user_info->ID;?>" class="btn btn-tranparent mr-2"> <?php echo __('View Reporting History', 'ngondro_gar');?> <i class="fa fa-file"></i></a>
                        </div>    
                    </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container-xl px-9">
            <div class="row">
                <div class="col-xl-12">
                    <div class="center-box-wrapper">
                        <div class="hours-reporting-box-wrapper">
                            <div class="box-title-wrapper d-block">

                                <?php
                                if( isset($_POST['report_submit']) && $after_submit_report=="current" )
                                {
                                    if($empty==0)
                                    {
                                        if($status=="inserted"){
                                            echo __("<p class='alert alert-success' style='padding:10px'>Data added successfully !</p>","ngondro_gar");
                                        }
                                        else
                                        {
                                            echo __("<p class='alert alert-info' style='padding:10px'>Data already updated!</p>","ngondro_gar");
                                        }
                                    }
                                    else{
                                        echo __("<p class='alert alert-info' style='padding:10px'>Please input at least one value</p>","ngondro_gar");
                                    }
                                }

                                $first_day_of_month = date('Y-m-01');
                                $last_day_of_month = date('Y-m-t');
                                $uid = $user_info->ID;

                                 if(date("Y-m-d") <= date("Y-m-03")){
                                        $first_day_of_month = date('Y-m-01', strtotime('-1 MONTH'));    
                                        $last_day_of_month = date('Y-m-t', strtotime('-1 MONTH'));    
                                    }

                                $month_ini = new DateTime("first day of last month");
                                $month_end = new DateTime("last day of last month");

                                $first_day_of_last_month = $month_ini->format('Y-m-d');
                                $last_day_of_last_month = $month_end->format('Y-m-d');


                                $user_reports  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
                               
                                $curriculum = get_the_author_meta( 'curriculum',  $uid ); 
                                $subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = ".$curriculum);
                                $subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = ".$curriculum);

                                $cols = "";
                                foreach($subjects as $subject){
                                    $cols .= "SUM(".$subject->slug.") as ".$subject->slug." ,"; 
                                }

                                $user_reports  = $wpdb->get_row("SELECT  $cols user_id from `user_reporting` WHERE user_id = '$uid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'", ARRAY_A);

                                $user_all_reports  = $wpdb->get_row("SELECT  $cols user_id from `user_reporting` WHERE user_id = '$uid' AND course_id = '$curriculum'", ARRAY_A);
                                
                                $total_user_reporting = 0;
                                foreach($subjects as $subject){
                                    $total_user_reporting += (int)$user_all_reports[$subject->slug];
                                }
                               
                                $total_required = (int) $subjects_total->total_hour;
                                if($total_required<=0){$total_required=1;}
                                $per = ($total_user_reporting * 100)/$total_required;

                                /* Previous Month */
                                $prev_user_reports  = $wpdb->get_row("SELECT $cols user_id from `user_reporting` WHERE user_id = '$uid' AND `reporting_date` BETWEEN '$first_day_of_last_month' AND '$last_day_of_last_month'", ARRAY_A);
                                
                                $prev_total_user_reporting = 0;
                                foreach($subjects as $subject){
                                    $prev_total_user_reporting += (int)$prev_user_reports[$subject->slug];
                                }
                                /*end*/

                                $refuge_text = __('Refuge','ngondro_gar');
                                $prb = __('Preliminaries, Refuge, Bodhicitta','ngondro_gar');
                                $outer_pre = __('Outer preliminaries','ngondro_gar');
                                $date_text = __('Date','ngondro_gar');

                                ?>

                            </div>
                            <div class="hours-reporting-content-wrapper current_month1 d-none d-md-block d-lg-block">
                                <form method="POST">
                                    <div class="hours-reporting-table-wrapper">
                                        <div class="table-responsive">
                                            <table class="hours-reporting-table table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"><?php echo __('Practice Section','ngondro_gar');?></th>
                                                        <th scope="col"><?php echo __('Hours','ngondro_gar');?></th>
                                                        <th scope="col"><?php echo __('Remaining<br/>(Hours)','ngondro_gar');?></th>
                                                        <th scope="col"><?php echo __('Required<br/>(Hours)','ngondro_gar');?></th>
                                                        <th scope="col"><?php echo __('Previously<br/>Reported','ngondro_gar');?></th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                <?php foreach($subjects as $subject):
                                                    $user_report = (int)($user_reports[$subject->slug]==NULL)?0:$user_reports[$subject->slug];
                                                   
                                                    $new_user_report = (int)($user_all_reports[$subject->slug]==NULL)?0:$user_all_reports[$subject->slug];
                                                    $remaining = (int)$subject->total -  $new_user_report;
                                                    
                                                    $rest_remain = ($remaining<=0) ? 0 : $remaining;
                                                    $rest_max_val = ($rest_remain==0) ? $subject->total : $rest_remain;

                                                ?>
                                                    <tr>
                                                        <th scope="row"><?php echo __($subject->title,'ngondro_gar');?></th>
                                                        <td>
                                                            <input type="number" onclick="this.focus();this.select()" value = "<?=$user_report?>" name="<?=$subject->slug?>" min="0" max="<?=$subject->total?>" class="w-100 px-2 report_input form-text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" placeholder="<?=$subject->title?>" <?php //echo ($remaining<=0)? "disabled":""?> >
                                                            <input type="hidden" name="user_id" value="<?=$uid?>" class="form-text">
                                                            <input type="hidden" name="username" value="<?=$user_info->display_name?>" class="form-text">
                                                        </td>
                                                        <td><?php
                                                                echo $remaining;
                                                            ?></td>
                                                        <td><?=$subject->total?></td>
                                                        <td class="prev_report">
                                                            <?php echo $new_user_report?>
                                                        </td>
                                                    </tr>

                                                    <?php endforeach;?>

                                                    <tr class="total">
                                                        <th scope="row"><?php echo __('Total','ngondro_gar');?></th>
                                                        <td class="input_td total_input">0</td>
                                                        <td><?=$total_required - $total_user_reporting?></td>
                                                        <td><?=$total_required?></td>
                                                        <td class="prev_report"><?=$total_user_reporting?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <button class="btn btn-lg btn-default mt-7" name="report_submit" type="submit"><?php echo __('Save report','ngondro_gar');?></button>
                                </form>
                            </div>
                            <div class="hours-reporting-content-wrapper current_month d-block d-md-none d-lg-none">
                                <form method="POST">
                                    <div class="hours-reporting-table-wrapper">
                                        <!--start for mobile-->
                                        <div class="hours-reporting-heading-title">
                                        <h4><?php echo __('Practice Section','ngondro_gar');?></h4>
                                        <button name="report_submit" type="submit"><?php echo __('Save','ngondro_gar');?></button>
                                        </div>
                                        <div class="accordion" id="accordionhrs">
                                            <?php
                                            if($subjects) {
                                                $i = 0;
                                                 foreach($subjects as $subject):
                                                    $user_report = (int)($user_reports[$subject->slug]==NULL)?0:$user_reports[$subject->slug];
                                                    
                                                    $new_user_report = (int)($user_all_reports[$subject->slug]==NULL)?0:$user_all_reports[$subject->slug];
                                                    $remaining = (int)$subject->total -  $new_user_report;
                                                    //$remaining = (int)$subject->total -  $user_report;
                                                    $rest_remain = ($remaining<=0) ? 0 : $remaining;
                                                    $rest_max_val = ($rest_remain==0) ? $subject->total : $rest_remain;

                                                ?>
                                                    <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading<?php echo $i;?>">
                                                    <button class="accordion-button <?php echo ($i == 0) ? '': 'collapsed';?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapse<?php echo $i;?>">
                                                    <?php echo __($subject->title,'ngondro_gar');?>
                                                    </button>
                                                    </h2>
                                                    <div id="collapse<?php echo $i;?>" class="accordion-collapse collapse <?php echo ($i == 0) ? 'show': '';?>" aria-labelledby="heading<?php echo $i;?>" data-bs-parent="#accordionhrs">
                                                    <div class="accordion-body">
                                                    <ul>
                                                        <li> <?php echo __('Remaining Hours','ngondro_gar');?> <div class="course-input-hrs-wrapper"><?php
                                                                echo $remaining;
                                                            ?></div></li>
                                                        <li><?php echo __('Required Hours','ngondro_gar');?> <div class="required-hours"><?=$subject->total?></div></li>
                                                        <li><?php echo __('Previously Reported','ngondro_gar');?> <div class="prev_report"><?php echo $new_user_report?></div></li>
                                                        <li><?php echo __('Report hours','ngondro_gar');?> <div class="course-input-hrs-wrapper">
                                                            <input type="number" onclick="this.focus();this.select()" value = "<?=$user_report?>" name="<?=$subject->slug?>" min="0" max="<?=$subject->total?>" class="w-100 px-2 report_input form-text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" placeholder="<?=$subject->title?>" <?php //echo ($remaining<=0)? "disabled":""?> >
                                                            <input type="hidden" name="user_id" value="<?=$uid?>" class="form-text">
                                                            <input type="hidden" name="username" value="<?=$user_info->display_name?>" class="form-text">
                                                        </div></li>

                                                    </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $i++;
                                            endforeach; ?>
                                            <div class="total-hrs-number total"><?php echo __('Total:','ngondro_gar');?><div class="input_td total_input"> 0</div></div>
                                           <?php  } ?>
                                            </div>
                                        <!--end for mobile-->

                                    </div>
                                </form>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php get_footer();?>
</div>

<script>
window.onclick = function () {
  var input = document.getElementById('myTextInput');
  input.focus();
  input.select();
}
</script>

<script type="text/javascript">


if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

let input_change = document.querySelectorAll('.current_month1 .report_input');
/*change current_month total hour on keyup*/
input_change.forEach(input=>{
	input.addEventListener('keyup', event => {
    	let input_fields = document.querySelectorAll('.current_month1 .report_input');
        var total = 0;
        input_fields.forEach(input=>{
            total += Number(input.value);
        })
        var elemList = document.querySelectorAll('.current_month1 .total_input');
        for (let i = 0; i < elemList.length; i++) {
            elemList[i].innerHTML = total;
        }
		// document.querySelector('.current_month .total_input').innerHTML = total;
    })
})

let input_change1 = document.querySelectorAll('.current_month .report_input');
/*change current_month total hour on keyup*/
input_change1.forEach(input=>{
	input.addEventListener('keyup', event => {
    	let input_fields = document.querySelectorAll('.current_month .report_input');
        var total = 0;
        input_fields.forEach(input=>{
            total += Number(input.value);
        })
        var elemList = document.querySelectorAll('.current_month .total_input');
        for (let i = 0; i < elemList.length; i++) {
            elemList[i].innerHTML = total;
        }
		// document.querySelector('.current_month .total_input').innerHTML = total;
    })
})

let prev_input_change = document.querySelectorAll('.previous_month .report_input');
/*change previous_month total hour on keyup*/
prev_input_change.forEach(input=>{
	input.addEventListener('keyup', event => {
    	let input_fields = document.querySelectorAll('.previous_month .report_input');
        var total = 0;
        input_fields.forEach(input=>{
            total += Number(input.value);
        })
        var elemList = document.querySelectorAll('.previous_month .total_input');
        for (let i = 0; i < elemList.length; i++) {
            elemList[i].innerHTML = total;
        }
		// document.querySelector('.previous_month .total_input').innerHTML = total;
    })
})

</script>