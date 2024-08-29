<?php
    if( isset($_GET['sid']) ){
    	$sid = isset($_GET['sid']) ? $_GET['sid'] : 1;
    }
    else{
    	$sid = isset($_GET['id']) ? $_GET['id'] : 1;
    }
    $my_current_lang = apply_filters( 'wpml_current_language', NULL );
    $cid = $args['cid'];
    $subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = ".$cid);
    $uid = $sid;
    $subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = ".$cid);

    $cols = "";
    foreach($subjects as $subject){
        $cols .= "SUM(".$subject->slug.") as ".$subject->slug." ,"; 
    }
    if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
        $entries = $wpdb->get_results("SELECT $cols course_id, date_format(reporting_date, '%Y年 %c月') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " AND `course_id`=".$cid. " group by YEAR(reporting_date), MONTH(reporting_date)");
   }
//    elseif($my_current_lang == 'pt-pt'){
//     $entries = $wpdb->get_results("SELECT $cols course_id, date_format(reporting_date, '%M %Y) as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " AND `course_id`=".$cid. " group by YEAR(reporting_date), MONTH(reporting_date)");
//    }
   else {
       $entries = $wpdb->get_results("SELECT $cols course_id, date_format(reporting_date, '%M %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " AND `course_id`=".$cid. " group by YEAR(reporting_date), MONTH(reporting_date)");
   }
    foreach($entries as $key => $entry){
        //$data1['id']  = $entry->user_id;
        //$data1['user_id']  = $entry->user_id;
        $data1['month'] = $entry->reporting_date;
        $total = 0;
        foreach($subjects as $subject){
            $sub = $subject->slug;
            $data1[$sub] = $entry->$sub; 
            $total+= (int)$entry->$sub;
        }
        $data1['total'] = $total;
        $data[] = $data1;
    }
    $track = get_the_author_meta( 'track', $uid );
    $course = $wpdb->get_row("Select * from ngondro_courses where course_id=".$cid);
  
    $columns = array(
        'month' => __("Date","ngondro_gar")
    );
    foreach($subjects as $sub){
        $columns[$sub->slug] = __($sub->title,'ngondro_gar');
    }
    $columns['total'] = __("Total","ngondro_gar");

    $prb = __('Preliminaries, Refuge, Bodhicitta','ngondro_gar');
?>

    <div class="custom-table-responsive students-list">
        <table class="table table-striped report_history report_history_table" id="">
            <thead>
                <tr>
                    <?php foreach($columns as $col):?>
                        <th><?php echo __($col,'ngondro_gar');?></th>
                    <?php endforeach;?>
                </tr>
            </thead>
            <tbody>
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
            <tr>
                <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                <?php foreach($foot_total as $foot):?>
                        <td><strong><?=$foot?></strong>
                        </td>
                <?php endforeach;?>       
            </tr>
            </tbody>
            <!-- <tfoot style="display:none !important;">
            <tr>
                <td colspan = "1"><?php //echo __('Total','ngondro_gar');?></td>
                <?php //foreach($foot_total as $foot):?>
                        <td><?//=$foot?>
                        </td>
                <?php //endforeach;?>       
            </tr>
        </tfoot> -->
        </table>
    </div>