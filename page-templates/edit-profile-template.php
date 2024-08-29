<?php 
/**
 * Template Name: Edit Profile Page
 * @desc Edit user preferences/password/profile
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @returns {get_the_author_meta()} [Value] Return meta value of the given user based on meta key
 * @returns {get_the_title()} [Value] Return the title of the given page/post ID
 * @returns {get_field()} [Value] Return the field value of the given ACF field ID
 * @returns {get_posts()} [Array] Return the all posts 
 * @function {edit_preferences_request} send request to change the course/instructor
 * @function {wp_safe_redirect} Performs a safe (local) redirect
 * @params {countries} [Array] Countries array
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */

 if(!is_user_logged_in()) {
    if(isset( $_GET['newuseremail'])){
        $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        wp_redirect(wp_login_url($actual_link));
        exit();
    }
    else {
        wp_redirect( home_url() );
        exit();
    }
}
$user = wp_get_current_user();
$user_id  = $_POST['edit_user_id']; 
$user_language = get_user_meta($user->ID, 'language', true);
if ( isset( $_GET['newuseremail'] ) && $user->ID ) {
	$new_email = get_user_meta( $user->ID, '_new_email', true );
	if ( $new_email && hash_equals( $new_email['hash'], $_GET['newuseremail'] ) ) {
        $args = array(
            'ID'         => $user->ID,
            'user_email' => esc_html( trim( $new_email['newemail'] ) )
        );
		wp_update_user( $args );
		delete_user_meta( $user->ID, '_new_email' );
		wp_redirect( add_query_arg( array( 'updated' => 'true' ),  esc_url(home_url('/edit-profile/'))));
		die();
	} else {
		wp_redirect( add_query_arg( array( 'error' => 'new-email' ), esc_url(home_url('/edit-profile/')))) ;
	}
}
elseif ( !empty( $_GET['dismiss'] ) && $user->ID . '_new_email' == $_GET['dismiss'] ) {
    delete_user_meta( $user->ID, '_new_email' );
    wp_redirect( add_query_arg( array('updated' => 'true'), esc_url(home_url('/edit-profile/')) ) );
    die();
}
get_header('loggedin');
global $wpdb;
?>
    <div id="layoutSidenav_content">
        <section class="edit-user-profile-wrapper mt-10">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <ul class="nav nav-tabs profile-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php echo home_url('/edit-profile/');?>"><?php echo __('Edit Profile','ngondro_gar');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo home_url('/change-password/');?>"><?php echo __('Change Password','ngondro_gar');?></a>
                            </li>
                            <?php if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo home_url('/edit-preferences/');?>"><?php echo __('Edit Preferences','ngondro_gar');?></a>
                                </li>
                            <?php }?>
                        </ul>
                        <!--<div class="left-sidebar-wrapper" id="left-sidebar">
                            <h3 class="sidebar-title">Account Setting</h3>
                            <div class="account-setting-box-wrapper">
                                <ul class="d-flex justify-content-between">
                                    <li class="active"><a href="<?php /*echo home_url('/edit-profile/');*/?>">Edit Profile</a></li>
                                    <li><a href="<?php /*echo home_url('/change-password/');*/?>">Change Password</a></li>
                                    <li><a href="<?php /*echo home_url('/edit-preferences/');*/?>">Edit Preferences</a></li>
                                </ul>
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="edit-profile-details-box-wrapper">
                            <div>
                                <?php
                                /*Edit/update user profile information*/
                                if(isset($_GET['updated'])){
                                    echo __("<p class='alert alert-success'> Your email address updated successfully!</p>",'ngondro_gar');
                                }
                                if(isset($_POST['edit_profile'])){

                                    if(in_array( 'instructor', (array) $user->roles ) ){ 
                                        $args =  array(
                                            'post_type' => 'instructor',
                                            'posts_per_page'=> 1,
                                            'hide_empty' => true,
                                            'meta_key'=> 'instructor',
                                            'meta_value' =>get_current_user_id()
                                        );
                                        $ins_post = get_posts($args)[0];
                                        $ins_post_id = $ins_post->ID;
                                        $ins_name = get_the_title($ins_post_id);
                                        $bio_content = $ins_post->post_content;
                                    }                                
                                
                                    if($_POST['edit_email'] != $user->user_email){        
                                    if (!filter_var($_POST['edit_email'], FILTER_VALIDATE_EMAIL)) {
                                        echo __("<p class='alert alert-danger'> Invalid email format!</p>",'ngondro_gar');
                                    } else if(email_exists($_POST['edit_email'])){
                                        echo __("<p class='alert alert-danger'>Email Address already exists!</p>",'ngondro_gar');
                                        delete_user_meta( $user->ID, '_new_email' );
                                    }else{
                                         //confirmation email for student
                                        $hash = md5( $_POST['edit_email'] . time() . wp_rand() );
                                            $new_user_email = array(
                                                    'hash'     => $hash,
                                                    'newemail' => $_POST['edit_email'],
                                            );
                                            update_user_meta( $user->ID, '_new_email', $new_user_email );
                            
                                        $sitename = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

                                        if($user_language == 'zh-hans'){
                                            $email_text = __(
                                            '您好，###USERNAME###:<br/><br/>

                                                您最近请求修改您账户的电子邮箱地址。<br/>
                                                
                                                如果您确实要修改，请点击以下链接：<br/>
                                                <a href="###EDIT_PROFILE_URL###">点击这里</a><br/><br/>
                                                
                                                如果您并未请求修改，则可安全地忽视并删除此邮件。<br/>
                                                
                                                此邮件被发送至###EMAIL###<br/><br/>
                                                
                                                祝好，<br/>
                                                ###SITENAME###全体成员敬上<br/>
                                                ###SITEURL###'
                                            );
                                        }
                                        elseif($user_language == 'zh-hant'){
                                            $email_text = __(
                                                '###USERNAME### 你好，<br/><br/>

                                                    你最近要求變更你的帳號中的電子郵件地址。<br/>
                                                    
                                                    如果這項要求確認無誤，請點擊以下連結進行變更：<br/>
                                                    <a href="###EDIT_PROFILE_URL###">點擊這裡</a><br/><br/>
                                                    
                                                    如果不想進行這項變更，請直接忽略並刪除這封電子郵件。<br/>
                                                    
                                                    這封電子郵件已傳送至 ###EMAIL###。<br/><br/>
                                                    
                                                    敬祝安好，<br/>
                                                    《###SITENAME###》管理團隊<br/>
                                                    ###SITEURL###'
                                                );
                                        }
                                        elseif($user_language == 'pt-br'){
                                            $email_text = __(
                                                'Olá ###USERNAME###,<br/><br/>

                                                    Solicitou há pouco que o endereço de email da sua conta fosse alterado.<br/>
                                                    
                                                    Se este pedido está correcto, siga a ligação abaixo para alterar o email:<br/>
                                                    <a href="###EDIT_PROFILE_URL###">Clique aqui</a><br/><br/>
                                                    
                                                    Pode ignorar e apagar esta mensagem se não quer alterar o email. <br/>
                                                    
                                                    Este email foi enviado a ###EMAIL### <br/><br/>
                                                    
                                                    Cumprimentos, <br/>
                                                    A equipa ###SITENAME### <br/>
                                                    ###SITEURL###'
                                                );
                                        }
                                        elseif($user_language == 'es'){
                                            $email_text = __(
                                                'Hola ###USERNAME###,<br/><br/>

                                                    Has solicitado recientemente cambiar la dirección de correo electrónico de tu cuenta.<br/>
                                                    
                                                    Si esto es correcto, por favor, haz clic en el siguiente enlace para cambiarla:<br/>
                                                    <a href="###EDIT_PROFILE_URL###">Haga clic aquí</a><br/><br/>
                                                    
                                                    Puedes ignorar y borrar este correo electrónico sin problemas si no quieres
                                                    realizar esta acción.<br/>
                                                    
                                                    Este correo electrónico se ha enviado a ###EMAIL###<br/><br/>
                                                    
                                                    Saludos,<br/>
                                                    El equipo de ###SITENAME###<br/>
                                                    ###SITEURL###'
                                                );
                                        } else {

                                            $email_text = __(
                                            'Howdy ###USERNAME###,<br/><br/>
                                            
                                                You recently requested to have the email address on your account changed.<br/>
                                                
                                                If this is correct, please click on the following link to change it:<br/>
                                                <a href="###EDIT_PROFILE_URL###">Click Here</a><br/><br/>
                                                
                                                You can safely ignore and delete this email if you do not want to
                                                take this action.<br/>
                                                
                                                This email has been sent to ###EMAIL###<br/><br/>
                                                
                                                Regards,<br/>
                                                All at ###SITENAME###<br/>
                                                ###SITEURL###'
                                            );
                                        }
                                        $content = apply_filters( 'new_user_email_content', $email_text, $new_user_email );
                                        $content = str_replace( '###USERNAME###', $user->user_login, $content );
                                        $content = str_replace( '###EDIT_PROFILE_URL###', esc_url( home_url( 'edit-profile/?newuseremail='.$hash ) ), $content );
                                        $content = str_replace( '###EMAIL###', $_POST['edit_email'], $content);
                                        $content = str_replace( '###SITENAME###', get_option( 'blogname' ), $content );
                                        $content = str_replace( '###SITEURL###', home_url(), $content );
                                        $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
                                        $headers[] = "X-Mailer: PHP \r\n";
                                        $headers[] = 'From: NGONDRO GAR < '.get_option( 'admin_email' ).'>' . "\r\n";
                                        wp_mail( $_POST['edit_email'], sprintf( __( '[%s] New Email Address' ), get_option( 'blogname' ) ), $content, $headers );
                                        $_POST['edit_email'] = $user->user_email;
                                       
                                        //end email notification
                                        update_user_meta( $user_id, 'social_icon',  $_POST['register_social_icon'] );
                                        update_user_meta( $user_id, 'sociallink',  $_POST['register_sociallink'] );
                                        update_user_meta( $user_id, 'city',  $_POST['register_city']  );
                                        update_user_meta( $user_id, 'region', $_POST['edit_region'] );
                                        update_user_meta( $user_id, 'first_name', $_POST['edit_first_name'] );
                                        update_user_meta( $user_id, 'last_name', $_POST['edit_last_name'] );
                                        // $args = array(
                                        //     'ID'         => $user_id,
                                        //     'user_email' => esc_attr( $_POST['edit_email'] )
                                        // );
                                        // $data = wp_update_user( $args );
                                            if(in_array( 'student', (array) $user->roles ) ){ 
                                            echo __("<p class='alert alert-success'> Profile updated successfully!</p>",'ngondro_gar');
                                            }
                                            if(in_array( 'instructor', (array) $user->roles ) && !empty($ins_post_id) ){ 
                                                $ins_bio_update = array(
                                                    'ID'           => $ins_post_id,
                                                    'post_title'   => $ins_name,
                                                    'post_content' => $_POST['instructor_bio'],
                                                );
                                                wp_update_post( $ins_bio_update );
                                                $bio_content = $ins_post->post_content;
                                                echo __("<p class='alert alert-success'> Profile updated successfully!</p>",'ngondro_gar');
                                            }
                                        }
                                    }
                                    else {
                                        update_user_meta( $user_id, 'social_icon',  $_POST['register_social_icon'] );
                                        update_user_meta( $user_id, 'sociallink',  $_POST['register_sociallink'] );
                                        update_user_meta( $user_id, 'city',  $_POST['register_city']  );
                                        update_user_meta( $user_id, 'region', $_POST['edit_region'] );
                                        update_user_meta( $user_id, 'first_name', $_POST['edit_first_name'] );
                                        update_user_meta( $user_id, 'last_name', $_POST['edit_last_name'] );
                                        if(in_array( 'student', (array) $user->roles ) ){ 
                                        echo __("<p class='alert alert-success'> Profile updated successfully!</p>",'ngondro_gar');
                                        } 
                                        if(in_array( 'instructor', (array) $user->roles ) && !empty($ins_post_id) ){ 
                                            $ins_bio_update = array(
                                                'ID'           => $ins_post_id,
                                                'post_title'   => $ins_name,
                                                'post_content' => $_POST['instructor_bio'],
                                            );
                                            wp_update_post( $ins_bio_update );
                                            $bio_content = $ins_post->post_content;
                                            echo __("<p class='alert alert-success'> Profile updated successfully!</p>",'ngondro_gar');
                                        }
                                    }
                                }
                                
                                
                                $countries = $wpdb->get_results("Select * From `countries_data`");
                                $user = get_userdata(get_current_user_id());
                                
                                $user_meta = get_user_meta(get_current_user_id());

                                /*Edit/update user profile Image*/

                                if(isset($_POST['profile_image_submit'])){
                                    $user_id  = get_current_user_id();

                                    $arr_img_ext = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml');
                                    $file_ext = array('jpeg', 'jpg', 'gif', 'svg', 'png');
                                
                                        if (in_array($_FILES['file']['type'], $arr_img_ext)) {
                                                $file_size = filesize($_FILES['file']['tmp_name']);
                                                $file_max_upload = wp_max_upload_size();
                                                $file_max_mb = number_format($file_max_upload / 1048576, 0);
                                                if($file_size <= $file_max_upload){
                                                $upload = wp_upload_bits($_FILES['file']['name'], null, file_get_contents($_FILES['file']['tmp_name']));
                                                    $res['url'] = $upload['url'];
                                                    // Move file to media library
                                                    // If move was successful, insert WordPress attachment
                                                    $wp_upload_dir = wp_upload_dir();
                                                    $attachment = array(
                                                    'guid' => $wp_upload_dir['url'] . '/' . basename($upload['file']),
                                                    'post_mime_type' => $upload['type'],
                                                    'post_title' => preg_replace( '/\.[^.]+$/', '', basename($upload['file']) ),
                                                    'post_content' =>'',
                                                    'post_status' => 'inherit'
                                                    );
                                                    $attach_id = wp_insert_attachment($attachment, $upload['file']);
                                                    if(in_array( 'instructor', (array) $user->roles ) ){ 
                                                        $args =  array(
                                                            'post_type' => 'instructor',
                                                            'posts_per_page'=> 1,
                                                            'hide_empty' => true,
                                                            'meta_key'=> 'instructor',
                                                            'meta_value' =>get_current_user_id()
                                                        );
                                                        $ins_post = get_posts($args)[0];
                                                        $ins_post_id = $ins_post->ID;
                                                        //update instructor photo
                                                        update_field('instructor_photo', $attach_id, $ins_post_id);
                                                    }
                                                    else {
                                                        update_user_meta( $user_id, 'profile_image',   $res['url'] );
                                                    }
                                                     echo "<p class='alert alert-success'> Profile updated successfully!</p>";
                                                }else {
                                                    $res['error'] = sprintf( __( 'This file is too big. File must be less than %s MB in size.' ), $file_max_mb );
                                                     echo "<p class='alert alert-warning'>".$res['error']."</p>";
                                                }            
                                        }
                                        else{
                                            $res['status'] = 'Upload failed. Allowed file types: ' . implode(',', $file_ext);
                                            echo "<p class='alert alert-warning'>".$res['status']."</p>";
                                        }
                                }

                                //remove profile photo
                                if(isset($_POST['profile_image_remove'])){
                                    $user_id  = get_current_user_id();
                                    if(in_array( 'instructor', (array) $user->roles ) ){ 
                                    delete_field('instructor_photo',$ins_post_id);
                                    } else {
                                    update_user_meta( $user_id, 'profile_image',  "" );
                                    }
                                    echo "<p class='alert alert-success'> Profile removed successfully!</p>";
                                }

                                $user = get_userdata(get_current_user_id());
                                $user_meta = get_user_meta(get_current_user_id());

                                if(in_array( 'instructor', (array) $user->roles ) ){ 
                                    $args =  array(
                                        'post_type' => 'instructor',
                                        'posts_per_page'=> 1,
                                        'hide_empty' => true,
                                        'meta_key'=> 'instructor',
                                        'meta_value' =>get_current_user_id()
                                    );
                                    $ins_post = get_posts($args)[0];
                                    $ins_post_id = $ins_post->ID;
                                    $ins_name = get_the_title($ins_post_id);
                                    $ins_img = get_field('instructor_photo',$ins_post_id);
                                    $bio_content = $ins_post->post_content;
                                } else {
                                    $ins_img = get_the_author_meta( 'profile_image', get_current_user_id() );
                                }
                                ?>
                            </div>

                            <div class="edit-profile-inner-box mb-3">
                                <div class="edit-profile-table-wrapper common-form-style">
                                    <h2><?php echo __('Edit Profile','ngondro_gar');?></h2>
                                    <div class="d-flex align-items-center image-upload ">
                                        <div class="me-5 avator-image-wrapper">
                                            <?php 
                                            // $profile_img = get_the_author_meta( 'profile_image', get_current_user_id() );
                                            $profile_img = $ins_img;
                                            
                                            if($profile_img):?>
                                                <img src="<?=$profile_img;?>" style="height:120px; width:120px;border-radius:50%; object-fit:cover;">
                                            <?php else : ?>
                                            <img src="https://via.placeholder.com/150x150.png"
                                                 alt="Profile Pic" class="w-100 h-100" style="height:120px; width:120px;border-radius:50%; object-fit:cover;">
                                            <?php endif;?>

                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <input class="form-control inputfile" type="file" id="profile_image" name="file" data-multiple-caption="{count} file selected">
                                            <label for="profile_image" style="display:block;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> 
                                            <span><?php echo __('Choose file…','ngondro_gar');?></span>
                                            </label>
                                            <button class="btn btn-lg btn-default my-3" name="profile_image_submit" type="submit"><?php echo __('Upload Image','ngondro_gar');?></button>
                                            <button class="btn btn-lg btn-outline-secondary my-3" name="profile_image_remove" type="submit" ><?php echo __('Remove Photo','ngondro_gar');?></button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!--for desktop-->
                            <div class="edit-profile-inner-box d-block d-md-none">
                                <form method="POST">
                                    <div class="edit-profile-table-wrapper common-form-style">
                                        <div class="row">
                                            <?php if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
                                            <div class="col">
                                                <div class="form-floating">
                                                    <input type="text" name="edit_first_name" maxlength="50" class="form-control" value="<?=$user_meta['first_name'][0]?>" required>
                                                    <label for="edit_full_name"><?php echo __('First Name','ngondro_gar');?></label>
                                                </div>

                                                <div class="form-floating mt-5">
                                                    <input type="text" name="edit_last_name" maxlength="50" class="form-control" value="<?=$user_meta['last_name'][0]?>">
                                                    <label for="edit_full_name"><?php echo __('Last Name','ngondro_gar');?></label>
                                                </div>

                                                <div class="form-floating mt-5">
                                                    <input type="email" name="edit_email" maxlength="50" class="form-control" value="<?=$user->user_email?>" >
                                                    <label for="edit_email"><?php echo __('Email','ngondro_gar');?></label>
                                                    <?php 
                                                    $email = get_user_meta( get_current_user_id(), '_new_email', true );
                                                    if ( $email ) {
                                                         /* translators: %s: New email address. */
                                                            echo '<div class="notice notice-info"><p><i class="fas fa-info-circle"></i>' . sprintf( __( 'Your email address has not been updated yet. Please check your inbox at %s for a confirmation email.' ), '<code>' . esc_html( $email['newemail'] ) . '</code>' ) . '</p></div>';
                                                     } ?>
                                                </div>
                                                <div class="form-floating mt-5">
                                                    <input type="email" name="edit_username" maxlength="50" class="form-control" value="<?=$user->user_login?>" disabled>
                                                    <label for="edit_username"><?php echo __('Username','ngondro_gar');?></label>
                                                </div>

                                                <div class="form-floating mt-5">
                                                    <select id="edit_region" name="edit_region" class="form-control form-select">
                                                        <option value="" ><?php echo __('Select Your Region','ngondro_gar');?></option>
                                                        <?php
                                                        $region = $user_meta['region'][0];
                                                        foreach($countries as $data):
                                                            $selected = ($data->iso==$region)?"selected":"";
                                                            ?>
                                                            <option value="<?=$data->iso?>" <?=$selected?>><?=$data->name?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                    <label for="edit_region"><?php echo __('Region','ngondro_gar');?></label>
                                                </div>
                                                <div class="col-md-12 justify-content-between d-flex mt-1">
                                                    <?php $social_icon = get_the_author_meta( 'social_icon', $user->ID );  ?>
                                                    <select id="register_social_icon" name="register_social_icon" class="custom-select" placeholder="---" aria-invalid="false">
                                                        <option value="wechat" class="wechat" data-src="<?php echo get_template_directory_uri();?>/assets/images/wechat.png" <?php echo ($social_icon=="wechat")?"selected":"";?> ><?php echo __('WeChat','ngondro_gar');?></option>
                                                        <option value="whatsapp" class="whatsapp" data-src="<?php echo get_template_directory_uri();?>/assets/images/whatsapp.png" <?php echo ($social_icon=="whatsapp")?"selected":"";?>><?php echo __('WhatsApp','ngondro_gar');?></option>
                                                        <option value="telegram" class="telegram" data-src="<?php echo get_template_directory_uri();?>/assets/images/telegram.png" <?php echo ($social_icon=="telegram")?"selected":"";?>><?php echo __('Telegram','ngondro_gar');?></option>
                                                    </select>
                                                    <div class="form-floating mt-3 mb-3 w-100">
                                                        <input class="form-control none-border-radius-left" maxlength="50" type="text" id="register_sociallink" value="<?=$user_meta['sociallink'][0]?>" placeholder="ID" name="register_sociallink">
                                                        <label for="register_sociallink"><?php echo __('ID','ngondro_gar');?></label>
                                                        <input type="hidden" name="edit_user_id" class="form-control" value="<?=get_current_user_id()?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if(is_user_logged_in() && in_array( 'instructor', (array) $user->roles )){ ?>
                                            <div class="col">
                                                <div class="form-row form-floating">
                                                    <input type="text" name="edit_first_name" maxlength="50" class="form-control" value="<?=$user_meta['first_name'][0].' '.$user_meta['last_name'][0]?>" required>
                                                    <label for="edit_full_name"><?php echo __('Full Name','ngondro_gar');?></label>
                                                </div>

                                                <div class="form-floating mt-5">
                                                    <input type="email" name="edit_email" maxlength="50" class="form-control" value="<?=$user->user_email?>" >
                                                    <label for="edit_email"><?php echo __('Email','ngondro_gar');?></label>
                                                    <?php 
                                                    $email = get_user_meta( get_current_user_id(), '_new_email', true );
                                                    if ( $email ) {
                                                         /* translators: %s: New email address. */
                                                            echo '<div class="notice notice-info"><p>' . sprintf( __( 'Your email address has not been updated yet. Please check your inbox at %s for a confirmation email.' ), '<code>' . esc_html( $email['newemail'] ) . '</code>' ) . '</p></div>';
                                                     } ?>
                                                </div>
                                                <?php if($ins_post_id):?>
                                                <div class="mt-5">
                                                    <label for=""><?php echo __('Update Bio:','ngondro_gar');?></label>
                                                    <textarea name="instructor_bio" id="instructor_bio" maxlength="2000" class="form-control" rows="5"><?php if($bio_content): echo wp_strip_all_tags($bio_content);endif;?></textarea>
                                                </div>

                                                <?php endif;?>
                                                <input type="hidden" name="edit_user_id" class="form-control" value="<?=get_current_user_id()?>">

                                            </div>


                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-buttons-wrapper mt-7">
                                        <button class="btn btn-lg btn-default me-4" name="edit_profile" type="submit"><?php echo __('Save','ngondro_gar');?></button>
                                        <a href="<?php echo home_url('/your-profile/');?>" class="btn btn-lg btn-tranparent" name="edit_profile_cancel"><?php echo __('Cancel','ngondro_gar');?></a>
                                    </div>
                                </form>
                            </div>
                            <!-- form mobile-->
                            <div class="edit-profile-inner-box d-none d-md-block">
                                <form method="POST">
                                    <div class="edit-profile-table-wrapper common-form-style">
                                        
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                            <?php if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
                                            <tr>
                                                <th scope="row"><?php echo __('First Name :','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input type="text" name="edit_first_name" maxlength="50" class="form-control" value="<?=$user_meta['first_name'][0]?>" required>
                                                        <label for="edit_full_name"><?php echo __('First Name','ngondro_gar');?></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('Last Name :','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input type="text" name="edit_last_name" maxlength="50" class="form-control" value="<?=$user_meta['last_name'][0]?>">
                                                        <label for="edit_full_name"><?php echo __('Last Name','ngondro_gar');?></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('Email :','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input type="email" name="edit_email" maxlength="50" class="form-control" value="<?=$user->user_email?>" >
                                                        <label for="edit_email"><?php echo __('Email','ngondro_gar');?></label>
                                                        <?php 
                                                    $email = get_user_meta( get_current_user_id(), '_new_email', true );
                                                    if ( $email ) {
                                                         /* translators: %s: New email address. */
                                                            echo '<div class="notice notice-info"><p>' . sprintf( __( 'Your email address has not been updated yet. Please check your inbox at %s for a confirmation email.' ), '<code>' . esc_html( $email['newemail'] ) . '</code>' ) . '</p></div>';
                                                     } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('Username :','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input type="email" name="edit_username" maxlength="50" class="form-control" value="<?=$user->user_login?>" disabled>
                                                        <label for="edit_username"><?php echo __('Username','ngondro_gar');?></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('City :','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input class="form-control" type="text" maxlength="50" id="register_city" placeholder="City" value="<?=$user_meta['city'][0]?>" name="register_city">
                                                        <label for="register_city"><?php echo __('City','ngondro_gar');?></label>
                                                    </div>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('Region :','ngondro_gar');?></th>
                                                <td><div class="form-floating">
                                                        <select id="edit_region" name="edit_region" class="form-control form-select">
                                                            <option value="" ><?php echo __('Select Your Region','ngondro_gar');?></option>
                                                            <?php
                                                            $region = $user_meta['region'][0];
                                                            foreach($countries as $data):
                                                                $selected = ($data->iso==$region)?"selected":"";
                                                                ?>
                                                                <option value="<?=$data->iso?>" <?=$selected?>><?=$data->name?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                        <label for="edit_region"><?php echo __('Region','ngondro_gar');?></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('Social media :','ngondro_gar');?></th>
                                                <td> <div class="col-md-12 justify-content-between d-flex">
                                                        <?php $social_icon = get_the_author_meta( 'social_icon', $user->ID );  ?>
                                                        <select id="register_social_icon" name="register_social_icon" class="custom-select" placeholder="---" aria-invalid="false">
                                                            <option value="wechat" class="wechat" data-src="<?php echo get_template_directory_uri();?>/assets/images/wechat.png" <?php echo ($social_icon=="wechat")?"selected":"";?> ><?php echo __('WeChat','ngondro_gar');?></option>
                                                            <option value="whatsapp" class="whatsapp" data-src="<?php echo get_template_directory_uri();?>/assets/images/whatsapp.png" <?php echo ($social_icon=="whatsapp")?"selected":"";?>><?php echo __('WhatsApp','ngondro_gar');?></option>
                                                            <option value="telegram" class="telegram" data-src="<?php echo get_template_directory_uri();?>/assets/images/telegram.png" <?php echo ($social_icon=="telegram")?"selected":"";?>><?php echo __('Telegram','ngondro_gar');?></option>
                                                        </select>
                                                        <div class="form-floating mt-3 mb-3 w-100">
                                                            <input class="form-control none-border-radius-left" maxlength="50" type="text" id="register_sociallink" value="<?=$user_meta['sociallink'][0]?>" placeholder="ID" name="register_sociallink">
                                                            <label for="register_sociallink"><?php echo __('ID','ngondro_gar');?></label>
                                                            <input type="hidden" name="edit_user_id" class="form-control" value="<?=get_current_user_id()?>">
                                                        </div>
                                                    </div></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(is_user_logged_in() && in_array( 'instructor', (array) $user->roles )){ ?>
                                                <tr>
                                                    <th scope="row"><?php echo __('Full Name :','ngondro_gar');?></th>
                                                    <td>
                                                        <div class="form-floating">
                                                            <input type="text" name="edit_first_name" maxlength="50" class="form-control" value="<?=$user_meta['first_name'][0].' '.$user_meta['last_name'][0]?>" required>
                                                            <label for="edit_full_name"><?php echo __('Full Name','ngondro_gar');?></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo __('Email:','ngondro_gar');?></th>
                                                    <td>
                                                        <div class="form-floating">
                                                            <input type="email" name="edit_email" maxlength="50" class="form-control" value="<?=$user->user_email?>">
                                                            <label for="edit_email"><?php echo __('Email','ngondro_gar');?></label>
                                                            <?php 
                                                            $email = get_user_meta( get_current_user_id(), '_new_email', true );
                                                            if ( $email ) {
                                                                /* translators: %s: New email address. */
                                                                    echo '<div class="notice notice-info"><p>' . sprintf( __( 'Your email address has not been updated yet. Please check your inbox at %s for a confirmation email.' ), '<code>' . esc_html( $email['newemail'] ) . '</code>' ) . '</p></div>';
                                                            } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php if($ins_post_id):?>
                                                <tr>
                                                    <th scope="row"><?php echo __('Update Bio:','ngondro_gar');?></th>
                                                    <td>
                                                        <textarea name="instructor_bio" id="instructor_bio" maxlength="2000" class="form-control" rows="5"><?php if($bio_content): echo wp_strip_all_tags($bio_content);endif;?></textarea>
                                                    </td>
                                                </tr>
                                                <?php endif;?>
                                                <input type="hidden" name="edit_user_id" class="form-control" value="<?=get_current_user_id()?>">
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-buttons-wrapper mt-7">
                                        <button class="btn btn-lg btn-default me-4" name="edit_profile" type="submit"><?php echo __('Save','ngondro_gar');?></button>
                                        <a href="<?php echo home_url('/your-profile/');?>" class="btn btn-lg btn-tranparent" name="edit_profile_cancel"><?php echo __('Cancel','ngondro_gar');?></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php get_footer();?>
    </div>

    <script>
//        function checkEmail() {
//         this.preventDefault();
// var email = document.getElementById('edit_email');
// var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

// if (!filter.test(email.value)) {
//     alert('Please provide a valid email address');
//     email.focus;
//     return false;
// }
// }


// var regexEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
// var email = document.getElementById("edit_email");
// document.preventDefault();
// if (regexEmail.test(email.value)) {
//     alert("It's Okay")
// } else {
//     alert("Not Okay")

// }
var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
    </script>