<?php

/**
 * Template Name: Mail Students

 */

get_header('loggedin');


    // echo "</pre>";
    



$students = get_users(
    array(
        'role' => 'student',
        'number' => 50,
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

// echo "<pre>";
// print_r($students);
// echo "</pre>";
if($students){
foreach($students as $list){
    $mail_lists[] = $list->data->user_email;
}
$all_mail_student = implode(',',$mail_lists);
}
// var_dump($all_mail_student);


if(count($students) == 50){
 
    $students2 = get_users(
        array(
            'role' => 'student',
            'number' => 50,
            'offset' => 50,
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
    
    // echo "<pre>";
    // print_r($students);
    // echo "</pre>";
    if($students2){
        foreach($students2 as $list2){
            $mail_lists2[] = $list2->data->user_email;
        }
        $all_mail_student2 = implode(',',$mail_lists2);
        // var_dump($all_mail_student);
    }
}

if($students2){
if(count($students2) == 50){
 
        $students3 = get_users(
            array(
                'role' => 'student',
                'number' => 50,
                'offset' => 100,
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
        
        // echo "<pre>";
        // print_r($students);
        // echo "</pre>";
        if($students3){
            foreach($students3 as $list3){
                $mail_lists3[] = $list3->data->user_email;
            }
            $all_mail_student3 = implode(',',$mail_lists3);
            // var_dump($all_mail_student);
            }
    }
}

?>
<style>
.multi-select {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.new {
    background-color: #a04b5d !important;
    border-color: #a04b5d !important;
    color: white !important;
}
.rdm-btn{
    background: #BD5D72;
    border: none;
}
</style>

<?php
if(isset($_POST['mail-submit'])){

    $user_id = get_current_user_id();
    $user = get_userdata($user_id);
    $email = $user->user_email;

    $msg = $_POST['message'];
    $subject = $_POST['subject'];
    $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
    $headers[] = "X-Mailer: PHP \r\n";
    $headers[] = 'From: NGONDRO GAR < '.$email.'>'. "\r\n";
    $message = $msg;

    $mail_students = $_POST['mail_students'];
    foreach($mail_students as $to){
        $to = $to;
        // print_r($email);
    
    $sendmail = wp_mail($to, $subject, $message, $headers);
    if($sendmail){
        echo "<script>
        alert('Mail sent successfully');
        window.location.href = window.location.href;
        </script>";
    }else{
        echo "<script>
        alert('Mail not sent successfully');
        window.location.href = window.location.href;
        </script>";
    }

    }
    
}
?>
<!-- <textarea class="form-control" name="message" id="message" rows="3"></textarea> -->
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

                                <h6 class="fw-bold mb-0 fs-23"><?php echo __('Send Mail to  Students','ngondro_gar');?></h6>
                                
                            </div>
                        </div>

                        <div class="">

                        <?php 
                        
                        $new_data = get_users(
                            array(
                                'role' => 'student',
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
                        $total = count($new_data);
                        $list_count = ceil($total/2);
                        $offset = 50;
                        
                        
                        
                        for ($i=0; $i < $list_count ; $i++) { 
                            $my_data = get_users(
                                array(
                                    'role' => 'student',
                                    'number' => 50,
                                    'offset' => $offset * $i,
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
                        
                            
                            foreach($my_data as $new_list){
                                    $my_lists[$i][] = $new_list->data->user_email;
                                }
                        
                        
                        }
                        
                        
                            //echo "<pre>";
                            $j=1;
                            $k=50;
                            foreach($my_lists as $stud_list){
                            $last_list_students = implode(',',$stud_list);
                            // var_dump($last_list_students);
                            
                             echo '<a href="mailto:?bcc='.$last_list_students.'" class="btn btn-success mx-1 my-1 rdm-btn" >'.$j.' to '.$k.' Students</a><br>';
                                    $j+=50;
                                    $k+=50;
                            }
                        
                            
                            
                        ?>


                        <!-- <a href="mailto:<?php echo $all_mail_student ?>" class="btn btn-success mx-1 my-1 rdm-btn" >1 to 50 students </a>

                    <br>
                    <?php if($all_mail_student2){ ?>
                        <a href="mailto:<?php echo $all_mail_student2 ? $all_mail_student2 : '' ?>" class="btn btn-success mx-1 my-1 rdm-btn" <?php echo $all_mail_student2 ? '' : 'style="pointer-events: none; background: #6ab190; border: none;"' ?>>51 to 100 students </a>
                       <br>
                       <?php } ?>
                        
                       <?php if($all_mail_student3){ ?>
                        <a href="mailto:<?php echo $all_mail_student3 ? $all_mail_student3 : '' ?>" class="btn btn-success mx-1 my-1 rdm-btn" <?php echo $all_mail_student2 ? '' : 'style="pointer-events: none; background: #6ab190; border: none;"' ?>>101 to 150 students </a>
                        <br>
                        <?php } ?> -->
                        </div>


                        <!-- <div>
                            <form method="post">

                                
                                <div class="form-group">
                                    <label for="message">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject">
                                </div>
                                <div class="form-group my-2">
                                    <label for="message">Message</label>
                                    <?php
                                    wp_editor( stripslashes('') , 'ebody', array(
                                        'wpautop'       => true,
                                        'media_buttons' => false,
                                        'textarea_name' => 'message',
                                        'editor_class'  => 'ebody',
                                        'textarea_rows' => 10
                                    ));
                                    ?>
                                    
                                </div>

                                <div class="">
                                    <label for="students">Select Students</label>
                                    <select class="multi-select" id="students" name="mail_students[]" multiple>

                                        <?php if($students != null || $students != ''){ foreach($students as $stud): ?>
                                        <option value="<?=$stud->data->user_email; ?>"><?=$stud->data->display_name; ?>
                                        </option>

                                        <?php endforeach; }else{ ?>
                                        <option value="">No Students present</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" name="mail-submit"
                                        class="btn btn-info btn-sm my-2 new">Submit</button>
                                </div>
                            </form>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php  get_footer(); ?>
</div>