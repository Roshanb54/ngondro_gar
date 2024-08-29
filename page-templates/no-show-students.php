<?php
/**
 * Template Name: No Show Students Page
 * @desc Display no show student report details
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {terms} [object] Return all curriculums 
 * @params {subjects} [Array] Array of curriculum
 * @returns {get_userdata()} [Array] Return loggedin user details
 * @returns {get_users()} [object] Return users details
 * @returns {get_posts()} [object] Return post/page details
 */

get_header('loggedin');                              

$data = [];
$students = get_users(
    array(
        'role' => 'student',
        'meta_key' => 'instructor',
        'meta_value' => get_current_user_id(),
        'number' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            'key' => 'missed_last_report',
            'value' => 11,
            'compare' => '>',
            'type' => 'numeric'
        )
        
    )
);

$missed_student = array();

$months[] = date("M Y", strtotime( date( 'Y-m-01' )));
for ($i = 1; $i < 12; $i++) {
    $months[] = date("M Y", strtotime( date( 'Y-m-01' )." -$i months"));
}

$past_year = strtotime("-12 month");
$past_year_date = date('Y-m-d', $past_year);

// foreach($students as $student)
// {
//     $reg_date = date("Y-m-d", strtotime($student->data->user_registered));
//     if($reg_date < $past_year_date)
//     {
//         $current_date = date('Y-m-d');
//         $cid = get_the_author_meta( 'curriculum', $student->data->ID ); 
//         $uid  = $student->data->ID;

//          /*missed reporting*/
//          $d1 = new DateTime($current_date);
//          $d2 = new DateTime($reg_date);
//          $interval = $d1->diff($d2);
//          $diff_month  = $interval->y;

//         $entries = $wpdb->get_results("SELECT user_id, course_id, date_format(reporting_date, '%b %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " AND `course_id`=".$cid. " group by month(reporting_date)");
//         $entries_array = array();
//         $missed_report = 1;
        
//         if($diff_month<1){
//             $missed_report = 0; 
//         }

//         if(count($entries)>0){
//             foreach($entries as $entry){
//                 if(in_array($entry->reporting_date, $months)){
//                     $missed_report = 0; 
//                 }
//             }  
//         }
        
//         if($missed_report==1){
//             $missed_student[] = $student->data->ID;
//         }
//     }
// }

/*end*/

// if ( $missed_student ) {
    foreach ( $students as $entry ) {
        $user_info = get_userdata($entry);
        $name = $user_info->first_name.' '.$user_info->last_name;
        $email = $user_info->user_email;
        $ins_id = (int) get_the_author_meta( 'instructor', $entry );
        $region =  get_the_author_meta( 'region', $entry );
        $curriculum = (int) get_the_author_meta( 'curriculum', $entry );
        $course = $wpdb->get_row("Select * from `ngondro_courses` where course_id = '$curriculum'");
        $args =  array(
            'post_type' => 'instructor',
            'posts_per_page'=> 1,
            'hide_empty' => true,
            'meta_key'=> 'instructor',
            'meta_value' =>	$ins_id					
        );
        $ins_post = get_posts($args)[0];
        $ins_post_id = $ins_post->ID;
        $ins_name = get_the_title($ins_post_id);

        $current_date = date('Y-m-d');
        $reg_date = date("Y-m-d", strtotime($user_info->data->user_registered));
        $begin = new DateTime( $current_date );
        $end   = new DateTime( $reg_date );
        $total_months = 0;
        //$begin = $begin->modify('-1 months');
        for($i = $begin; $i >= $end; $i->modify('-1 months')){
            $total_months++;
        }
        $cid = get_the_author_meta( 'curriculum', $entry->data->ID ); 
        $cid = ($cid=="")?1:$cid; 
        $uid  = $user_info->data->ID;
        $subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = ".$cid);
        $cols = "";
        foreach($subjects as $subject){
            $cols .= "SUM(".$subject->slug.") as ".$subject->slug." ,"; 
        }
        // $entries = $wpdb->get_results("SELECT user_id, $cols course_id, date_format(reporting_date, '%b %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " group by date_format(reporting_date, '%m-%Y')");
        // $missed_report_count = $total_months - count($entries);
        $missed_report_count = get_user_meta($uid, 'missed_last_report')[0];


        $data[] = [
            'id'            => $entry,
            'user_id'       => $entry,
            'name'          => $name,
            'missed'          => abs($missed_report_count),
            'email'         => $email,
            'region'        => $region,
            'curriculum'    => $course->title,
            'instructor'    => $ins_name,
        ];

    }
// }

?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />

<div id="layoutSidenav_content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 pt-6 pb-3">
                <h2 class="fw-bold"><?php echo __('No show students','ngondro_gar');?></h2>
                <!--<p>Students of Jens Jakob Leschly who have missed the last 12 or more reports. Exempt students are not listed. Total students : 43  </p>-->
            </div>
        </div>

        <!-- <div class="row student-tracking-filter mt-9 mb-2"> -->
            <!-- <div class="col-md-3 ">
                <div class="input-group mb-3">
                    <input type="text" class="form-control sname_input" placeholder="Student Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary sname_btn search_btn" data-class=".sname_input" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control semail_input" placeholder="Student Email" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary semail_btn search_btn" data-class=".semail_input" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div> -->
            <!--<div class="col-md-1">
                <div class="input-group mb-3">
                    <Select class="form-control">
                        <option value="">LNN</option>
                        <option value="">CNN</option>
                        <option value="">KMN</option>
                    </Select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="input-group mb-3">
                    <Select class="form-control">
                        <option value="">EN</option>
                        <option value="">CN</option>
                        <option value="">POR</option>
                    </Select>
                </div>
            </div>-->
            <!-- <div class="col">
                <div class="input-group mb-3">
                <select class="form-control1 dropdown_filter w-100 px-2" id="course_select">
                        <option value="all">Course</option>
                        <option value="2">LNN</option>
                        <option value="3">CNN</option>
                        <option value="4">KMN</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <Select class="form-control1 dropdown_filter w-100 px-2" id="language_select">
                        <option value="all">Language</option>
                        <option value="en">English</option>
                        <option value="zh-hant">繁體中文</option>
                        <option value="zh-hans">简体中文</option>
                        <option value="pt-br">Português</option>
                    </Select>
                </div>
            </div> -->
            <!-- <div class="col-md-3">
                <div class="input-group mb-3">
                    <div id="buttons"></div>
                </div>
            </div> -->
            <!--<div class="col-md-2">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">CSV</a></li>
                        <li><a class="dropdown-item" href="#">PDF</a></li>
                        <li><a class="dropdown-item" href="#">XLS</a></li>
                    </ul>
                </div>
            </div>
            -->
        <!-- </div> -->

        <div class="sidebar-inner-box">
            <div class="students-list">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover" id="no_show_report">
                                <thead>
                                    <th>NO.</th>
                                    <th>Name</th>
                                    <th>Missed Reports</th>
                                    <th>Exempt</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                <?php $index = 1;
                                 foreach($data as $student):
                                    $sid = $student['id'];
                                    $user_info = get_userdata($student['user_id']);
                                    $reg_date = date("Y-m-d", strtotime($user_info->data->user_registered));
                                    $current_date = date('Y-m-d');
                                    $d1 = new DateTime($reg_date);
                                    $d2 = new DateTime($current_date);
                                    $interval = $d2->diff($d1);
                                    $exempt = get_the_author_meta( 'exempt', $student['user_id'] );
                                    $exempt = ($exempt=="")?"No":$exempt;
                                    $cid = get_the_author_meta( 'curriculum', $student['user_id'] ); 
                                    $app_status = get_the_author_meta( 'ng_user_approve_status', $student['user_id'] );
                                    $no_show_missed_students = $student['missed'];
                                    if($no_show_missed_students >=12):
                                    ?>
                                    <tr data-sname="<?=strtolower($student['name'])?>" data-email="<?=strtolower($student['email'])?>" data-course="<?=$cid?>" class="noshowrow">
                                        <td><?=$index?></td>
                                        <td> <a class="student-link1 student-name-field" href="<?=site_url('/student?sid='.$sid)?>">
                                            <div class="student-name">     
                                        <?=$student['name']?></div></td>
                                        <td><?php echo $no_show_missed_students;?></td>
                                        <td><?=$exempt?></td>
                                        <td><?=$student['email']?></td>
                                        <td>
                                           <!-- <i class="far fa-eye-slash"></i> -->
                                            <?php if($app_status='' || $app_status=="approved"):?>
                                                <button type="button" class="btn btn-danger update_status" data-sid="<?=$student['user_id']?>" data-status="deactivate">Deactivate</button>
                                            <?php else:?>
                                                <button class="btn btn-success update_status" data-sid="<?=$student['user_id']?>" data-status="activate">Activate</button>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endif; $index++; endforeach;?>
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php get_footer() ?>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

<script>
    jQuery(document).ready( function () {
     /* Display No show tagle using datatables */
    var t = $('#no_show_report').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        "pageLength": 25,
        searching: true,
        buttons: [
        ],
        columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 },
            ],
        order: [[1, 'asc']],
        "language": {
            "paginate": {
            "previous": "Prev",
            'next': 'Next'
            }
        },
        language: {
                'paginate': {
                'previous': ajaxObj.previous,
                'next': ajaxObj.next
                }
            }
            
    });

    t.on('order.dt search.dt', function () {
        let i = 1;
        t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

    var buttons = new $.fn.dataTable.Buttons(t, {
     buttons: [
        {
            extend: 'csv',
            text: 'Export CSV',
            key: {
                key: 'p',
                altkey: true
            }
        }
        ]
    }).container().appendTo($('#no_show_report_wrapper .dt-buttons'));

    } );
</script>

<script>
/* user seach */
jQuery('.search_btn').on('click',function(){
    
    var classname = jQuery(this).attr('data-class');
    var input_val = jQuery(classname).val().toLowerCase();
    if( input_val != "" ){
        jQuery('#no_show_report .noshowrow').hide();
        if(classname==".sname_input"){
            var sname = jQuery('#no_show_report .noshowrow').attr('data-sname');
            jQuery(`#no_show_report tr[data-sname='${input_val}'`).show();
        }
        else{
            var semail = jQuery('#no_show_report .noshowrow').attr('data-semail');
            jQuery(`#no_show_report tr[data-email='${input_val}'`).show();
        }
    }
    else{
        jQuery(`#no_show_report tr`).show();
    }
   

})

// jQuery('.course_select').on('change',function(){
//     var cval = jQuery(this).val().toLowerCase();
//     jQuery('#no_show_report .noshowrow').hide();
//     jQuery(`#no_show_report tr[data-course='${cval}'`).show();

// })


/* Drownload Filters */

jQuery('.dropdown_filter').each(function(){
    jQuery(this).on('change', function(){
    const table = document.getElementById("student-table");
    // save all tr
    const tr = table.getElementsByTagName("tr");
    var course = document.getElementById("course_select").value;
    var language = document.getElementById("language_select").value;
    for (i = 1; i < tr.length; i++) {

        var rowCourse = tr[i].getAttribute("data-course");
        var rowLanguage = tr[i].getAttribute("data-language");

        var isDiplay = true;

        if (course != 'all' && rowCourse != course) {
        isDiplay = false;
        }
        if (language != 'all' && rowLanguage != language) {
        isDiplay = false;
        }
        if (isDiplay) {
        tr[i].style.display = "";
        } else {
        tr[i].style.display = "none";
        }
    }

});
});


// jQuery(document).on('click','.update_status',function(e){
//     let $this = jQuery(this);
//     let htmlval = $this.html();
//     $this.confirm({
//     buttons: {
//         hey: function(){
//             location.href = this.$target.attr('href');
//         }
//     }
//     });
//     $this.html('Saving...');
//     let newval = "Activate";
//     if(htmlval=="Deactivate"){newval="Activate"}else{newval="Deactivate";}

//     var data = {
//         'action': 'save_update_status_info',
//         'user': jQuery(this).attr('data-sid'),
//         'status': jQuery(this).attr('data-status'),
//     };
//     jQuery.ajax({
//         url: ajaxObj.ajaxurl,
//         method: 'POST',
//         data: data,
//         success:function(data) {
//             $this.html(newval);
//             const myTimeout = setTimeout(function(){
//                 $this.html(newval);
//                 if(newval=='Activate'){
//                     $this.removeClass('btn-danger').addClass('btn-success');
//                 }
//                 else{
//                     $this.removeClass('btn-success').addClass('btn-danger');
//                 }
                
//             }, 2000);
//         },
//         error: function(errorThrown){
//             console.log(errorThrown);
//         }
//     });
// });


</script>
