<?php 
/**
 * Template Name: Student Page
 * @desc Student Info
 * @returns {get_userdata} [object] Returns array of loggedin user 
 * @params {get_user_meta} [object] Return all user meta values 
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {get_users()} [object] Return users details
 * @returns {get_field()} [Value] Return acf field value base on field key
 * @function {wp_safe_redirect} Performs a safe (local) redirect
 * @returns {get_posts()} [Array] Return the all posts 
 */

if(!is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}
get_header('loggedin');
$my_current_lang = apply_filters( 'wpml_current_language', NULL );
$uid = isset($_GET['sid'])?$_GET['sid']:1;
$user = get_userdata($uid);
$user_meta = get_user_meta($uid);
$full_name = $user_meta['first_name'][0]." ".$user_meta['last_name'][0];
$social_icons = $user_meta['social_icon'][0]; 
$display_name = $user->data->display_name;
$text_filename = $display_name.'_'.$uid;
$user_language_short = $user_meta['language'][0];
$user_region_short = $user_meta['region'][0];
$region_fullname = $wpdb->get_row("SELECT nicename from `countries_data` where iso = '$user_region_short'", ARRAY_A);

$last_reporting_entry  = $wpdb->get_row("SELECT * from user_reporting where user_id=".$uid. " order by reporting_date DESC LIMIT 0, 1"); 
if($last_reporting_entry==NULL)
{
    $last_report_date = date("Y-m-d", strtotime($user->data->user_registered));
}
else{
    $last_report_date = $last_reporting_entry->reporting_date; 
}

$current_date = date_create(date('Y-m-d'));
$last_report_date = date_create($last_report_date);
$diff=date_diff($last_report_date,$current_date);
$diff_month = (int)$diff->format("%m");
$diff_total_year =  (int)$diff->format("%y");
$diff_total_days =  (int)$diff->format("%d");

$diff_total_days = ($diff_total_year * 12 ) + ($diff_month*30) + $diff_total_days;
//$diff = abs(strtotime(date($last_report_date)) - strtotime($user->user_registered)); 

$diffInDays =$diff_total_days;
$text_file = 'reports/user_'.$text_filename.'.csv';

$note = get_the_author_meta( 'instructor_note', $uid );
$cid = (int)get_the_author_meta( 'curriculum', $uid );

$begin = new DateTime( date('Y-m-d') );
$end   = new DateTime( $user->user_registered );
$months = [];
$total_months = 0;
$begin = $begin->modify('-1 months');
for($i = $begin; $i >= $end; $i->modify('-1 months')){
    $months[] = $i->format("M Y");
    $total_months++;
}

$entries  = $wpdb->get_results("SELECT * from user_reporting WHERE `user_id` = '$uid' AND course_id = '$cid'");
//$missed_report = $total_months - count($entries);
$missed_report = get_user_meta($uid, 'missed_last_report')[0];

?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

<div id="layoutSidenav_content">
    <div class="container">

        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="">
                    <div class="box-title-wrapper">
                        <h3><?php echo __('Student Profile','ngondro_gar');?></h3>
                    </div>
                    <div class="sidebar-inner-box">
                        <div class="student-profile-table-wrapper">
                            <div class="d-flex align-items-center profile-heading">
                                <div class="profile-image me-5">
                                    <?php
                                    $profile_img = get_the_author_meta( 'profile_image', $uid );
                                    if($profile_img):?>
                                    <img src="<?=$user_meta['profile_image'][0];?>" alt="Profile Pic" class="w-100 h-100">
                                    <?php else:?>
                                        <img src="<?=site_url('wp-content/uploads/2022/06/220X250.png')?>" alt="Profile Pic" class="w-100 h-100">
                                    <?php endif;?>
                                </div>
                                <div>
                                    <h3><?=$full_name?></h3>
                                    <?php
                                         $diff2 = abs(strtotime(date('Y-m-d')) - strtotime($user->user_registered)); 
                                         $years   = floor($diff2 / (365*60*60*24)); 
                                         $months  = floor(($diff2 - $years * 365*60*60*24) / (30*60*60*24)); 
                                         $days    = floor(($diff2 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                    ?>
                                    <p><?php echo __('Member since:','ngondro_gar');?> <span> <?=$years?> <?php echo __('Years','ngondro_gar');?> <?=$months?> <?php echo __('Months','ngondro_gar');?> <?=$days?> <?php echo __('Days','ngondro_gar');?> ( 
                                        <?php if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                                    echo date('Y年 n月 j日', strtotime($user->user_registered));
                                            }
                                            elseif($my_current_lang == 'pt-pt'){
                                               echo date('j \d\e F, Y', strtotime($user->user_registered));
                                            }
                                            else {
                                                echo date('j F Y', strtotime($user->user_registered));
                                            } ?>
                                            )</span></p>
                                </div>
                            </div>
                            <table class="table table-borderless mb-0">
                                <tbody>
                                <tr>
                                    <td rowspan="2">

                                    </td>
                                    <td style="vertical-align: bottom; padding: 0 0.5rem;"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top; padding: 0 0.5rem;"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php echo __('Full Name :','ngondro_gar');?></th>
                                    <td><?=$full_name?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php echo __('Email :','ngondro_gar');?></th>
                                    <td>
                                        <div class="form-floating">
                                            <a href="mailto:<?=$user->user_email?>"><?=$user->user_email?></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php echo __('Region :','ngondro_gar');?></th>
                                    <td><?php 
                                    if($region_fullname){
                                        echo $region_fullname['nicename'];
                                    }
                                    else {
                                        echo $user_region_short;
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php echo __('Social media :','ngondro_gar');?></th>
                                    <td>
                                        <?php
                                            $img_url = get_template_directory_uri().'/assets/images/'.$social_icons.'.png';
                                        ?>
                                        <?php if($social_icons):?>
                                            <img src="<?=$img_url?>">
                                        <?php endif;?>
                                        <?=$user_meta['sociallink'][0]?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php echo __('Language:','ngondro_gar');?></th>
                                    <td>
                                        <?php 
                                        if($user_language_short == 'en'){
                                            echo ucfirst('English');
                                        }
                                        else if($user_language_short == 'zh-hant'){
                                            echo ucfirst('繁體中文');
                                        }
                                        else if($user_language_short == 'zh-hans'){
                                            echo ucfirst('简体中文');
                                        }
                                        else if($user_language_short == 'pt-br'){
                                            echo ucfirst('Português');
                                        }
                                        ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-7">
            <div class="col-md-10 offset-md-1">
                <div class="sidebar-inner-box student-profile-view-details">
                    <nav class="mb-2">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true"><?php echo __('Course information','ngondro_gar');?></button>
                            <button class="nav-link" id="nav-reports-tab" data-bs-toggle="tab" data-bs-target="#nav-reports" type="button" role="tab" aria-controls="nav-reports" aria-selected="false"><?php echo __('Missed reports','ngondro_gar');?></button>
                            <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab" aria-controls="nav-history" aria-selected="false"><?php echo __('Reporting History','ngondro_gar');?></button>
                            <button class="nav-link" id="nav-details-tab" data-bs-toggle="tab" data-bs-target="#nav-details" type="button" role="tab" aria-controls="nav-details" aria-selected="false"><?php echo __('Registration Details','ngondro_gar');?></button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                            <table class="table table-borderless mt-6 mb-6">
                                <tbody>
                                <tr>
                                    <th><?php echo __('Enrolled Course','ngondro_gar');?></th>
                                    <td><?php
                                    $course = $wpdb->get_row("select * from ngondro_courses where course_id=".$user_meta['curriculum'][0]);
                                    echo $course->title;
                                    ?></td>
                                </tr>
                                <tr style="display:none;">
                                    <th><?php echo __('Instructor :','ngondro_gar');?> </th>
                                    <td>
                                        <div class="d-flex">
                                            <?php $ins_id = (int) get_the_author_meta( 'instructor', $uid );
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
                                            <?php if($ins_image):?>
                                                <img src="<?=$ins_image?>" alt="<?=$ins_name?>" style="border-radius:50%; width:50px; height:auto;margin-right:10px;object-fit:cover;">
                                            <?php endif;?>
                                                <?=$ins_name?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Practice hours :','ngondro_gar');?></th>
                                    <td><?=$user_meta['track'][0]?> <?php echo __('hour / day','ngondro_gar');?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Active Status :','ngondro_gar');?></th>
                                    <td><?php echo __('Active','ngondro_gar');?></td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Graduation status:','ngondro_gar');?></th>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <?php $graduate = get_the_author_meta( 'graduate', $user->ID );
                                                ?>
                                                <Select class="form-control graduate_option form-select fs-16" required>
                                                <option value="" disabled selected><?php echo __('Select Status','ngondro_gar');?></option>
                                                    <option value="Yes" <?php echo ($graduate=="Yes")?"selected":""?> ><?php echo __('Graduated','ngondro_gar');?></option>
                                                    <option value="No" <?php echo ($graduate=="No")?"selected":""?>><?php echo __('Not Graduated','ngondro_gar');?></option>
                                                </Select>
                                                <input type="hidden" value="<?=$uid?>">
                                                <p class="text-muted d-none"><?php echo __('Note: Maggie.Chau has not completed the Ngondro hours reporting requirement','ngondro_gar');?></p>
                                            </div>
                                            <button type="button" name="graduate_submit" class="btn btn-link-default graduated_submit" data-user="<?=$uid?>"><?php echo __('Save','ngondro_gar');?></button>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Exempt:','ngondro_gar');?></th>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <?php $exempt = $user_meta['exempt'][0];
                                                $graduate = get_the_author_meta( 'Exempt', $user->ID );
                                                ?>
                                                <Select class="form-control exempt_option form-select fs-16" required>
                                                <option value="" disabled selected><?php echo __('Select Exempt','ngondro_gar');?></option>
                                                    <option value="Yes" <?php echo ($exempt=="Yes")?"selected":""?> ><?php echo __('Yes','ngondro_gar');?></option>
                                                    <option value="No" <?php echo ($exempt=="No")?"selected":""?>><?php echo __('No','ngondro_gar');?></option>
                                                </Select>
                                                <input type="hidden" value="<?=$uid?>">
                                                
                                            </div>
                                            <button type="button" name="exempt_submit" class="btn btn-link-default exempt_submit" data-user="<?=$uid?>"><?php echo __('Save','ngondro_gar');?></button>
                                        </div>

                                    </td>
                                </tr>
                                

                                <tr>
                                    <th><?php echo __('Student Remarks:','ngondro_gar');?></th>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <textarea name="notes" maxlength="500" rows="5" class="student_notes"><?=$note?></textarea>
                                                <input type="hidden" value="<?=$uid?>">
                                                <p class="text-muted"></p>
                                            </div>
                                            <button type="button" name="remarks_submit" class="btn btn-link-default remarks_submit" data-user="<?=$uid?>">Save</button>
                                        </div>
                                    </td>
                                </tr>
                               
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="nav-reports" role="tabpanel" aria-labelledby="nav-reports-tab" tabindex="0">
                           
                            
                            <div class="d-flex justify-content-between">
                                <div class="heading">
                                    <h4><?php echo __('Missed reports','ngondro_gar');?></h4>
                                    <p><?php echo __('Last reported:','ngondro_gar');?> <?=$diffInDays?> <?php echo __('days ago.','ngondro_gar');?><br><?php echo __('Total','ngondro_gar');?> <?=$missed_report?> <?php echo __('missed reports.','ngondro_gar');?></p>
                                </div>
                                <?php 
                                $user_status = get_user_meta( $user->ID, 'ng_user_approve_status' )[0] ?? null;
                                ?>
                                <a href="javascript:void(0);" data_id="<?php echo $user->ID;?>" data_status="<?php echo $user_status;?>" class="btn btn-link-default ajax-loading" id="user_act_deact_btn">
                                <?php if($user_status == 'approved'){
                                    echo __('Deactivate','ngondro_gar');
                                } else if($user_status == 'decline'){
                                    echo __('Activate','ngondro_gar');
                                } else {
                                    echo "";
                                } ?>
                                </a>
                            </div>
                             
                            <div class="table-wrapper overflow-auto">
                                
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="0">
                            <div class="table-wrapper overflow-auto">
                              	
                                    <div class="left-sidebar-wrapper">
                                        <div class="course-progression-wrapper">
                                            <div class="sidebar-inner-box text-center mb-10">
                                                <?php
                                                $sid = isset($_GET['sid']) ? $_GET['sid'] : 1;
                                                $cid = get_the_author_meta( 'curriculum', $sid );
                                                $subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = ".$cid);
												$sel_user = get_userdata($sid);
                                                $uid = $sid;
                                                $subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = ".$cid);

                                                $cols = "";
                                                foreach($subjects as $subject){
                                                    $cols .= "SUM(".$subject->slug.") as ".$subject->slug." ,"; 
                                                }
                                                
                                                $user_last_date = date("M 01, Y", strtotime($sel_user->data->user_registered));

                                                $current_date = date('Y-m-d');
                                                $begin = new DateTime( $current_date );
                                                $end   = new DateTime( $user_last_date );
                                                $months = [];
                                                $total_months = 0;
                                                //$begin = $begin->modify('-1 months');	

                                                $request = $wpdb->get_row("SELECT * FROM ngondro_request where `type` = 'course' AND status = '1' AND user_id = ".$uid." ORDER BY id DESC");
                         

                                                $entries = $wpdb->get_results("SELECT $cols course_id, date_format(reporting_date, '%b %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " AND `course_id`=".$cid. " group by YEAR(reporting_date), MONTH(reporting_date)");

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
                                                            //$data1['month'] = date("M t, Y", strtotime($entry->reporting_date));
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
                                                    <p><?php echo __('Curriculum:','ngondro_gar');?> <?=$course->title?>; 
                                                    <?php echo __('Commitment','ngondro_gar');?> <?=$track?> 
                                                    <?php echo __('hours per day.','ngondro_gar');?></p>
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
                                                    <table class="table table-striped report_history report_history_table" id="report_history_tbl<?=$cid?>">
                                                        <thead>
                                                            <tr>
                                                                <?php foreach($columns as $col):?>
                                                                    <th><?=$col?></th>
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
                                                                <?php if(!empty($foot_total) && is_array($foot_total)){ ?>
                                                            <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                                            <?php }?>
                                                            <?php foreach($foot_total as $foot):?>
                                                                    <td><strong><?=$foot?></strong>
                                                                    </td>
                                                            <?php endforeach;?>       
                                                        </tr>
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

                        <div class="tab-pane fade" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab" tabindex="0">
                                    
                            <div class="table-wrapper overflow-auto">

                            <table class="table table-borderless mt-4 mb-4">
                            <?php
                                $motivation = get_the_author_meta('motivation', $user->ID);
                                $experience = get_the_author_meta('experience', $user->ID);
                                $history = get_the_author_meta('history', $user->ID);
                                $obstacles = get_the_author_meta('obstacles', $user->ID);
                                //$dd_participant = get_the_author_meta( 'dd_participant', $user->ID );

                                /*custom code*/
                                $social_icon = get_the_author_meta('social_icon', $user->ID);
                                $sociallink = get_the_author_meta('sociallink', $user->ID);
                                $city = get_the_author_meta('city', $user->ID);

                                $dharm_das = get_the_author_meta('dharm_das', $user->ID);
                                $address = get_the_author_meta('address', $user->ID);

                                $language = get_the_author_meta('language', $user->ID);
                                $track = get_the_author_meta('track', $user->ID);
                                $curriculum = get_the_author_meta('curriculum', $user->ID);
                                $filter_by_language = get_the_author_meta('filter_by_language', $user->ID);
                                $instructor = get_the_author_meta('instructor', $user->ID);
                                $approve_status = get_the_author_meta('ng_user_approve_status', $user->ID);

                                $graduate = get_the_author_meta('graduate', $user->ID);
                                $exempt = get_the_author_meta('exempt', $user->ID);
                                $note = get_the_author_meta('note', $user->ID);

                                $user_img = get_the_author_meta('profile_image', $user->ID);

                                $missed_last_report = get_user_meta($user->ID, 'missed_last_report');
                                $total_reported_hours = get_user_meta($user->ID, 'total_reported_hours');
                                /*end*/
                                ?>
                                <tbody>
                                <tr>
                                <th><label for="motivation"> <?php echo __('1.Please share your motive to join Ngondro Gar.','ngondro_gar');?></label></th>
                                <td>
                                    <p><?php if ($motivation): echo $motivation;endif; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="experience"><?php echo __('2.Please list your most significant Buddhist practice and training experience.
                                        You might list refuge and bodhisattva vow taken, main empowerments received, training programs
                                        attended, retreats undertaken, affiliation with practice groups or meditation centers. Please
                                        include approximate dates, durations and teachers as applicable.','ngondro_gar');?></label></th>
                                <td>
                                   <p><?php if ($experience): echo $experience;endif; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="history"><?php echo __('3.Have you met Dzongsar Khyentse Rinpoche and have you received teachings from
                                        him?','ngondro_gar');?></label></th>
                                <td>

                                    <p><?php if ($history): echo $history;endif; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="obstacles"><?php echo __('4.Which practice track are you planning to join? What kind of obstacles will
                                        likely arise, and how will you handle these obstacles?','ngondro_gar');?></label></th>
                                <td>

                                   <p><?php if ($obstacles): echo $obstacles;endif; ?></p>
                                </td>
                            </tr> 
                                </tbody>
                            </table>
                                
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>


    </div>

    <?php get_footer();?>

</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

<script>

jQuery(document).on('click','.transfer_info_btn',function(e){

    $this = jQuery(this);
    $this.html('Saving...');
    var data = {
        'action': 'transfer_information',
        'data': jQuery('.transfer_info_form').serializeArray(),
    };

    jQuery.ajax({
        url: ajaxObj.ajaxurl,
        method: 'POST',
        data: data,
        success:function(data) {
            $this.html('Saved');
            const myTimeout = setTimeout(function(){
                $this.html('Save');
            }, 2000);
            jQuery('#subject').val(''); jQuery('#message').val('');
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });

})

/*graduated submit*/
jQuery(document).on('click','.graduated_submit',function(e){
    $this = jQuery(this);
    $this.html('Saving...');
    var data = {
        'action': 'save_graduated_info',
        'option': jQuery('.graduate_option').val(),
        'user': jQuery(this).attr('data-user'),
    };
    jQuery.ajax({
        url: ajaxObj.ajaxurl,
        method: 'POST',
        data: data,
        success:function(data) {
            $this.html('Saved');
            const myTimeout = setTimeout(function(){
                $this.html('Save');
            }, 2000);
            jQuery('#subject').val(''); jQuery('#message').val('');
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });

})

/*exempt submit*/
jQuery(document).on('click','.exempt_submit',function(e){
    $this = jQuery(this);
    $this.html('Saving...');
    var data = {
        'action': 'save_exempt_info',
        'option': jQuery('.exempt_option').val(),
        'user': jQuery(this).attr('data-user'),
    };

    jQuery.ajax({
        url: ajaxObj.ajaxurl,
        method: 'POST',
        data: data,
        success:function(data) {
            $this.html('Saved');
            const myTimeout = setTimeout(function(){
                $this.html('Save');
            }, 2000);
            jQuery('#subject').val(''); jQuery('#message').val('');
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });

})

/*update remarks*/
jQuery(document).on('click','.remarks_submit',function(e){
    $this = jQuery(this);
    $this.html('Saving...');
    var data = {
        'action': 'save_remarks',
        'notes': jQuery('.student_notes').val(),
        'user': jQuery(this).attr('data-user'),
    };
    jQuery.ajax({
        url: ajaxObj.ajaxurl,
        method: 'POST',
        data: data,
        success:function(data) {
            $this.html('Saved');
            const myTimeout = setTimeout(function(){
                $this.html('Save');
            }, 2000);
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });

})

jQuery(document).ready( function () {
    
    jQuery('.report_history_table').DataTable( {
        dom :'Bfrtip',
    	responsive: true,
        "infoCallback": function( settings, start, end, max, total, pre ) {
            if(end === total && end !== 0){
                var customEnd = end - 1;
                return 'Showing ' + start + ' to ' + customEnd + ' of ' + (total - 1) + ' entries';
            }
            else {
                customEnd = end;
                if(total === 0){
                    start = total;
                }
                return 'Showing ' + start + ' to ' + customEnd + ' of ' + total + ' entries';
            }
           
        }
	} );
    
    jQuery('#missed_report_student').DataTable( {
        dom: 'Bfrtip',
        responsive: true,
        searching: false,
        buttons: [
            'csv'
        ]
    } );

} );

// jQuery(document).ready( function () {
//     var single_datatable = jQuery('.single_profile_history').on( 'page.dt',   function () { 
//         var info = single_datatable.page.info(); 
//         let curr_page = info.page;
//         let last_page = info.pages-1;
//         if(curr_page==last_page){jQuery('.single_profile_history tfoot').show()}else{jQuery('.single_profile_history tfoot').hide()} 
//         }).DataTable( {
//         dom: 'Bfrtip',
//         searching: false,
//         "ordering": false,
//         buttons: [
//             ],
//         responsive: true
//     } );
//     var pageinfo = single_datatable.page.info();  
//     if(pageinfo.pages==1){
//         jQuery('.single_profile_history tfoot').show();
//     }
   
// } );

jQuery('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    var single_datatable = jQuery('.report_history_table').on( 'page.dt',   function () { 
        var info = single_datatable.page.info(); 
        let curr_page = info.page;
        let last_page = info.pages-1;
         if(curr_page==last_page){jQuery('.report_history_table tfoot').show()}else{jQuery('.report_history_table tfoot').hide();} 
        }).DataTable( {
        dom: 'Bfrtip',
        searching: false,
        bDestroy: true,
        "ordering": false,
        buttons: [
            ],
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
        responsive: true,
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
           return 'Showing ' + start + ' to ' + customEnd + ' of ' + total + ' entries';
        }
    } );
    var pageinfo = single_datatable.page.info();  
    if(pageinfo.pages==1){
        jQuery('.report_history_table tfoot').show();
    }
 });





  
        
</script>