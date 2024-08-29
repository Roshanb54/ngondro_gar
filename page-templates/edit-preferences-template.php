<?php 
/**
 * Template Name: Edit Preferences Page
 * @desc Edit user preferences/password/profile
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @returns {get_the_author_meta()} [Value] Return meta value of the given user based on meta key
 * @returns {get_the_title()} [Value] Return the title of the given page/post ID
 * @returns {get_field()} [Value] Return the field value of the given ACF field ID
 * @returns {get_posts()} [Array] Return the all posts 
 * @function {edit_preferences_request} send request to change the course/instructor
 * @function {wp_safe_redirect} Performs a safe (local) redirect
 *  @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */

if(!is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}

get_header('loggedin');
global $wpdb;
$user = wp_get_current_user();
$user_meta = get_user_meta(get_current_user_id());
$ins_id = (int) get_the_author_meta( 'instructor', get_current_user_id() );
$my_current_lang = apply_filters( 'wpml_current_language', NULL );

?>
    <div id="layoutSidenav_content">
        <section class="edit-preferences-wrapper mt-10">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <ul class="nav nav-tabs profile-tabs">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="<?php echo home_url('/edit-profile/');?>"><?php echo __('Edit Profile','ngondro_gar');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo home_url('/change-password/');?>"><?php echo __('Change Password','ngondro_gar');?></a>
                            </li>
                            <?php if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo home_url('/edit-preferences/');?>"><?php echo __('Edit Preferences','ngondro_gar');?></a>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                    <div class="col-lg-10 offset-lg-1">
                        <div class="edit-preferences-box-wrapper">
                            <div class="">
                                <?php
                                /* Request to change the course */
                                $username = $user->display_name;
                                $useremail = $user->user_email;
                                if(isset($_POST['change_course'])){
                                    $course = $_POST['choose_course'];
                                    $new_course_id = $course;
                                    $get_course_title = $wpdb->get_row("Select * from ngondro_courses where course_id = '$course'");
                                    $course = $get_course_title->title;
                                    $reason = $_POST['your_reason_for_course'];
                                    $subject = "Make a request to change the course";
                                    $msg = "<h2>Request to change the course</h2>";
                                    $msg .= "<p>Requested Course:$course</p></br>";
                                    $msg .= "<p>Reason:$reason</p></br>";
                                    $msg .= "<p>Name: $username <br></p>";
                                    $msg .= "<p>Email: $useremail <br></p>";
                                    edit_preferences_request(get_current_user_id(), $subject, $msg, $ins_id);
                                    echo __("<p class='alert alert-success'> Request submitted successfully!</p>",'ngondro_gar');

                                    $curriculum = get_the_author_meta( 'curriculum', get_current_user_id() );
                                    $data['user_id'] = get_current_user_id();
                                    $data['change_from'] = $curriculum;
                                    $data['change_to'] = $new_course_id;
                                    $data['type'] = "course";
                                    $data['reason'] = $reason;
                                    $data['date'] = date('Y-m-d');
                                    $wpdb->insert('ngondro_request', $data);

                                }

                                 /* Request to change the instructor */
                                if(isset($_POST['choose_instructor'])){
                                    $inst = $_POST['choose_instructor'];
                                    $new_inst_post_id = $inst;                                  
                                    $inst = get_the_title($inst);
                                    
                                    $old_ins_id = (int) get_the_author_meta( 'instructor', get_current_user_id() );
                                    $old_inst_data = get_user_by( 'id', $old_ins_id );
                                    $old_inst_name = $old_inst_data->data->display_name;
                                    $old_inst_email = $old_inst_data->data->user_email;
                                    
                                    $u_data = get_user_by( 'id', $new_inst_post_id );
                                    $new_inst_name = $u_data->data->display_name;
                                    $new_inst_email = $u_data->data->user_email;
									
                                    // var_dump( $old_inst_email);
                                
                                    $reason = $_POST['your_reason_for_instructor'];
                                    $subject = "Make a request to change the instructor";
                                    
                                    // English
                                    $message = "<p>Student has requested to change Instructor from ".$old_inst_name." to ".$new_inst_name."</p><br><br>";
                                    $message .= "<p>Student Details</p>";
                                    $message .= "<p>Name: ".$username." <br><br>Reason: ".$reason."<br><br>Email: ".$useremail."</p><br><br>";
                                    
                                    // Spanish
                                    $message .= "<p>El estudiante ha solicitado cambiar de Instructor de ".$old_inst_name." a ".$new_inst_name."</p><br><br>";
                                    $message .= "<p>Datos del alumno</p>";
                                    $message .= "<p>Nombre: ".$username." <br><br>Motivo: ".$reason."<br><br>Correo electrónico: ".$useremail."</p><br><br>";

                                    // Spanish
                                    $message .= "<p>O aluno solicitou a mudança do instrutor do ".$old_inst_name." para o ".$new_inst_name."</p><br><br>";
                                    $message .= "<p>Informações do aluno</p>";
                                    $message .= "<p>Nome: ".$username." <br><br>Motivo: ".$reason."<br><br>E-mail: ".$useremail."</p><br><br>";

                                    // Chinese
                                    $message .= "<p>學員申請更換指導老師:從 ".$old_inst_name." 換為 ".$new_inst_name."</p><br><br>";
                                    $message .= "<p>學員資料</p>";
                                    $message .= "<p>姓名: ".$username." <br><br>原因: ".$reason."<br><br>郵箱: ".$useremail."</p><br><br>";

                                   
                                    $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
                                    $headers[] = "X-Mailer: PHP \r\n";
                                    $headers[] = 'From: NGONDRO GAR < '.get_option( 'admin_email' ).'>' . "\r\n";

                                    $headers_new[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
                                    $headers_new[] = "X-Mailer: PHP \r\n";
                                    $headers_new[] = 'From: NGONDRO GAR < '.get_option( 'admin_email' ).'>' . "\r\n";
                                    
                                    wp_mail($old_inst_email,$subject, $message, $headers);
                                    wp_mail($new_inst_email,$subject, $message, $headers_new);
                                    
                                    //edit_preferences_request(get_current_user_id(), $subject, $msg);
                                    echo __("<p class='alert alert-success'> Request submitted successfully!</p>",'ngondro_gar');

                                    $ins_id = (int) get_the_author_meta( 'instructor', get_current_user_id() );
                                    $data['user_id'] = get_current_user_id();
                                    $data['change_from'] = $ins_id;
                                    $data['change_to'] = $new_inst_post_id;
                                    $data['type'] = "ins";
                                    $data['reason'] = $reason;
                                    $data['date'] = date('Y-m-d');
                                    $wpdb->insert('ngondro_request', $data);
                                }

                                 /* Update Preference details */
                                if(isset($_POST['edit_preferences'])){
                                    $user_id  = $_POST['edit_user_id'];
                                    update_user_meta( $user_id, 'track',  $_POST['track'] );
                                    update_user_meta( $user_id, 'language',  $_POST['choose_language'] );
                                    $user_language = $_POST['choose_language'];
                                    echo __("<p class='alert alert-success'> Preference updated successfully!<span id='redirect-text' style='display:none;font-size:12px;'>This page will be switched to the selected language in <span id='time'>5</span> sec</span></span></p>",'ngondro_gar');
                                    if($my_current_lang == 'pt-pt'){
                                        $check_language = 'pt-br';
                                    }
                                    else {
                                        $check_language = $my_current_lang;
                                    }
                                    if($user_language !== $check_language){
                                        if($user_language == 'zh-hant'){
                                            echo '<script>
                                            let p = document.getElementById("redirect-text");
                                            p.style.display = "block";
                                            //var time = 5;
                                            var timeleft = 5;
                                            var downloadTimer = setInterval(function(){
                                            if(timeleft <= 0){
                                                clearInterval(downloadTimer);
                                                document.getElementById("time").innerHTML = "0";
                                                window.location.href = "'.site_url('/zh-hant/編輯首選項/').'";
                                            } else {
                                                document.getElementById("time").innerHTML = timeleft;
                                            }
                                            timeleft -= 1;
                                            }, 1000);
                                            </script>';
                                        }elseif($user_language == 'zh-hans'){
                                            echo '<script>
                                            let p = document.getElementById("redirect-text");
                                            p.style.display = "block";
                                            //var time = 5;
                                            var timeleft = 5;
                                            var downloadTimer = setInterval(function(){
                                            if(timeleft <= 0){
                                                clearInterval(downloadTimer);
                                                document.getElementById("time").innerHTML = "0";
                                                window.location.href = "'.site_url('/zh-hans/编辑首选项/').'";
                                            } else {
                                                document.getElementById("time").innerHTML = timeleft;
                                            }
                                            timeleft -= 1;
                                            }, 1000);
                                            </script>';
                                            
                                            
                                        }elseif($user_language == 'pt-br'){
                                            echo '<script>
                                            let p = document.getElementById("redirect-text");
                                            p.style.display = "block";
                                            //var time = 5;
                                            var timeleft = 5;
                                            var downloadTimer = setInterval(function(){
                                            if(timeleft <= 0){
                                                clearInterval(downloadTimer);
                                                document.getElementById("time").innerHTML = "0";
                                                window.location.href = "'.site_url('/pt-pt/edite-preferencias/').'";
                                            } else {
                                                document.getElementById("time").innerHTML = timeleft;
                                            }
                                            timeleft -= 1;
                                            }, 1000);
                                            </script>';
                                        }elseif($user_language == 'es'){
                                            echo '<script>
                                            let p = document.getElementById("redirect-text");
                                            p.style.display = "block";
                                            // var time = 5;
                                            var timeleft = 5;
                                            var downloadTimer = setInterval(function(){
                                            if(timeleft <= 0){
                                                clearInterval(downloadTimer);
                                                document.getElementById("time").innerHTML = "0";
                                                window.location.href = "'.site_url('/es/editar-preferencias/').'";
                                            } else {
                                                document.getElementById("time").innerHTML = timeleft;
                                            }
                                            timeleft -= 1;
                                            }, 1000);
                                            </script>';
                                        }
                                        else{
                                            echo '<script>
                                            let p = document.getElementById("redirect-text");
                                            p.style.display = "block";
                                            var timeleft = 5;
                                            var downloadTimer = setInterval(function(){
                                            if(timeleft <= 0){
                                                clearInterval(downloadTimer);
                                                document.getElementById("time").innerHTML = "0";
                                                window.location.href = "'.site_url('/edit-preferences/').'";
                                            } else {
                                                document.getElementById("time").innerHTML = timeleft;
                                            }
                                            timeleft -= 1;
                                            }, 1000);
                                            </script>';
                                        }
                                        
                                    };
                                    
                                }

                                function edit_preferences_request( $user_id , $subject, $message,$ins_id)
                                {
                                    $email = get_bloginfo( 'admin_email' );
                                    //$email = "user@getnada.com";
                                    $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
                                    $headers[] = "X-Mailer: PHP \r\n";
                                    $headers[] = 'From: NGONDRO GAR < '.get_option( 'admin_email' ).'>' . "\r\n";
                                    wp_mail($email,$subject, $message, $headers);
                                }
                                $user_meta = get_user_meta(get_current_user_id());

                                ?>

                            </div>
                            <div class="edit-preferences-inner-box">

                                <div class="make-requests-table-wrapper common-form-style">
                                    <h2><?php echo __('Edit Preferences','ngondro_gar');?></h2>
                                    <p><?php echo __('You will have to make a request to change the instructor and the current curriculum that you are
                                        enrolled in.','ngondro_gar');?></p>

                                    <div class="row d-block d-md-none">
                                        <h6><?php echo __('Enrolled course:','ngondro_gar');?></h6>
                                        <div class="your-course-column d-flex justify-content-between">
                                            <?php $curriculum = get_the_author_meta( 'curriculum', get_current_user_id() );?>
                                            <div class="course-name">
                                                <?php $courses = $wpdb->get_row("Select * from ngondro_courses where course_id = $curriculum");
                                                if($courses){ echo __($courses->title, 'ngondro_gar');}
                                                ?>
                                            </div> <a id="make_course_request" href="#"><?php echo __('Request change','ngondro_gar');?></a>
                                        </div>

                                        <div class="course-request-form-wrapper">
                                            <form class="mt-3 pt-3 border-top" method="post">
                                                <div class="form-group mb-4">
                                                    <label for="choose_course"><?php echo __('Select a course ','ngondro_gar');?><span style="color:#BD5D72">*</span></label>
                                                    <select id="choose_course" name="choose_course" class="form-control form-select" aria-invalid="false" required>
                                                    <option value="" disabled selected><?php echo __('Select a course','ngondro_gar');?></option>
                                                        <?php
                                                        $courses = $wpdb->get_results("Select * from ngondro_courses");
                                                        $index = 1;
                                                        foreach($courses as $term):
                                                            $checked = ($index==1)?"selected":"";
                                                            if ($term->course_id != $curriculum):
                                                            ?>
                                                            <option value="<?=$term->course_id?>" <?php echo ($curriculum == $term->course_id)? 'checked="checked"' : '';?>> <?php echo __($term->title,'ngondro_gar');?></option>
                                                            <?php endif; $index++; endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="your_reason_for_course"><?php echo __('Your reason ','ngondro_gar');?><span style="color:#BD5D72">*</span></label>
                                                    <textarea class="form-control" name="your_reason_for_course" maxlength="500" id="your_reason_for_course" placeholder="Your Reason" rows="4"></textarea>
                                                </div>
                                                <div class="form-buttons-wrapper mt-5 mb-5">
                                                    <button class="btn btn-lg btn-default me-4 disabled" name="change_course" type="submit" ><?php echo __('Send Request','ngondro_gar');?></button>
                                                    <button class="btn btn-lg btn-tranparent" id="change_course_cancel" name="change_course_cancel" type="submit"><?php echo __('Cancel','ngondro_gar');?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row d-block d-md-none mt-5">
                                        <div class="instructor-name-image d-flex justify-content-between">
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
                                            $ins_name = get_the_title($ins_post_id);
                                            ?>
                                            <div class="instructor-name"><img src="<?=$ins_image?>" alt="instructor name"> <?=$ins_name?></div>
                                            <a id="make_instructor_request" href="#"><?php echo __('Request change','ngondro_gar');?></a>
                                        </div>
                                        <div class="instructor-request-form-wrapper">
                                            <form class="mt-3 pt-3 border-top" method="POST" action="">
                                                <div class="form-group mb-4">
                                                    <label for="choose_instructor"><?php echo __('Select a Instructor','ngondro_gar');?> <span style="color:#BD5D72">*</span></label>
                                                    <?php
                                                    $type = "instructor";
                                                    $instructors = new WP_Query(
                                                        array(
                                                            'post_type' => $type,
                                                            'posts_per_page'=> -1,
                                                            'orderby' => 'date',
                                                            'hide_empty' => true,
                                                            'order' => 'ASC',
                                                            'post_status' => 'publish',
                                                        )
                                                    );
                                                    $instructors = get_users(array('role__in' => array('instructor')));

                                                    ?>
                                                    <select id="choose_instructor" name="choose_instructor" class="form-control form-select" aria-invalid="false" required>
                                                    <option value="" disabled selected><?php echo __('Select a Instructor','ngondro_gar');?></option>
                                                        <?php if($instructors) :
                                                            foreach ($instructors as $user):
                                                                if ($user->ID != $ins_id):
                                                            ?>
                                                                <option value="<?= $user->ID ?>" <?php echo ($user->data->ID == $ins_id) ? 'selected="selected"' : ''; ?>> <?= $user->data->display_name . '(' . $user->data->user_email . ')'; ?></option>
                                                            <?php endif; endforeach; endif;?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="your_reason_for_instructor"><?php echo __('Your reason','ngondro_gar');?> <span style="color:#BD5D72">*</span></label>
                                                    <textarea class="form-control" name="your_reason_for_instructor" maxlength="500" id="your_reason_for_instructor" placeholder="Your Reason" rows="4"></textarea>
                                                </div>
                                                <div class="form-buttons-wrapper mt-5 mb-5">
                                                    <button class="btn btn-lg btn-default me-4 disabled" name="change_instructor" type="submit"><?php echo __('Send Request','ngondro_gar');?></button>
                                                    <button class="btn btn-lg btn-tranparent" id="change_instructor_cancel" name="change_course_cancel" type="submit"><?php echo __('Cancel','ngondro_gar');?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <table class="table table-borderless mb-0 d-none d-md-block">
                                        <tbody>
                                        <tr>
                                            <th scope="row"><?php echo __('Enrolled course:','ngondro_gar');?></th>
                                            <td>
                                                <div class="your-course-column d-flex justify-content-between">
                                                    <?php $curriculum = get_the_author_meta( 'curriculum', get_current_user_id() );?>
                                                    <div class="course-name">
                                                        <?php $courses = $wpdb->get_row("Select * from ngondro_courses where course_id = $curriculum");
                                                        if($courses){ echo __($courses->title,'ngondro_gar');}
                                                        ?>
                                                    </div> <!--<a id="make_course_request" href="#">Request change</a>-->
                                                </div>
                                                <div class="course-request-form-wrapper">
                                                    <form class="mt-3 pt-3 border-top" method="post">
                                                        <div class="form-group mb-4">
                                                            <label for="choose_course"><?php echo __('Select a course ','ngondro_gar');?><span style="color:#BD5D72">*</span></label>
                                                            <select id="choose_course" name="choose_course" class="form-control form-select" aria-invalid="false" required>
                                                            <option value="" disabled selected><?php echo __('Select a course','ngondro_gar');?></option>
                                                                <?php
                                                                $courses = $wpdb->get_results("Select * from ngondro_courses");
                                                                $index = 1;
                                                                foreach($courses as $term):
                                                                    $checked = ($index==1)?"selected":"";
                                                                    if ($term->course_id != $curriculum):
                                                                    ?>
                                                                    <option value="<?=$term->course_id?>" <?php echo ($curriculum == $term->course_id)? 'checked="checked"' : '';?>> <?php echo __($term->title,'ngondro_gar');?></option>
                                                                    <?php endif; $index++; endforeach;?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="your_reason_for_course"><?php echo __('Your reason ','ngondro_gar');?><span style="color:#BD5D72">*</span></label>
                                                            <textarea class="form-control" name="your_reason_for_course" maxlength="500" id="your_reason_for_course" placeholder="Your Reason" rows="4"></textarea>
                                                        </div>
                                                        <div class="form-buttons-wrapper mt-5 mb-5">
                                                            <button class="btn btn-lg btn-default me-4 disabled" name="change_course" type="submit"><?php echo __('Send Request','ngondro_gar');?></button>
                                                            <button class="btn btn-lg btn-tranparent" id="change_course_cancel" name="change_course_cancel" type="submit"><?php echo __('Cancel','ngondro_gar');?></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                <a id="make_course_request" href="#"><?php echo __('Request change','ngondro_gar');?></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><?php echo __('Instructor:','ngondro_gar');?></th>
                                            <td>
                                                <div class="instructor-name-image d-flex justify-content-between">
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
                                                    $ins_name = get_the_title($ins_post_id);
                                                    ?>
                                                    <div class="instructor-name"><img src="<?=$ins_image?>" alt="instructor name"> <?=$ins_name?></div>
                                                </div>
                                                <div class="instructor-request-form-wrapper">
                                                    <form class="mt-3 pt-3 border-top" method="POST" action="">
                                                        <div class="form-group mb-4">
                                                            <label for="choose_instructor"><?php echo __('Select a Instructor','ngondro_gar');?> <span style="color:#BD5D72">*</span></label>
                                                            <?php
                                                            $type = "instructor";
                                                            $instructors = new WP_Query(
                                                                array(
                                                                    'post_type' => $type,
                                                                    'posts_per_page'=> -1,
                                                                    'orderby' => 'date',
                                                                    'hide_empty' => true,
                                                                    'order' => 'ASC',
                                                                    'post_status' => 'publish',
                                                                )
                                                            );

                                                            $instructors = get_users(array('role__in' => array('instructor')));
                                                            
                                                            ?>

                                                            <select id="choose_instructor" name="choose_instructor" class="form-control form-select" aria-invalid="false" required>
                                                            <option value="" disabled selected><?php echo __('Select a Instructor','ngondro_gar');?></option>
                                                                <?php if($instructors) :
                                                                    foreach ($instructors as $user):
                                                                        if ($user->ID !== $ins_id):
                                                                    ?>
                                                                        <option value="<?= $user->ID ?>" <?php echo ($user->data->ID == $ins_id) ? 'selected="selected"' : ''; ?>> <?= $user->data->display_name . '(' . $user->data->user_email . ')'; ?></option>
                                                                    <?php endif; endforeach; endif;?>
                                                            </select>

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="your_reason_for_instructor"><?php echo __('Your reason ','ngondro_gar');?><span style="color:#BD5D72">*</span></label>
                                                            <textarea class="form-control" name="your_reason_for_instructor" maxlength="500" id="your_reason_for_instructor" placeholder="Your Reason" rows="4"></textarea>
                                                        </div>
                                                        <div class="form-buttons-wrapper mt-5 mb-5">
                                                            <button class="btn btn-lg btn-default me-4 disabled" name="change_instructor" type="submit"><?php echo __('Send Request','ngondro_gar');?></button>
                                                            <button class="btn btn-lg btn-tranparent" id="change_instructor_cancel" name="change_course_cancel" type="submit"><?php echo __('Cancel','ngondro_gar');?></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                <a id="make_instructor_request" href="#"><?php echo __('Request change','ngondro_gar');?></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-block d-md-none">
                                <form method="POST" action="">
                                    <div class="edit-preferences-table-wrapper common-form-style mt-10">
                                        <?php $track = $user_meta['track'][0];
                                        $language = $user_meta['language'][0];
                                        ?>
                                        <div class="row">
                                            <div class="form-row edit-preference-practice-hours-wrapper">
                                                <label for=""><?php echo __('Practice hours (per day):','ngondro_gar');?></label>
                                                <div class="edit-preference-practice-hours">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="track05">
                                                        <input class="form-check-input" id="track05" type="radio" name="track" id="" value="0.5" <?php echo ($track=="0.5")?"checked":""?>>
                                                        <span></span>
                                                        0.5 hr</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="track1">
                                                        <input class="form-check-input" id="track1" type="radio" name="track" id="" value="1" <?php echo ($track=="1")?"checked":""?>>
                                                        <span></span>
                                                        1 hr</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="track15">
                                                        <input class="form-check-input" id="track15" type="radio" name="track" id="" value="1.5" <?php echo ($track=="1.5")?"checked":""?>>
                                                        <span></span>
                                                        1.5 hrs</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="track2">
                                                        <input class="form-check-input" id="track2" type="radio" name="track" id="" value="2" <?php echo ($track=="2")?"checked":""?>>
                                                        <span></span>
                                                        2 hrs
                                                    </label>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="form-row mt-5">
                                                <label for=""><?php echo __('Language:','ngondro_gar');?></label>
                                                <select id="choose_language" name="choose_language" class="form-control form-select" aria-invalid="false" required>
                                                    <option value="en" <?php echo ($language=="en")?"selected":""?>>English</option>
                                                    <option value="zh-hant" <?php echo ($language=="zh-hant")?"selected":""?>>繁體中文</option>
                                                    <option value="zh-hans" <?php echo ($language=="zh-hans")?"selected":""?>>简体中文</option>
                                                    <option value="pt-br" <?php echo ($language=="pt-br")?"selected":""?>>Português</option>
                                                    <option value="es" <?php echo ($language=="es")?"selected":""?>>Spanish</option>
                                                </select>
                                            </div>
                                            <div class="form-row mt-5">
                                                <label for=""><?php echo __('Personal contact form :','ngondro_gar');?></label>
                                                <label for="contact_form_enable">
                                                    <input type="checkbox" id="contact_form_enable" name="contact_form_enable" checked>
                                                    <span></span>
                                                </label>
                                                <p style="font-size:13px;color:rgba(39, 39, 39, 0.86);"><?php echo __('Allow other users to contact you via a personal contact form which keeps your e-mail address hidden. Adminis are still able to contact you even if you choose to disable this feature.','ngondro_gar');?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-buttons-wrapper mt-7">
                                        <input type="hidden" name="edit_user_id" value="<?=get_current_user_id();?>">
                                        <button class="btn btn-lg btn-default me-4" name="edit_preferences" type="submit"><?php echo __('Save','ngondro_gar');?></button>
                                        <a href="<?php echo home_url('/your-profile/');?>" class="btn btn-lg btn-tranparent" name="edit_preferences_cancel" type="submit"><?php echo __('Cancel','ngondro_gar');?></a>
                                    </div>
                                </form>
                                </div>
                                <div class="d-none d-md-block">
                                <form method="POST" action="">
                                    <div class="edit-preferences-table-wrapper common-form-style mt-10">
                                        <?php $track = $user_meta['track'][0];
                                        $language = $user_meta['language'][0];
                                        ?>
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row"><?php echo __('Practice hours (per day):','ngondro_gar');?> </th>
                                                <td class="d-flex justify-content-between">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="p-track05">
                                                            <input class="form-check-input" id="p-track05" type="radio" name="track" value="0.5" <?php echo ($track=="0.5")?"checked":""?>>
                                                            <span></span>
                                                            0.5 hr</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="p-track1">
                                                            <input class="form-check-input" id="p-track1" type="radio" name="track" value="1" <?php echo ($track=="1")?"checked":""?>>
                                                            <span></span>
                                                            1 hr</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="p-track15">
                                                            <input class="form-check-input" id="p-track15" type="radio" name="track" value="1.5" <?php echo ($track=="1.5")?"checked":""?>>
                                                            <span></span>
                                                            1.5 hrs</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="p-track2">
                                                            <input class="form-check-input" id="p-track2" type="radio" name="track" value="2" <?php echo ($track=="2")?"checked":""?>>
                                                            <span></span>
                                                            2 hrs
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('Language :','ngondro_gar');?></th>
                                                <td>
                                                    <select id="choose_language" name="choose_language" class="form-control form-select w-50" aria-invalid="false">
                                                        <option value="en" <?php echo ($language=="en")?"selected":""?>>English</option>
                                                        <option value="zh-hant" <?php echo ($language=="zh-hant")?"selected":""?>>繁體中文</option>
                                                        <option value="zh-hans" <?php echo ($language=="zh-hans")?"selected":""?>>简体中文</option>
                                                        <option value="pt-br" <?php echo ($language=="pt-br")?"selected":""?>>Português</option>
                                                        <option value="es" <?php echo ($language=="es")?"selected":""?>>Spanish</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-buttons-wrapper mt-7">
                                        <input type="hidden" name="edit_user_id" value="<?=get_current_user_id();?>">
                                        <button class="btn btn-lg btn-default me-4" name="edit_preferences" type="submit"><?php echo __('Save','ngondro_gar');?></button>
                                        <a href="<?php echo home_url('/your-profile/');?>" class="btn btn-lg btn-tranparent" name="edit_preferences_cancel" type="submit"><?php echo __('Cancel','ngondro_gar');?></a>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php get_footer();?>

    </div>
