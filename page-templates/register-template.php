<?php 
if(is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}
/**
 * Template Name: Register Page
 * @desc Registre page form 
 * @params {get_the_title} [Value] Return title of the page/post
 * @returns {get_field()} Return acf value based on field key
 * @returns {get_posts()} [object] Return posts object
 * @returns {wp_reset_postdata()} this function restores the $post global to the current post in the main query
 */
get_header();
$countries = $wpdb->get_results("Select * From `countries_data`");

$current_lang = apply_filters( 'wpml_current_language', NULL );

?>
<section class="registration-form-page-wrapper pb-12">
<div class="container">
<!-- MultiStep Form -->
<div class="row">
    <div class="col-md-10">
        <div id="multi-step-form-container">
            <h3><?php echo __('Registration Form', 'ngondro_gar');?></h3>
            <!-- Form Steps / Progress Bar -->
            <?php 
              if(isset($_GET['success']) && $_GET['success']==1 ):?>
                <p class="alert alert-info"><?php echo __('Thank you for registering with us. Your application has been received. A link to
create a password will be shared with you via email once your application is accepted. If the
email hasn\'t arrived after 48 hours, it might have landed in your spam folder; if it isn\'t,
please contact us, thank you!','ngondro_gar');?></p>
                <?php endif;?>

            <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                <!-- Step 1 -->
                <li class="form-stepper-active text-center form-stepper-list" step="1">
                    <a>
                        <span class="form-stepper-circle">
                            <span class="number">1</span>
                            <span class="check"><i class="fas fa-check"></i></span>
                        </span>
                        <div class="label"><?php echo __('Personal<br/> Information','ngondro_gar');?></div>
                    </a>
                </li>
                <!-- Step 2 -->
                <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                    <a>
                        <span class="form-stepper-circle text-muted">
                            <span class="number">2</span>
                            <span class="check"><i class="fas fa-check"></i></span>
                        </span>
                        <div class="label text-muted"><?php echo __('Buddhist<br/> Background','ngondro_gar');?></div>
                    </a>
                </li>
                <!-- Step 3 -->
                <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                    <a>
                        <span class="form-stepper-circle text-muted">
                            <span class="number">3</span>
                            <span class="check"><i class="fas fa-check"></i></span>
                        </span>
                        <div class="label text-muted"><?php echo __('Your<br/> Preferences','ngondro_gar');?></div>
                    </a>
                </li>
                  <!-- Step 4 -->
                  <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                    <a>
                        <span class="form-stepper-circle text-muted">
                            <span class="number">4</span>
                            <span class="check"><i class="fas fa-check"></i></span>
                        </span>
                        <div class="label text-muted"><?php echo __('Choose<br/> Instructor','ngondro_gar');?></div>
                    </a>
                </li>
            </ul>
            <!-- Step Wise Form Content -->
            <form id="studentRegisterForm" name="studentRegisterForm" method="POST">
                <!-- Step 1 Content -->
                <fieldset id="step-1" class="form-step">
                    <h4 class="font-normal"><?php echo __('Become a participant','ngondro_gar');?></h4>
                    <p><?php echo __('Please review the <a data-bs-toggle="modal" href="#instructionModalToggle" role="button" class="instruction-popup"><strong>registration instructions</strong></a> carefully.','ngondro_gar');?></p>
                    <!-- Step 1 input fields -->
                    <div class="row mt-8">
                    <!-- <div class="col-md-12">
                        <div class="form-floating mt-3 mb-3">
                        <input class="form-control" type="text" id="register_fullname" placeholder="Full Name" name="register_fullname" maxlength="50" required>
                        <label for="register_fullname"><?php echo __('Full Name','ngondro_gar');?></label>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="form-floating mt-3 mb-3">
                        <input class="form-control" type="text" id="register_firstname" placeholder="First Name" name="register_firstname" maxlength="50" required>
                        <label for="register_firstname"><?php echo __('First Name','ngondro_gar');?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3 mb-3">
                        <input class="form-control" type="text" id="register_lastname" placeholder="Last Name" name="register_lastname" maxlength="50" required>
                        <label for="register_lastname"><?php echo __('Last Name','ngondro_gar');?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3 mb-3">
                        <input class="form-control" type="text" id="register_email" placeholder="Email" name="register_email" maxlength="50" required>
                        <label for="register_email"><?php echo __('Email','ngondro_gar');?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3 mb-3">
                        <input class="form-control" type="text" id="register_username" placeholder="Username" name="register_username" maxlength="50" required>
                        <label for="register_username"><?php echo __('Username','ngondro_gar');?></label>
                        </div>
                    </div>
                    <div class="col-md-12 justify-content-between d-flex">
                        <select id="register_social_icon" name="register_social_icon" class="custom-select" placeholder="---" aria-invalid="false">
                            <option value="wechat" class="wechat" data-src="<?php echo get_template_directory_uri();?>/assets/images/wechat.png" selected><?php echo __('WeChat','ngondro_gar');?></option>
                            <option value="whatsapp" class="whatsapp" data-src="<?php echo get_template_directory_uri();?>/assets/images/whatsapp.png"><?php echo __('WhatsApp','ngondro_gar');?></option>
                            <option value="telegram" class="telegram" data-src="<?php echo get_template_directory_uri();?>/assets/images/telegram.png"><?php echo __('Telegram','ngondro_gar');?></option>
                        </select>
                        <div class="form-floating mt-3 mb-3 w-100">
                        <input class="form-control none-border-radius-left" type="text" id="register_sociallink" placeholder="ID" maxlength="40" name="register_sociallink">
                        <label for="register_sociallink"><?php echo __('ID','ngondro_gar');?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3 mb-3">
                        <input class="form-control" type="text" id="register_city" placeholder="City" name="register_city" maxlength="40" required>
                        <label for="register_city"><?php echo __('City','ngondro_gar');?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3 mb-3">
                        <select id="register_region" name="register_region" class="form-control form-select" aria-invalid="false" required>
                                    <option disabled value="" selected><?php echo __('Select Your Region','ngondro_gar');?></option>
                                    <?php foreach($countries as $data):
                                    // $selected = ($data->iso=="US")?"selected":"";
                                    ?>
                                    <option value="<?=$data->nicename?>" <?=$selected?>><?=$data->name?></option>
                                <?php endforeach;?>	
                        </select>
                        <label for="register_region"><?php echo __('Region','ngondro_gar');?></label>
                        </div>
                    </div>
                    
                    
                    </div>
                    <div class="col-md-12 mt-10">
                        <div class="row">
                            <div class="col-md-6  col-6">
                                <button class="button w-100 btn-navigate-form-step btn btn-lg btn-default next" type="button" step_number="2"><?php echo __('Next','ngondro_gar');?></button>
                            </div>    
                        </div>
                    </div>
                </fieldset>
                <!-- Step 2 Content, default hidden on page load. -->
                <fieldset id="step-2" class="form-step d-none">
                    <h4 class="font-normal"><?php echo __('Understanding','ngondro_gar');?></h4>
                    <p><?php echo __('In order for the instructors to understand your practice background and needs, please answer the following questions:','ngondro_gar');?></p>
                    <!-- Step 2 input fields -->
                    <div class="row mt-8">
                        <div class="col-md-12">
                            <div class="non-form-floating mt-3 mb-3">
                            <label class="mb-2" for="register_motivation"><?php echo __('1. Please share your motive to join Ngondro Gar.','ngondro_gar');?></label>
                            <textarea id="register_motivation" name="register_motivation" cols="30" rows="3" placeholder="<?php echo __('Type Here','ngondro_gar');?>" class="form-control" maxlength="500" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="non-form-floating mt-3 mb-3">
                            <label class="mb-2" for="register_experience"><?php echo __('2. Please list your most significant Buddhist practice and training experience. You might list refuge and bodhisattva vow taken, main empowerments received, training programs attended, retreats undertaken, affiliation with practice groups or meditation centers. Please include approximate dates, durations and teachers as applicable.','ngondro_gar');?></label>
                            <textarea id="register_experience" name="register_experience" cols="30" rows="3" placeholder="<?php echo __('Type Here','ngondro_gar');?>" class="form-control" maxlength="500" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="non-form-floating mt-3 mb-3">
                            <label class="mb-2" for="register_history"><?php echo __('3. Have you met Dzongsar Khyentse Rinpoche and have you received teachings from him?','ngondro_gar');?></label>
                            <textarea id="register_history" name="register_history" cols="30" rows="3" placeholder="<?php echo __('Type Here','ngondro_gar');?>" class="form-control" maxlength="500" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="non-form-floating mt-3 mb-3">
                            <label class="mb-2" for="register_obstacles"><?php echo __('4. Which practice track are you planning to join? What kind of obstacles will likely arise, and how will you handle these obstacles?','ngondro_gar');?></label>
                            <textarea id="register_obstacles" name="register_obstacles" cols="30" rows="3" placeholder="<?php echo __('Type Here','ngondro_gar');?>" class="form-control" maxlength="500" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-10">
                        <div class="row">
                            <div class="col-md-6  col-6">
                            <button class="button w-100 btn-navigate-form-step btn btn-lg btn-tranparent back" type="button" step_number="1"><?php echo __('Previous','ngondro_gar');?></button>
                            </div>
                            <div class="col-md-6  col-6">
                            <button class="button w-100 btn-navigate-form-step btn btn-lg btn-default next" type="button" step_number="3"><?php echo __('Next','ngondro_gar');?></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <!-- Step 3 Content, default hidden on page load. -->
                <fieldset id="step-3" class="form-step d-none">
                    <!-- Step 3 input fields -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-3 mb-3 form-inline non-form-floating">
                            <label class="mb-2" for="prefered_language"><?php echo __('1. Language Preference','ngondro_gar');?></label>
                                <select id="prefered_language" name="prefered_language" class="form-control form-select" aria-invalid="false" required>
                                <option disabled value="" selected><?php echo __('Select','ngondro_gar');?></option>
                                <option value="en">English</option>
                                <option value="zh-hant">繁體中文</option>
                                <option value="zh-hans">简体中文</option>
                                <option value="pt-br">Português</option>
                                <option value="es">Spanish</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-3 mb-5 non-form-floating">
                            <label class="mb-3 d-block"><?php echo __('2. Practice Track','ngondro_gar');?></label>
                            <div class="col-lg-3 col-md-6">  
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="track05">
                                    <input class="form-check-input" id="track05" type="radio" name="track" id="" value="0.5">
                                    <span></span>
                                    <?php echo __('0.5 hr a day','ngondro_gar');?></label>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-6">  
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="track1">
                                    <input class="form-check-input" id="track1" type="radio" name="track" id="" value="1">
                                    <span></span>
                                    <?php echo __('1 hr a day','ngondro_gar');?></label>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-6">  
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="track15">
                                    <input class="form-check-input" id="track15" type="radio" name="track" id="" value="1.5">
                                    <span></span>
                                    <?php echo __('1.5 hrs a day','ngondro_gar');?></label>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-6">  
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="track2">
                                    <input class="form-check-input" id="track2" type="radio" name="track" id="" value="2">
                                    <span></span>
                                    <?php echo __('2 hrs a day','ngondro_gar');?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-3 mb-3">
                            <label class="mb-3 d-block" for="curriculum"><?php echo __('3. Which curriculum would like to choose?','ngondro_gar');?></label>
                                <div class="row non-form-floating">
                                <?php   
                                    global $wpdb; 
                                    $terms = $wpdb->get_results("Select * From ngondro_courses"); 
                                    $index = 1;
                                    foreach($terms as $term):
                                        $short_name = $term->short_name;
                                        $checked = ($index==1)?"checked":"";
                                        $alt = __('Alt', 'ngondro_gar');
                                    ?>
                                    <div class="col-lg-6 col-sm-12 mb-3">    
                                        <div class="form-check form-check-inline ">
                                            <label class="form-check-label" for="inlineRadio<?=$index?>">
                                            <input class="form-check-input" id="inlineRadio<?=$index?>" type="radio" name="curriculum" value="<?=$term->course_id?>">
                                            <span></span>
                                            <?php echo __($term->title, 'ngondro_gar');?></label>
                                        </div>
                                    </div>
                                    <?php $index++; endforeach;?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-10">
                        <div class="row">
                            <div class="col-md-6  col-6">
                            <button class="button w-100 btn-navigate-form-step btn btn-lg btn-tranparent back" type="button" step_number="2"><?php echo __('Previous','ngondro_gar');?></button>
                            </div>
                            <div class="col-md-6  col-6">
                            <button class="button w-100 btn-navigate-form-step btn btn-lg btn-default next" type="button" step_number="4"><?php echo __('Next','ngondro_gar');?></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
                 <!-- Step 4 Content, default hidden on page load. -->
                 <fieldset id="step-4" class="form-step d-none">
                    <h4 class="font-normal"><?php echo __('Instructor','ngondro_gar');?></h4>
                    <p><?php echo __('Please select an instructor to be your guide for your practice. You will be allowed to make changes at a later date.','ngondro_gar');?></p>
                    <!-- Step 3 input fields -->
                    <div class="row mt-4">
                    <div class="col-md-6">
                            <div class="mt-3 mb-3 form-inline">
                            <!-- <label class="mb-2" for="filter_by_language">Filter by Language</label> -->
                                <select id="filter_by_language" name="filter_by_language" class="form-control form-select filter_lang" aria-invalid="false">
                                <option disabled value="" selected><?php echo __('Filter by Language','ngondro_gar');?></option>
                                <option value="en">English</option>
                                <option value="zh-hant">繁體中文</option>
                                <option value="zh-hans">简体中文</option>
                                <option value="pt-br">Português</option>
                                <option value="es">Spanish</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mt-8 non-form-floating">

                        <!-- instructors -->
                    <?php
                        $type = "instructor";                     
                        $trainers = new WP_Query( 
                            array(
                                'post_type' => $type,
                            	'suppress_filters' => true,
                                'posts_per_page'=> -1,
                                'orderby' => 'title',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                                'meta_query' => array(
                                    array(
                                        'key' => 'availability',
                                        'value' => 'yes',
                                        'compare' => '='
                                    )
                                )
                            ) 
                        );
				
                    if($trainers -> have_posts()) :   
                        $index = 0;
                        while ($trainers -> have_posts()) : $trainers ->the_post();
                            $post_id = get_the_ID();
                            $instructor_name = get_the_title($post_id);
                            $language[] = get_field('primary_language',$post_id);
                            $plang = __(get_field('primary_language', $post_id),'ngondro_gar');
                            $secondary_languages = get_field('secondary_languages',$post_id);
                            $languages = array_unique(array_merge($language, $secondary_languages));
                            $languages = implode(', ', $languages);
                            $image = get_field('instructor_photo',$post_id);
                            $ins_id = get_field('instructor', $post_id);
                            $filter_lang = get_field('primary_language',$post_id);
                            $wpml_lang = get_field('wpml_language',$post_id);
                            $is_sel = ($index==0)?"checked":"";

                    ?>
                        <div class="col-lg-3 col-md-6 col-sm-6 not_chinese_instructions filter_ins_section" data-lang="<?=strtolower($filter_lang)?>" data-wpml="<?=$wpml_lang?>">
                            <div class="register_instructor_box">
                            <a class="ajax-popup" href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=instructor_popup_ajax&post_id=<?=$post_id?>"><img src="<?php echo get_template_directory_uri();?>/assets/images/eye.svg" alt="eye-icon"/></a>
                                <input type="radio" id="instructor-<?=$post_id?>" class="form-instructor-input" name="instructor" value="<?=$ins_id?>" required>
                                <label class="form-instructor-label" for="instructor-<?=$post_id?>">
                                    <img class="rounded-circle" src="<?=$image?>" alt="instructor-name"/>
                                    <div class="instructor-name"><?= $instructor_name?></div>
                                    <div class="instructor-languages-wrapper">
                                        <strong><?php echo __('Language:','ngondro_gar');?></strong>
                                        <div class="languages">
                                            <?php $chinese = __('Chinese', 'ngondro_gar');?>
                                            <?php echo __($plang,'ngondro_gar');?>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    <?php endwhile; endif; wp_reset_postdata();?>
                    
                    <!-- chinese trainers -->
                    <?php
                        $args = array (
                            'post_type' => $type,
                            'posts_per_page'=> -1,
                            'suppress_filters' => true,
                            'meta_key' => 'first_name',
                            'orderby' => 'meta_value',
                            'order' => 'ASC',
                            'hide_empty' => true,
                            'meta_query' => array(
                                array(
                                    'key' => 'availability',
                                    'value' => 'yes',
                                    'compare' => '='
                                ),
                                array(
                                    'key' => 'primary_language',
                                    'value' => 'Chinese',
                                    'compare' => '='
                                )
                            )
                        );

                    $chinese_trainers = new WP_Query($args);
                    if($chinese_trainers -> have_posts()) :   
                        $index = 0;
                        while ($chinese_trainers -> have_posts()) : $chinese_trainers ->the_post();
                            $post_id = get_the_ID();
                            $instructor_name = get_the_title($post_id);
                            $language[] = get_field('primary_language',$post_id);
                            $plang = __(get_field('primary_language', $post_id),'ngondro_gar');
                            $secondary_languages = get_field('secondary_languages',$post_id);
                            $languages = array_unique(array_merge($language, $secondary_languages));
                            $languages = implode(', ', $languages);
                            $image = get_field('instructor_photo',$post_id);
                            $ins_id = get_field('instructor', $post_id);
                            $filter_lang = get_field('primary_language',$post_id);
							$wpml_lang = get_field('wpml_language',$post_id);
                            $is_sel = ($index==0)?"checked":"";

                    ?>
        
                        <div class="col-lg-3 col-md-6 col-sm-6 chinese_instructions" data-lang="<?=strtolower($filter_lang)?>" data-wpml="<?=$wpml_lang?>" style="display:none;">
                            <div class="register_instructor_box">
                            <a class="ajax-popup" href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=instructor_popup_ajax&post_id=<?=$post_id?>"><img src="<?php echo get_template_directory_uri();?>/assets/images/eye.svg" alt="eye-icon"/></a>
                                <input type="radio" id="cinstructor-<?=$post_id?>" class="form-instructor-input" name="instructor" value="<?=$ins_id?>" required>
                                <label class="form-instructor-label" for="cinstructor-<?=$post_id?>">
                                    <img class="rounded-circle" src="<?=$image?>" alt="instructor-name"/>
                                    <div class="instructor-name"><?= $instructor_name?></div>
                                    <div class="instructor-languages-wrapper">
                                        <strong><?php echo __('Language:','ngondro_gar');?></strong>
                                        <div class="languages">
                                            <?php echo __($plang,'ngondro_gar');?>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    <?php endwhile; endif; wp_reset_postdata();?>
                    
                    </div>
                    <div class="col-md-12 mt-10">
                        <div class="row">
                            <div class="col-md-6 col-6">
                            <button class="button w-100 btn-navigate-form-step btn btn-lg btn-tranparent back" type="button" step_number="3"><?php echo __('Previous','ngondro_gar');?></button>
                            </div>
                            <div class="col-md-6  col-6">
                            <button id="registration_form" class="button  w-100 submit-btn btn btn-lg btn-default submit" type="submit"><?php echo __('Submit','ngondro_gar');?></button>
                            </div>
                        </div>
                        <div class="row">
                            <p class="alert alert-info error_msg"></p>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="modal fade" id="instructionModalToggle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-labelledby="instructionModalToggleLabel" tabindex="-1">
        <div class="modal-dialog custom-registration-instruction-popup">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalToggleLabel"><?php echo __('Registration Instruction','ngondro_gar');?></h5>
                </div>
                <div class="modal-body">
                <?php 
                    $instruction_title = get_field('instruction_title', get_the_ID());
                    $instructions = get_field('instructions');
                    ?>
                    <p><?php echo __($instruction_title,'ngondro_gar'); ?></p>
                    <?php
                    if( $instructions ) {
                        echo '<ol>';
                        foreach( $instructions as $instruction ) {
                            $instruction = $instruction['instruction'];
                            echo '<li>';
                            echo  __($instruction,'ngondro_gar');
                            echo '</li>';
                        }
                        echo '</ol>';
                    } ?>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-lg btn-default" data-bs-dismiss="modal"><?php echo __('I have read this instruction','ngondro_gar');?></button>
                </div>
            </div>
        </div>
    </div>
  
</div>
<!-- /.MultiStep Form -->
</div>
</section>
<?php get_footer();?>

<script>
    /* Filter by language */
    jQuery(`.filter_ins_section`).hide();
    let current_lang = "<?php echo $current_lang ?>";
    if(current_lang=="en")
    {
        current_lang = "english";
        jQuery(`.not_chinese_instructions[data-lang='portugues'`).show();
    }
    else if(current_lang=="pt-pt")
    {
        current_lang = "portugues";
        jQuery(`.filter_ins_section[data-lang='english'`).show();
    }
    else if(current_lang=="es")
    {
        current_lang = "spanish";
    }
    else if(current_lang=="zh-hans")
    {
        current_lang = "zh-hans";
    }
    else if(current_lang=="zh-hant")
    {
        current_lang = "zh-hant";
    }
	else
    {
        current_lang = "en";
	}
    jQuery(`.not_chinese_instructions[data-lang=${current_lang}]`).show(); 
    jQuery(`.chinese_instructions[data-wpml=${current_lang}]`).show(); 
    
    jQuery(document).on('change','.filter_lang', function(){
        jQuery('#instructor-error').remove();
        jQuery('.register_instructor_box').each(function(){
            jQuery(this).find('.form-instructor-input').prop('checked', false);
        });

        let selected_lang = jQuery(this).val();
        let selected_lang_class = selected_lang;
        let compare_lang = "english";
        if(selected_lang=="zh-hant" || selected_lang=="zh-hans" ){compare_lang="chinese";}
        else if(selected_lang=="pt-br" ){compare_lang="portugues"}
        else {compare_lang="english"}
	    console.log(selected_lang, "test");
        if(compare_lang=="chinese"){
            jQuery(`.chinese_instructions`).hide();
            jQuery(`.chinese_instructions[data-wpml=${selected_lang_class}]`).show(); 
            jQuery(`.filter_ins_section`).hide(); 
        }
        else if(compare_lang=="english"){
            jQuery(`.chinese_instructions`).hide(); 
            jQuery(`.filter_ins_section`).hide();
            jQuery(`.not_chinese_instructions[data-lang='portugues'`).show();
            jQuery(`.filter_ins_section[data-lang=${compare_lang}]`).show();
        }
        else if(compare_lang=="portugues"){
            jQuery(`.chinese_instructions`).hide(); 
            jQuery(`.filter_ins_section`).hide();
            jQuery(`.filter_ins_section[data-lang='english'`).show();
            jQuery(`.filter_ins_section[data-lang=${compare_lang}]`).show();
        }
        else{
            jQuery(`.chinese_instructions`).show(); 
            jQuery(`.filter_ins_section`).show();
        }

    });
    var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
    jQuery(window).on('load', function() {
        var success = getUrlParameter('success');
        if(!success){
            jQuery('#instructionModalToggle').modal('show');
        }
       
    });
</script>