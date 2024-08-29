<?php 
/**
 * Template Name: Profile Page
 * @desc Edit/update Instructor Profile Info
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {get_user_meta} [object] Return all user meta values 
 * @params {get_the_title} [Value] Return title of the page/post
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {get_users()} [object] Return users details
 * @returns {get_posts()} [object] Return posts object
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 * @function {wp_safe_redirect} Performs a safe (local) redirect
 */

if(!is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}

get_header('loggedin');
$user = wp_get_current_user();
$user_meta = get_user_meta(get_current_user_id());
$full_name = $user_meta['first_name'][0]." ".$user_meta['last_name'][0];
$social_icons = $user_meta['social_icon'][0]; 


$my_current_lang = apply_filters( 'wpml_current_language', NULL );

$diff = abs(strtotime(date('Y-m-d')) - strtotime($user->user_registered)); 

$years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
global $wpdb;
?>
    <div id="layoutSidenav_content">
        <section class="user-profile-wrapper pb-15">
            <div class="inner-page-heading pt-10 pb-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                        <?php  if( is_user_logged_in() && in_array( 'student', (array) $user->roles ) ){ ?>
                            <h3><?php echo get_the_title();?></h3>
                       <?php  }else if(is_user_logged_in() && in_array( 'administrator', (array) $user->roles )){ ?>
                            <h3><?php echo __('administrator\'s Profile','ngondro_gar');?></h3>
                    <?php   } else { ?>
                        <h3><?php echo __('Instructor\'s Profile','ngondro_gar');?></h3>
                      <?php  }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="profile-details-box-wrapper common-form-style pt-11">
                            <div class="profile-header">
                                <div class="full-name-and-join-date">
                                    <div class="text-avatar">
                                    <?php  if(in_array( 'instructor', (array) $user->roles ) ){ 
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
                                         if($ins_img){
                                             echo '<img src="'.$ins_img.'" alt="'.$ins_name.'"/>';
                                         }
                                         else {
                                            echo $user_meta['first_name'][0][0];
                                         }
                                    }

                                    else if(in_array( 'administrator', (array) $user->roles ) ){ 
                                        $args =  array(
                                            'post_type' => 'administrator',
                                            'posts_per_page'=> 1,
                                            'hide_empty' => true,
                                            'meta_key'=> 'administrator',
                                            'meta_value' =>get_current_user_id()
                                        );
                                        $ins_post = get_posts($args)[0];
                                        
                                        $ins_post_id = $ins_post->ID;
                                        $ins_name = get_the_title($ins_post_id);
                                        $ins_img = get_field('administrator_photo',$ins_post_id);
                                        if($ins_img){
                                            echo '<img src="'.$ins_img.'" alt="'.$ins_name.'"/>';
                                        }
                                        else {
                                           echo $user_meta['first_name'][0][0];
                                        }
                                   }
                                    else {
                                        $ins_img = $user_meta['profile_image'];
                                        if(!empty($ins_img[0])){
                                            echo '<img src="'.$ins_img[0].'" alt="'.$ins_name.'"/>';
                                        }
                                        else {
                                           echo $user_meta['first_name'][0][0];
                                        }
                                    }
                                        ?>
                                    </div>
                                    <div class="user-full-name">
                                        <h3><?=$full_name?></h3>
                                        <p><?php echo __('Member since:','ngondro_gar');?> <span> <?=$years?> <?php echo __('Years ','ngondro_gar');?><?=$months?> <?php echo __('Months','ngondro_gar');?> <?=$days?> <?php echo __('Days','ngondro_gar');?> ( 
                                           <?php if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
                                                    echo date('Y年 n月 j日', strtotime($user->user_registered));
                                            }
                                            elseif($my_current_lang == 'pt-pt'){
                                               echo date('j \d\e F, Y', strtotime($user->user_registered));
                                            }
                                            else {
                                                echo date('j F Y', strtotime($user->user_registered));
                                            } ?>)</span></p>
                                    </div>
                                </div>
                                <div class="profile-edit-btn"><a class="btn btn-lg btn-default" href="<?php echo home_url('/edit-profile/');?>"><?php echo __('Edit Profile','ngondro_gar');?></a></div>
                            </div>
                            <hr>
                            <div class="user-profile-details">
                                <div class="mobile-display d-block d-sm-none">
                                    <?php  if( is_user_logged_in() && in_array( 'student', (array) $user->roles ) ){ ?>
                                        <div class="row mt-5">
                                            <div class="col-5">
                                                <label><?php echo __('Full name :','ngondro_gar');?></label>
                                            </div>
                                            <div class="col-7"><?=$full_name?></div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-5">
                                                <label for=""><?php echo __('Email :','ngondro_gar');?> </label>
                                            </div>
                                            <div class="col-7"><?=$user->user_email?></div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-5">
                                                <label for=""><?php echo __('Username :','ngondro_gar');?></label>
                                            </div>
                                            <div class="col-7"><?=$user->user_login?></div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-5">
                                                <label for=""><?php echo __('Region :','ngondro_gar');?></label>
                                            </div>
                                            <div class="col-7"><?php
                                                $region_data = $wpdb->get_row("select * from countries_data where iso='".$user_meta['region'][0]."'");
                                                if($region_data){
                                                    echo $region_data->nicename;
                                                }
                                                else {
                                                    echo $user_meta['region'][0];
                                                }
                                                ?></div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-5">
                                                <label for=""><?php echo __('Social media :','ngondro_gar');?></label>
                                            </div>
                                            <?php
                                            $img_url = get_template_directory_uri().'/assets/images/'.$social_icons.'.png';
                                            ?>
                                            <div class="col-7">
                                                <?php if($social_icons):?>
                                                    <img src="<?=$img_url?>">
                                                <?php endif;?>
                                                <?=$user_meta['sociallink'][0]?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                        <?php  if(in_array( 'instructor', (array) $user->roles ) ){
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
                                        $primary_language = get_field('primary_language',$ins_post_id);
                                        $secondary_languages = get_field('secondary_languages', $ins_post_id);

                                        ?>
                                        <div class="row mt-5">
                                            <div class="col-6">
                                                <label for=""><?php echo __('Primary language:','ngondro_gar');?></label>
                                            </div>
                                            <div class="col-12"><?php echo ucfirst($primary_language);?></div>
                                        </div>
                                        <?php if(!empty($secondary_languages)):?>
                                        <div class="row mt-5">
                                            <div class="col-6">
                                                <label for=""><?php echo __('Secondary langugage:','ngondro_gar');?></label>
                                            </div>
                                            <div class="col-6"><?php foreach ($secondary_languages as $value):
                                                $languages .= $value .', ';
                                                ?>
							                <?php endforeach;
                                                $languages = trim($languages, ', ');    // remove trailing comma
                                                echo $languages;
                                                ?>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <?php } ?>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-borderless mb-0 d-none d-sm-block">
                                    <tbody>
                                    <?php  if( is_user_logged_in() && in_array( 'student', (array) $user->roles ) ){ ?>
                                    <tr>
                                        <th scope="row"><?php echo __('Full name :','ngondro_gar');?></th>
                                        <td><?=$full_name?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo __('Email :','ngondro_gar');?></th>
                                        <td><?=$user->user_email?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo __('Username :','ngondro_gar');?></th>
                                        <td><?=$user->user_login?></td>
                                    </tr>
                                    <!--<tr>
                                        <th scope="row">Address :</th>
                                        <td>Some town 123, Some city, Some country</td>
                                    </tr>-->
                                    <tr>
                                        <th scope="row"><?php echo __('Region :','ngondro_gar');?></th>
                                        <td><?php
                                        $region_data = $wpdb->get_row("select * from countries_data where iso='".$user_meta['region'][0]."'");
                                        if($region_data){
                                            echo $region_data->nicename;
                                        }
                                        else {
                                            echo $user_meta['region'][0];
                                        }
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo __('Social media :','ngondro_gar');?></th>
                                        <?php
                                        $img_url = get_template_directory_uri().'/assets/images/'.$social_icons.'.png';
                                        ?>
                                        <td>
                                            <?php if($social_icons):?>
                                                <img src="<?=$img_url?>">
                                            <?php endif;?>
                                            <?=$user_meta['sociallink'][0]?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php  if(in_array( 'instructor', (array) $user->roles ) ){ 
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
                                         $primary_language = get_field('primary_language',$ins_post_id);
                                         $secondary_languages = get_field('secondary_languages', $ins_post_id);
                                         
                                        ?>
                                        <tr>
                                        <th scope="row"><?php echo __('Primary language:','ngondro_gar');?></th>
                                        <td><?php echo ucfirst($primary_language);?></td>
                                        </tr>
                                        <?php if(!empty($secondary_languages)):?>
                                        <tr>
                                            <th scope="row"><?php echo __('Secondary langugage:','ngondro_gar');?></th>
                                            <td><?php foreach ($secondary_languages as $value):
                                                $languages .= $value .', ';
                                                ?>
                                                
							                <?php endforeach;
                                            $languages = trim($languages, ', ');    // remove trailing comma
                                            echo $languages;
                                            ?>
                                        </td>
                                        </tr>
                                        <?php endif;?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                </div>
                                <?php  if(in_array( 'instructor', (array) $user->roles ) ){ 
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
                                         $primary_language = get_field('primary_language',$ins_post_id);
                                         $secondary_languages = get_field('secondary_languages', $ins_post_id);
                                         $bio_content = $ins_post->post_content;
                                         
                                        ?>
                                        <div class="instructor-bio">
                                        <h3><?php echo __('BIO','ngondro_gar');?></h3>
                                        <?php echo ($bio_content)? $bio_content : '<em>No Bio Here</em>'; ?>
                                    </div>
                                    <?php } ?>
                            </div>
                        </div>
                        <?php  if( is_user_logged_in() && in_array( 'student', (array) $user->roles ) ){ ?>
                       
                        <div class="preference-box-wrapper mt-12">
                            <div class="preference-section-title mb-2">
                                <h3><?php echo __('Preference','ngondro_gar');?></h3>
                                <a href="<?php echo home_url('/edit-preferences/');?>"><?php echo __('Edit Preference','ngondro_gar');?></a>
                            </div>
                            <div class="preference-table-wrapper common-form-style">
                                <div class="mobile-display d-block d-sm-none">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for=""><?php echo __('Language','ngondro_gar');?></label>
                                        </div>
                                        <div class="col-6">
                                            <?php
                                            $lang = "English";
                                            if($user_meta['language'][0]=="en"){
                                                $lang = "English";
                                            }
                                            else if($user_meta['language'][0]=="zh-hant"){
                                                $lang = "繁體中文";
                                            }
                                            else if($user_meta['language'][0]=="zh-hans"){
                                                $lang = "简体中文";
                                            }
                                            else{
                                                $lang = "Português";
                                            }
                                            echo $lang;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-6">
                                            <label for=""><?php echo __('Enrolled course:','ngondro_gar');?></label>
                                        </div>
                                        <div class="col-6"><?php
                                            $cid = $user_meta['curriculum'][0];
                                            $course_data = $wpdb->get_row("Select * from ngondro_courses where course_id  =".$cid);
                                            echo $course_data->title;
                                            ?></div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-6">
                                            <label for=""><?php echo __('Instructor:','ngondro_gar');?> </label>
                                        </div>
                                        <div class="col-6 instructor-name-image">
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
                                            <?php if($ins_image):?>
                                                <img src="<?=$ins_image?>" alt="<?=$ins_name?>">
                                            <?php endif;?>
                                            <p><?=$ins_name?>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-6">
                                                <label><?php echo __('Practice hours:','ngondro_gar');?></label>
                                            </div>
                                            <div class="col-6">
                                                <p><?=$user_meta['track'][0]?> Hrs</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-borderless mb-0 d-none d-sm-block">
                                    <tbody>
                                    <tr>
                                        <th scope="row"><?php echo __('Language:','ngondro_gar');?></th>
                                        <td><?php
                                            $lang = "English";
                                            if($user_meta['language'][0]=="en"){
                                                $lang = "English";
                                            }
                                            else if($user_meta['language'][0]=="zh-hant"){
                                                $lang = "繁體中文";
                                            }
                                            else if($user_meta['language'][0]=="zh-hans"){
                                                $lang = "简体中文";
                                            }
                                            else{
                                                $lang = "Português";
                                            }
                                            echo $lang;
                                        ?>                                        
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo __('Enrolled course:','ngondro_gar');?></th>
                                        <td><?php
                                            $cid = $user_meta['curriculum'][0];
                                            $course_data = $wpdb->get_row("Select * from ngondro_courses where course_id  =".$cid);
                                            echo $course_data->title;
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo __('Instructor:','ngondro_gar');?> </th>
                                        <td class="instructor-name-image">
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
                                            <?php if($ins_image):?>
                                                <img src="<?=$ins_image?>" alt="<?=$ins_name?>">
                                            <?php endif;?>
                                            <?=$ins_name?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo __('Practice hours:','ngondro_gar');?></th>
                                        <td><?=$user_meta['track'][0]?> Hrs</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    <?php  
                    }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php get_footer();?>

    </div>
