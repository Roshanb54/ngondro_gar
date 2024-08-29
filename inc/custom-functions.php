<?php
/* custom functions */
// // ======= LOGIN FORM =====>

// return form #1
// usage: $result = get_custom_form_login();

/*
* @desc custom login form
* @returns {get_custom_error} [Value] Returns error message
* @function {get_custom_success} [Value] Returns success message
* @returns {is_user_logged_in()} Return true of false based on user loggedin info
*/
function get_custom_form_login($redirect = false)
{
    global $custom_form_count;
    ++$custom_form_count;
    if (!is_user_logged_in()) :
        $return = "<form action=\"\" method=\"post\" class=\"custom_form custom_form_login\">\r\n";
        $error = get_custom_error($custom_form_count);
        $my_current_lang = apply_filters( 'wpml_current_language', NULL );
        if ($error)
            $return .= "<p class=\"error\">{$error}</p>\r\n";
        $success = get_custom_success($custom_form_count);
        if ($success)
            $return .= "<p class=\"success\">{$success}</p>\r\n";

        $return .= "<div class=\"form-floating mt-3 mb-7 \"><i class=\"custom-user-icon\"></i>
	  <input class=\"form-control\" type=\"text\" id=\"custom_username\" placeholder=\"Username or Email\" maxlength=\"50\" name=\"custom_username\"/>
	  <label for=\"custom_username\">" . __('Username or Email', 'custom_login') . "</label>
	  </div>\r\n";

        $return .= "<div class=\"form-floating mt-3 mb-3 \"><i class=\"custom-key-icon\"></i>
	  <input class=\"form-control\" type=\"password\" id=\"custom_password\" placeholder=\"Password\" maxlength=\"50\" name=\"custom_password\"/>
	  <label for=\"custom_password\">" . __('Password', 'custom_login') . "</label>
	  <a href=\"javascript:void(0);\" class=\"password-visibility\"><i class=\"far fa-eye\"></i></a>
	  </div>\r\n";
        if($my_current_lang == 'zh-hans'){
            $return .= "<a class=\"forgot-link\" href=" . site_url('/wp-login.php?action=lostpassword&lang=zh-hans') . ">" . __('Forgot password ?', 'custom_login') . "</a>";
            
        }
        elseif($my_current_lang=='zh-hant'){
            $return .= "<a class=\"forgot-link\" href=" . site_url('/wp-login.php?action=lostpassword&lang=zh-hant') . ">" . __('Forgot password ?', 'custom_login') . "</a>";
            
        }
        elseif($my_current_lang== 'pt-pt'){
            $return .= "<a class=\"forgot-link\" href=" . site_url('/wp-login.php?action=lostpassword&lang=pt-pt') . ">" . __('Forgot password ?', 'custom_login') . "</a>";
        }
        elseif($my_current_lang == 'es'){
            $return .= "<a class=\"forgot-link\" href=" . site_url('/wp-login.php?action=lostpassword&lang=es') . ">" . __('Forgot password ?', 'custom_login') . "</a>";

        }else {
        $return .= "<a class=\"forgot-link\" href=" . wp_lostpassword_url() . ">" . __('Forgot password ?', 'custom_login') . "</a>";
        }
        if ($redirect)
            $return .= "  <input type=\"hidden\" name=\"redirect\" value=\"{$redirect}\">\r\n";

        $return .= "  <input type=\"hidden\" name=\"custom_action\" value=\"login\">\r\n";
        $return .= "  <input type=\"hidden\" name=\"custom_form\" value=\"{$custom_form_count}\">\r\n";
        $return .= "  <button class=\"btn btn-lg btn-default w-100\" type=\"submit\">" . __('Login', 'custom_login') . "</button>\r\n";
        $return .= "</form>\r\n";
        $return .= "<div class=\"register-link mt-8\">" .''. "<a href=" . home_url('/') . 'register' . ">" . __('<strong>Register here</strong> ', 'custom_login') ."</div>";
        $return .= "<div class=\"register-link mt-2\">" .''. "<a href=" . home_url('/') . 'register' . "></a>". __('Please read this attentively before registering:', 'custom_login') . " <a href=" . home_url('/') . 'for-prospective-students' . ">" . __(' overview ', 'custom_login') . "</a></div>";
    else :
        $return = __('User is logged in.<br>', 'custom_login');
        $return .= "<a href=" . wp_logout_url(home_url()) . ">" . __('Logout', 'custom_login') . "</a>";
    endif;
    return $return;
}
// print form #1
/* usage: <?php the_custom_form_login(); ?> */
function the_custom_form_login($redirect = false)
{
    echo get_custom_form_login($redirect);
}

// shortcode for form custom login 
// usage: [custom_form_login] in post/page content
add_shortcode('custom_form_login', 'custom_form_login_shortcode');
function custom_form_login_shortcode($atts, $content = false)
{
    $atts = shortcode_atts(array(
        'redirect' => false
    ), $atts);
    return get_custom_form_LOGIN($atts['redirect']);
}

// <============== FORM LOGIN


// ======= FORM REGISTER =====>

// return form #2
// usage: $result = get_custom_form_register();

/*
* @desc custom registration form
* @returns {get_custom_error} [Value] Returns error message
* @returns {get_custom_success} [Value] Returns success message
* @returns {is_user_logged_in()} Return true of false based on user loggedin info
*/

function get_custom_form_register($redirect = false)
{
    global $custom_form_count;
    ++$custom_form_count;
    if (!is_user_logged_in()) :
        $return = "<form action=\"\" method=\"post\" class=\"custom_form custom_form_register\">\r\n";
        $error = get_custom_error($custom_form_count);
        if ($error)
            $return .= "<p class=\"error\">{$error}</p>\r\n";
        $success = get_custom_success($custom_form_count);
        if ($success)
            $return .= "<p class=\"success\">{$success}</p>\r\n";

        // add as many inputs, selects, textareas as needed
        $return .= "  <p>
		<label for=\"custom_username\">" . __('Username', 'custom_login') . "</label>
		<input type=\"text\" id=\"custom_username\" name=\"custom_username\"/>
	  </p>\r\n";
        $return .= "  <p>
		<label for=\"custom_email\">" . __('Email', 'custom_login') . "</label>
		<input type=\"email\" id=\"custom_email\" name=\"custom_email\"/>
	  </p>\r\n";

        // where to redirect on success
        if ($redirect)
            $return .= "  <input type=\"hidden\" name=\"redirect\" value=\"{$redirect}\">\r\n";

        $return .= "  <input type=\"hidden\" name=\"custom_action\" value=\"register\">\r\n";
        $return .= "  <input type=\"hidden\" name=\"custom_form\" value=\"{$custom_form_count}\">\r\n";

        $return .= "  <button type=\"submit\">" . __('Register', 'custom_login') . "</button>\r\n";
        $return .= "</form>\r\n";
    else :
        $return = __('User is logged in.', 'custom_login');
    endif;
    return $return;
}

// print form #1
/* usage: <?php the_custom_form_register(); ?> */
function the_custom_form_register($redirect = false)
{
    echo get_custom_form_register($redirect);
}

// shortcode for form #1
// usage: [custom_form_register] in post/page content
add_shortcode('custom_form_register', 'custom_form_register_shortcode');
function custom_form_register_shortcode($atts, $content = false)
{
    $atts = shortcode_atts(array(
        'redirect' => false
    ), $atts);
    return get_custom_form_register($atts['redirect']);
}

// <============== LOGIN FORM

// <============== FORGOT PASSWORD FORM

/*
* @desc custom gorgot password form
* @returns {get_custom_error} [Value] Returns error message
* @returns {get_custom_success} [Value] Returns success message
* @returns {is_user_logged_in()} Return true of false based on user loggedin info
*/

function get_custom_form_forgot_password($redirect = false)
{
    global $custom_form_count;
    ++$custom_form_count;
    if (!is_user_logged_in()) :
        $return = "<form action=\"\" method=\"post\" class=\"custom_form custom_form_forgot_password\">\r\n";
        $error = get_custom_error($custom_form_count);
        if ($error)
            $return .= "<p class=\"error\">{$error}</p>\r\n";
        $success = get_custom_success($custom_form_count);
        if ($success)
            $return .= "<p class=\"success\">{$success}</p>\r\n";


        $return .= "<div class=\"mt-3 mb-3 \">
      <input class=\"form-control\" type=\"email\" id=\"custom_email\" placeholder=\"Email\" name=\"custom_email\"/>
      </div>\r\n";

        if ($redirect)
            $return .= "  <input type=\"hidden\" name=\"redirect\" value=\"{$redirect}\">\r\n";

        $return .= "  <input type=\"hidden\" name=\"custom_action\" value=\"forgot_password\">\r\n";
        $return .= "  <input type=\"hidden\" name=\"custom_form\" value=\"{$custom_form_count}\">\r\n";
        $return .= "  <button class=\"btn btn-lg btn-default w-100\" type=\"submit\">" . __('Send', 'custom_login') . "</button>\r\n";
        $return .= "</form>\r\n";
    else :
        $return = __('User is logged in.<br>', 'custom_login');
        $return .= "<a href=" . wp_logout_url(home_url()) . ">" . __('Logout', 'custom_login') . "</a>";
    endif;
    return $return;
}

// print form #1
/* usage: <?php the_custom_form_login(); ?> */
function the_custom_form_forgot_password($redirect = false)
{
    echo get_custom_form_forgot_password($redirect);
}

// shortcode for form #1
// usage: [custom_form_login] in post/page content
//add_shortcode('custom_form_forgot_password_shortcode', 'custom_form_forgot_password_shortcode');
//function custom_form_forgot_password_shortcode($atts, $content = false)
//{
//    $atts = shortcode_atts(array(
//        'redirect' => false
//    ), $atts);
//    return get_custom_form_forgot_password($atts['redirect']);
//}

// <============== Change PASSWORD FORM

/*
* @desc custom change Password form
* @returns {get_custom_error} [Value] Returns error message
* @returns {get_custom_success} [Value] Returns success message
* @returns {is_user_logged_in()} Return true of false based on user loggedin info
* @returns {wp_logout_url()} Return the URL that allows the user to log out of the site
*/

function get_custom_form_change_password($redirect = false)
{
    global $custom_form_count;
    ++$custom_form_count;
    if (!is_user_logged_in()) :
        $return = "<form action=\"\" method=\"post\" class=\"custom_form custom_form_change_password\">\r\n";
        $error = get_custom_error($custom_form_count);
        if ($error)
            $return .= "<p class=\"error\">{$error}</p>\r\n";
        $success = get_custom_success($custom_form_count);
        if ($success)
            $return .= "<p class=\"success\">{$success}</p>\r\n";


        $return .= "<div class=\"mt-3 mb-3 \">
      <input class=\"form-control\" type=\"password\" id=\"custom_password\" placeholder=\"Password\" name=\"custom_password\"/>
      </div>\r\n";

        $return .= "<div class=\"mt-3 mb-3 \">
      <input class=\"form-control\" type=\"password\" id=\"custom_confirm_password\" placeholder=\"Confirm New Password\" name=\"custom_confirm_password\"/>
      </div>\r\n";

        if ($redirect)
            $return .= "  <input type=\"hidden\" name=\"redirect\" value=\"{$redirect}\">\r\n";

        $return .= "  <input type=\"hidden\" name=\"custom_action\" value=\"change_password\">\r\n";
        $return .= "  <input type=\"hidden\" name=\"custom_form\" value=\"{$custom_form_count}\">\r\n";
        $return .= "  <button class=\"btn btn-lg btn-default w-100\" type=\"submit\">" . __('Send', 'custom_login') . "</button>\r\n";
        $return .= "</form>\r\n";
    else :
        $return = __('User is logged in.<br>', 'custom_login');
        $return .= "<a href=" . wp_logout_url(home_url()) . ">" . __('Logout', 'custom_login') . "</a>";
    endif;
    return $return;
}

// print form #1
/* usage: <?php the_custom_form_login(); ?> */
function the_custom_form_change_password($redirect = false)
{
    echo get_custom_form_change_password($redirect);
}

// shortcode for form #1
// usage: [custom_form_login] in post/page content
add_shortcode('custom_form_change_password_shortcode', 'custom_form_change_password_shortcode');
function custom_form_change_password_shortcode($atts, $content = false)
{
    $atts = shortcode_atts(array(
        'redirect' => false
    ), $atts);
    return get_custom_form_change_password($atts['redirect']);
}


// ============ FORM SUBMISSION HANDLER
add_action('init', 'custom_handle');
function custom_handle()
{
    $success = false;
    if (isset($_REQUEST['custom_action'])) {
        switch ($_REQUEST['custom_action']) {
            case 'login':
                if (!$_POST['custom_username']) {
                    set_custom_error(__('<strong>ERROR</strong>: Empty username', 'custom_login'), $_REQUEST['custom_form']);
                } else if (!$_POST['custom_password']) {
                    set_custom_error(__('<strong>ERROR</strong>: Empty password', 'custom_login'), $_REQUEST['custom_form']);
                } else {
                    $creds = array();
                    $creds['user_login'] = $_POST['custom_username'];
                    $creds['user_password'] = $_POST['custom_password'];
                    $creds['remember'] = true;
                    $user = wp_signon($creds);
                    if (is_wp_error($user)) {
                        set_custom_error($user->get_error_message(), $_REQUEST['custom_form']);
                    } else {
                        set_custom_success(__('Log in successful', 'custom_login'), $_REQUEST['custom_form']);
                        $success = true;
                        $user_meta = get_user_meta($user->ID);
                        $user_language = $user_meta['language'][0];
                        if (in_array('administrator', (array)$user->roles)) {
                            wp_redirect(admin_url());
                            exit();
                        } else if (in_array('student', (array)$user->roles)) {
                            if($user_language == 'zh-hant'){
                                wp_redirect(site_url('/zh-hant/儀表板/'));
                            }elseif($user_language == 'zh-hans'){
                                wp_redirect(site_url('/zh-hans/仪表板/'));
                            }elseif($user_language == 'pt-br'){
                                wp_redirect(site_url('/pt-pt/painel/'));
                            }elseif($user_language == 'es'){
                                wp_redirect(site_url('/es/panel/'));
                            }
                            else{
                                wp_redirect(home_url('/dashboard/'));
                            }
                            exit();
                        } else {
                            wp_redirect(home_url('/'));
                            exit();
                        }

                        exit();
                    }
                }
                break;
            case 'register':
                if (!$_POST['custom_username']) {
                    set_custom_error(__('<strong>ERROR</strong>: Empty username', 'custom_login'), $_REQUEST['custom_form']);
                } else if (!$_POST['custom_email']) {
                    set_custom_error(__('<strong>ERROR</strong>: Empty email', 'custom_login'), $_REQUEST['custom_form']);
                } else {
                    $creds = array();
                    $creds['user_login'] = $_POST['custom_username'];
                    $creds['user_email'] = $_POST['custom_email'];
                    $creds['user_pass'] = wp_generate_password();
                    $creds['role'] = get_option('default_role');
                    //$creds['remember'] = false;
                    $user = wp_insert_user($creds);
                    if (is_wp_error($user)) {
                        set_custom_error($user->get_error_message(), $_REQUEST['custom_form']);
                    } else {
                        set_custom_success(__('Registration successful. Your password will be sent via email shortly.', 'custom_login'), $_REQUEST['custom_form']);
                        wp_new_user_notification($user, $creds['user_pass']);
                        $success = true;
                    }
                }
                break;
            // add more cases if you have more forms
            case 'forgot_password':
                if (!$_POST['custom_email']) {
                    set_custom_error(__('<strong>ERROR</strong>: Empty email', 'custom_login'), $_REQUEST['custom_form']);
                }else {
                    $user_email = $_POST['custom_email'];
                    // format the message
                    if(email_exists($user_email)){
                        $message = "<p> Well it seems you have forgotten your password. \n\n </p>";
                        $message .= "<p>To  reset your password, visit the following address:\r\n\r\n</p>";
                        $message .= "<p>or click the below link :\r\n\r\n</p><a href='" . esc_url(home_url('/change-password-before-login/')) . "'>Click Here!</a></p>";

                        $subject = "Forgot Password";
                        $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
                        $headers[] = "X-Mailer: PHP \r\n";
                        $headers[] = 'From: NGONDRO GAR < ' . get_option('admin_email') . '>' . "\r\n";
                        // send the mail
                        wp_mail($user_email, $subject, $message, $headers);
                    }
                    else{
                        set_custom_error(__('<strong>ERROR</strong>: Email Not Found !!!', 'custom_login'), $_REQUEST['custom_form']);
                    }
                }
                break;
            case 'change_password':

                break;


        }

        // if redirect is set and action was successful
        if (isset($_REQUEST['redirect']) && $_REQUEST['redirect'] && $success) {
            wp_redirect($_REQUEST['redirect']);
            die();
        }
    }
}


// ================= UTILITIES

if (!function_exists('set_custom_error')) {
    function set_custom_error($error, $id = 0)
    {
        $_SESSION['custom_error_' . $id] = $error;
    }
}
// shows error message
if (!function_exists('the_custom_error')) {
    function the_custom_error($id = 0)
    {
        echo get_custom_error($id);
    }
}

if (!function_exists('get_custom_error')) {
    function get_custom_error($id = 0)
    {
        if (isset($_SESSION['custom_error_' . $id]) && $_SESSION['custom_error_' . $id]) {
            $return = $_SESSION['custom_error_' . $id];
            unset($_SESSION['custom_error_' . $id]);
            return $return;
        } else {
            return false;
        }
    }
}
if (!function_exists('set_custom_success')) {
    function set_custom_success($error, $id = 0)
    {
        $_SESSION['custom_success_' . $id] = $error;
    }
}
if (!function_exists('the_custom_success')) {
    function the_custom_success($id = 0)
    {
        echo get_custom_success($id);
    }
}

if (!function_exists('get_custom_success')) {
    function get_custom_success($id = 0)
    {
        if (isset($_SESSION['custom_success_' . $id]) && $_SESSION['custom_success_' . $id]) {
            $return = $_SESSION['custom_success_' . $id];
            unset($_SESSION['custom_success_' . $id]);
            return $return;
        } else {
            return false;
        }
    }
}

add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');


/*
* @desc save user custom meta filed value
* @returns {get_the_author_meta} [Value] returns the data for use programmatically
* @returns {update_user_meta} Returns success message
* @returns {current_user_can()} Returns whether the current user has the specified capability.
*/

function my_save_extra_profile_fields($user_id)
{

    if (!current_user_can('edit_user', $user_id))
        return false;
    update_user_meta($user_id, 'region', $_POST['region']);
    update_user_meta($user_id, 'phone', $_POST['phone']);
    update_user_meta($user_id, 'motivation', $_POST['motivation']);
    update_user_meta($user_id, 'experience', $_POST['experience']);
    update_user_meta($user_id, 'history', $_POST['history']);
    update_user_meta($user_id, 'obstacles', $_POST['obstacles']);
    //update_user_meta( $user_id, 'dd_participant', $_POST['dd_participant'] );

    /*custom code*/
    update_user_meta($user_id, 'social_icon', $_POST['register_social_icon']);
    update_user_meta($user_id, 'sociallink', $_POST['sociallink']);
    update_user_meta($user_id, 'city', $_POST['city']);
    update_user_meta($user_id, 'address', $_POST['address']);
    update_user_meta($user_id, 'dharm_das', $_POST['dharm_das']);
    update_user_meta($user_id, 'language', $_POST['language']);
    update_user_meta($user_id, 'track', $_POST['track']);
    update_user_meta($user_id, 'curriculum', $_POST['curriculum']);

    update_user_meta($user_id, 'filter_by_language', $_POST['filter_by_language']);

    update_user_meta($user_id, 'graduate', $_POST['graduate']);
    update_user_meta($user_id, 'exempt', $_POST['exempt']);
    update_user_meta($user_id, 'note', $_POST['note']);

    //update_user_meta( $user_id, 'ng_user_approve_status',  $_POST['ng_user_approve_status']  );
    /*end*/

    /*send changes the instructor of a student, send an email to both the old and new instructor */

    $instructor = get_the_author_meta('instructor', $user->ID);
    // send_both_instructor_msg($instructor, $_POST['instructor'], $user_id);

    update_user_meta($user_id, 'instructor', $_POST['instructor']);

    update_user_meta($user_id, 'profile_image', $_POST['profile_image']);

}

add_filter('user_contactmethods', 'custom_user_contactmethods');
function custom_user_contactmethods($user_contact)
{
    $user_contact['user_phone'] = 'Phone number';
    return $user_contact;
}

/* Save selected data */
add_action('personal_options_update', 'save_user_fields');
add_action('edit_user_profile_update', 'save_user_fields');

function save_user_fields($user_id)
{

    if (!current_user_can('edit_user', $user_id))
        return false;

    update_usermeta($user_id, 'country', $_POST['country']);
}

add_action('show_user_profile', 'Add_user_fields');
add_action('edit_user_profile', 'Add_user_fields');

/*
* @desc add/display custom field in admin panel
* @returns {get_the_author_meta} [Value] returns the data for use programmatically
* @returns {is_user_logged_in()} Return true of false based on user loggedin info
*/

function Add_user_fields($user)
{
    ?>

    <h3>Additional Information</h3>
    <table class="form-table">

        <tr>
            <th><label for="dropdown">Select Region</label></th>
            <td>
                <?php
                //get dropdown saved value
                global $wpdb;
                $selected_region = get_the_author_meta('region', $user->ID);
                $countries = $wpdb->get_results("Select * From `countries_data`");
                ?>
                <!--
                <select id="region" name="region">
                    <option value=""><?php echo __('Select Your Region', 'ngondro_gar'); ?></option>
                    <?php
                    //$region = $selected_region;
                    //foreach ($countries as $data): $selected = ($data->iso == $region) ? "selected" : ""; ?>
                        <option value="<?= $data->iso ?>" <?= $selected ?>><?= $data->name ?></option>
                    <?php //endforeach; ?>
                </select>
                -->
                <input type="text" name="region" value="<?=$selected_region?>">
            </td>
        </tr>
    </table>

    <h3>Buddhist Background</h3>
    <p>In order for the instructors to better understand your background and current situation, would you please tell us
        about yourself through answering a few questions.</p>
    <table class="form-table">
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

        <tr>
            <th><label for="motivation"> 1.Please share your motive to join Ngondro Gar.</label></th>
            <td>
                <textarea id="edit-motivation" name="motivation" cols="30" rows="4"
                          class="form-textarea"><?php if ($motivation): echo $motivation;endif; ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="experience">2.Please list your most significant Buddhist practice and training experience.
                    You might list refuge and bodhisattva vow taken, main empowerments received, training programs
                    attended, retreats undertaken, affiliation with practice groups or meditation centers. Please
                    include approximate dates, durations and teachers as applicable.</label></th>
            <td>
                <textarea id="edit-experience" name="experience" cols="30" rows="4"
                          class="form-textarea"><?php if ($experience): echo $experience;endif; ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="history">3.Have you met Dzongsar Khyentse Rinpoche and have you received teachings from
                    him?</label></th>
            <td>

                <textarea id="edit-history" name="history" cols="30" rows="4"
                          class="form-textarea"><?php if ($history): echo $history;endif; ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="obstacles">4.Which practice track are you planning to join? What kind of obstacles will
                    likely arise, and how will you handle these obstacles?</label></th>
            <td>

                <textarea id="edit-obstacles" name="obstacles" cols="30" rows="4"
                          class="form-textarea"><?php if ($obstacles): echo $obstacles;endif; ?></textarea>
            </td>
        </tr>

        <tr>
            <th><label for="dharm_das">5.Dharma Das</label></th>
            <td>
                <textarea id="edit-dharm_das" name="dharm_das" cols="30" rows="4" class="form-textarea"><?php if ($dharm_das): echo $dharm_das;endif; ?></textarea>
            </td>
        </tr>

        <!--<tr>
		  <th><label for="dd_participant">5. Have you practiced in Dharma Das?</label></th>
		  <td>
		  <div id="edit-dd-participant" class="form-radios">
			  <div class="form-item form-type-radio form-item-dd-participant">
				<input type="radio" id="edit-dd-participant-1" name="dd_participant" value="1" <?php echo ($dd_participant == 1) ? 'checked="checked"' : ''; ?>  class="form-radio">  <label class="option" for="edit-dd-participant-1">Yes </label>

				</div>
				<div class="form-item form-type-radio form-item-dd-participant">
				<input type="radio" id="edit-dd-participant-0" name="dd_participant" value="0" <?php echo ($dd_participant == 0 || $dd_participant == '') ? 'checked="checked"' : ''; ?> class="form-radio">  <label class="option" for="edit-dd-participant-0">No </label>
				</div>
			</div>
		  </td>
	  </tr>-->

        <!-- custom code -->
        <tr>
            <th><label for="edit-address">Address</label></th>
            <td>
                <input type="text" id="edit-address" name="address" value="<?= $address ?>">
            </td>
        </tr>
        
        <tr>
            <th><label for="edit-city">City</label></th>
            <td>
                <input type="text" id="edit-city" name="city" value="<?= $city ?>">
            </td>
        </tr>

        

        <tr>
            <th><label for="sociallink">Social Icon</label></th>
            <td>
                <select id="register_social_icon" name="register_social_icon" class="custom-select" placeholder="---"
                        aria-invalid="false">
                    <option value=""> Select</option>
                    <option value="whatsapp" <?php echo ($social_icon == "whatsapp") ? 'selected="selected"' : ''; ?>>
                        WhatsApp
                    </option>
                    <option value="telegram" <?php echo ($social_icon == "telegram") ? 'selected="selected"' : ''; ?>>
                        Telegram
                    </option>
                    <option value="wechat" <?php echo ($social_icon == "wechat") ? 'selected="selected"' : ''; ?>>
                        WeChat
                    </option>
                </select>
                <input type="text" id="edit-sociallink" name="sociallink" value="<?= $sociallink ?>"
                       placeholder="User ID">
            </td>
        </tr>

        <tr>
            <th><label for="prefered_language">Language Preference</label></th>
            <td>
                <select id="prefered_language" name="language" class="form-control form-select" aria-invalid="false">
                    <option value="en" <?php echo ($language == "en") ? 'selected="selected"' : ''; ?>>English</option>
                    <option value="zh-hant" <?php echo ($language == "zh-hant") ? 'selected="selected"' : ''; ?>>繁體中文
                    </option>
                    <option value="zh-hans" <?php echo ($language == "zh-hans") ? 'selected="selected"' : ''; ?>>简体中文
                    </option>
                    <option value="pt-br" <?php echo ($language == "pt-br") ? 'selected="selected"' : ''; ?>>Português
                    </option>
                    <option value="es" <?php echo ($language == "es") ? 'selected="selected"' : ''; ?>>Spanish
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="prefered_language">Filter By Language</label></th>
            <td>
                <select id="filter_by_language" name="filter_by_language" class="form-control form-select"
                        aria-invalid="false">
                    <option value="en" <?php echo ($filter_by_language == "en") ? 'selected="selected"' : ''; ?>>
                        English
                    </option>
                    <option value="zh-hant" <?php echo ($filter_by_language == "zh-hant") ? 'selected="selected"' : ''; ?>>
                        繁體中文
                    </option>
                    <option value="zh-hans" <?php echo ($filter_by_language == "zh-hans") ? 'selected="selected"' : ''; ?>>
                        简体中文
                    </option>
                    <option value="pt-br" <?php echo ($filter_by_language == "pt-br") ? 'selected="selected"' : ''; ?>>
                        Português
                    </option>
                    <option value="es" <?php echo ($filter_by_language == "es") ? 'selected="selected"' : ''; ?>>
                        Spanish
                    </option>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="track"> Practice Track </label></th>

            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="track"
                           value="0.5" <?php echo ($track == "0.5") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="track">0.5 hr a day</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="track"
                           value="1" <?php echo ($track == "1") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="track">1 hr a day</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="track"
                           value="1.5" <?php echo ($track == "1.5") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="track">1.5 hrs a day</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="track"
                           value="2" <?php echo ($track == "2") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="track">2 hrs a day</label>
                </div>
            </td>
        </tr>

        <tr>
            <th><label for="curriculum">Curriculum</label></th>
            <td>
                <div class="mt-3 mb-3">
                    <?php
                    $terms = $wpdb->get_results("Select * From ngondro_courses");
                    $index = 1;
                    foreach ($terms as $term):
                        $short_name = $term->short_name;
                        $permalink = home_url('courses/details?cid=' . $term->course_id);
                        ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inlineRadio<?= $index ?>" type="radio" name="curriculum"
                                   value="<?= $term->course_id ?>" <?php echo ($curriculum == $term->course_id) ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="inlineRadio<?= $index ?>"><?= $term->title ?></label>
                        </div>
                        <?php $index++; endforeach; ?>
                </div>
            </td>
        </tr>

        <tr>
            <th><label for="edit-instructor">Instructor</label></th>
            <td>
                <!--  <input type="text" id="edit-instructor" name="instructor" value="<?= $instructor ?>" placeholser="Instructor ID"> -->
                <?php
                $blogusers = get_users(array('role__in' => array('instructor')));
                ?>
                <select id="edit-instructor" name="instructor" class="form-control form-select" aria-invalid="false">
                    <option value="">Select Instructor</option>
                    <?php foreach ($blogusers as $user): ?>
                        <option value="<?= $user->ID ?>" <?php echo ($user->data->ID == $instructor) ? 'selected="selected"' : ''; ?>> <?= $user->data->display_name . '(' . $user->data->user_email . ')'; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="graduate"> Graduation Information </label></th>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="graduate"
                           value="Yes" <?php echo ($graduate == "Yes") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="graduate">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="graduate"
                           value="No" <?php echo ($graduate == "No") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="graduate">No</label>
                </div>
            </td>
        </tr>

        <tr>
            <th><label for="exempt"> Exempt </label></th>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="exempt"
                           value="Yes" <?php echo ($exempt == "Yes") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="exempt">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="exempt"
                           value="No" <?php echo ($exempt == "No") ? 'checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="exempt">No</label>
                </div>
            </td>
        </tr>
        <tr>
            <th><label for="note">Note</label></th>
            <td>
                <textarea id="edit-note" name="note" cols="30" rows="4"
                          class="form-textarea"><?php if ($note): echo $note;endif; ?></textarea>
            </td>
        </tr>

        <tr>
            <th><label for="note">Thumbnail Profile Photo</label></th>
            <td style="display:flex;">
                <input class="form-check-input" type="text" name="profile_image" value="<?= $user_img ?>"
                       placeholder="Profile Photo URL">
                <?php if ($user_img != ""): ?> <img src="<?= $user_img ?>"
                                                    style="width:30px; height:auto;"> <?php endif; ?>
            </td>
        </tr>

  </table>
  <?php 
  }
  
  
  //get all users
  add_action( 'rest_api_init', function () {
  register_rest_route( 'wp/v2', '/getusers/', array(
  'methods' => 'GET',
  'callback' => 'get_users_names'
  ) );
  } );
  
  function get_users_names()
  {
	  global $wpdb;
	  $myArr = array();
	  $wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users ORDER BY ID");
	  
	  foreach ( $wp_user_search as $userid ) {
	  	$myArr[] = stripslashes($userid->display_name);
	  }
	  $myJSON = json_encode($myArr);
	  echo $myJSON;
	  die();
  }
  
  add_filter( 'rest_user_query' , 'custom_rest_user_query' );
  function custom_rest_user_query( $prepared_args, $request = null ) {
	unset($prepared_args['has_published_posts']);
	return $prepared_args;
  }
  
  function get_user_roles($object, $field_name, $request) {
	return get_userdata($object['id'])->roles;
  }

  add_action('rest_api_init', function() {
	register_rest_field('user', 'roles', array(
	  'get_callback' => 'get_user_roles',
	  'update_callback' => null,
	  'schema' => array(
		'type' => 'array'
	  )
	));
  });


//Disable the new user notification sent to the site admin
function smartwp_disable_new_user_notifications()
{
    //Remove original use created emails
    remove_action('register_new_user', 'wp_send_new_user_notifications');
    remove_action('edit_user_created_user', 'wp_send_new_user_notifications', 10, 2);

    //Add new function to take over email creation
    add_action('register_new_user', 'smartwp_send_new_user_notifications');
    add_action('edit_user_created_user', 'smartwp_send_new_user_notifications', 10, 2);
}

function smartwp_send_new_user_notifications($user_id, $notify = 'user')
{
    if (empty($notify) || $notify == 'admin') {
        return;
    } elseif ($notify == 'both') {
        //Only send the new user their email, not the admin
        $notify = 'user';
    }
    wp_send_new_user_notifications($user_id, $notify);
}

add_action('init', 'smartwp_disable_new_user_notifications');


/*
* @desc approve/reject  
* @returns {get_the_author_meta} [Value] returns the data for use programmatically
* @returns {is_user_logged_in()} Return true of false based on user loggedin info
* @returns {update_user_meta} Returns success message
*/

function ng_approve_user($user_id)
{
    $user = new WP_User($user_id);
    wp_cache_delete($user->ID, 'users');
    wp_cache_delete($user->data->user_login, 'userlogins');

    $language = get_the_author_meta('language', $user_id);
    $user_language = get_user_meta($user_id, 'language', true);

    // send email to user telling of approval
    $user_login = stripslashes($user->data->user_login);
    $user_email = stripslashes($user->data->user_email);

    $args = array (
        'post_type' => "user_emails",
        'numberposts'   => 1,
        'suppress_filters' => true,
        'meta_query' => array(
            array(
                'key' => 'email_language',
                'value' => $language,
                'compare' => '='
            ),
            array(
                'key' => 'etype',
                'value' => 'approved',
                'compare' => '='
            )
        )
    );
    
    $posts = get_posts($args);
    
    if($posts){
        $post = $posts[0]; 
        $message = $post->post_content;
        $subject = get_field('subject', $post);
        $message = str_replace("{wp_lostpassword_url}", esc_url(wp_lostpassword_url()), $message);
        $subject = "Registration Approved";
        $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
        $headers[] = "X-Mailer: PHP \r\n";
        $headers[] = 'From: NGONDRO GAR < ' . get_option('admin_email') . '>' . "\r\n";
        // send the mail
        $to = array("ngondro_gar@getnada.com", $user_email);
        wp_mail($to, $subject, $message, $headers);
        // change usermeta tag in database to approved

    }
    else{
        if($user_language == 'zh-hans'){
             // format the message
        $message = "<p><strong> 欢迎加入前行营！\n\n </strong></p>";
        $message .= "<p>请前往以下网址设置账户密码:\r\n\r\n</p>";
        $message .= site_url('/zh-hans/登录/?action=lostpassword&reset=true');
        $message .= "<p>或是点击以下链接 :\r\n\r\n</p><a href='" . site_url('/zh-hans/登录/?action=lostpassword&reset=true') . "'>点击这里!</a></p>";
        $message .= "<p>首次登录后，请阅读仁波切所撰《给所谓“金刚乘“弟子的社交媒体行为准则》。该准则
        位于网站首页管理面板下“其它”一栏中“守则与规范.</p>";
        $message .= "<p>网站“修持资源“ 一栏下提供了大量的学习资料可供参考，及协助您开始修持。敬请了
        解前行营网站上全部的资讯与资源仅供前行营学员使用，切勿在任何社交媒体转发，
        或是与他人分享.</p>";
        $message .= "<p>请于每月的前三天登录网站，上传您前一个月的修持时数。每月底，您将会收到一封
        邮件提醒上传时数，以及通知前行营下一月的活动安排。如果在登录成功一个月后未
        能收到该邮件，且您希望加入该邮件发送名单列表，请联系我们要求订阅的链接.</p>";
        $subject = "注册成功";

        }
        elseif($user_language == 'zh-hant'){
        $message = "<p><strong> 歡迎加入前行營！\n\n </strong></p>";
        $message .= "<p>請前往以下網址設置帳戶密碼:\r\n\r\n</p>";
        $message .= site_url('/zh-hant/登錄/?action=lostpassword&reset=true');
        $message .= "<p>或是點擊以下連結 :\r\n\r\n</p><a href='" . site_url('/zh-hant/登錄/?action=lostpassword&reset=true') . "'>點擊這裡!</a></p>";
        $message .= "<p>首次登錄後，請閱讀仁波切所撰《給所謂“金剛乘“弟子的社交媒體行為準則》。該
        準則位於網站首頁管理面板下“其它”一欄中“守則與規範“。</p>";
        $message .= "<p>網站“修持資源“ 一欄下提供了大量的學習資料可供參考，及協助您開始修持。敬請
        瞭解前行營網站上全部的資訊與資源僅供前行營學員使用，切勿在任何社交媒體轉發
        ，或是與他人分享。</p>";
        $message .= "<p>請於每月的前三天登錄網站，上傳您前一個月的修持時數。每月底，您將會收到一封
        郵件提醒上傳時數，以及通知前行營下一月的活動安排。如果在登錄成功一個月後未
        能收到該郵件，且您希望加入該郵件發送名單列表，請聯繫我們要求訂閱的連結。</p>";
        $subject = "註冊成功";

        }
        elseif($user_language == 'pt-br'){
            // format the message
        $message = "<p><strong> Bem-vindo ao Ngondro Gar!\n\n </strong></p>";
        $message .= "<p>Para definir sua senha, acesse o seguinte endereço:\r\n\r\n</p>";
        $message .= site_url('/pt-pt/conecte-se/?action=lostpassword&reset=true');
        $message .= "<p>or click the below link :\r\n\r\n</p><a href='" . site_url('/pt-pt/conecte-se/?action=lostpassword&reset=true') . "'>Clique aqui!</a></p>";
        $message .= "<p>Por favor, leia a orientação de Rinpoche nas “Diretrizes de redes sociais para os
        assim chamados estudantes vajrayana”, quando você fizer login pela primeira vez.
        As diretrizes estão localizadas em “OUTROS” no painel inicial.</p>";
        $message .= "<p>Existe uma grande variedade de materiais de estudo no website que podem ajudá-
        lo em sua prática. Lembre-se de que todos os recursos são exclusivamente para os
        participantes do Ngongdro Gar. Não os compartilhe nas mídias sociais ou com outras pessoas.</p>";
        $message .= "<p>Por gentileza, informe suas horas de prática do mês anterior no site Ngongdro Gar
        nos primeiros três dias de cada mês. Todos os meses você receberá um e-mail
        lembrando de informar suas horas e contendo anúncios das atividades do Ngondro
        Gar. Caso não receba esse e-mail até o final do mês seguinte e gostaria de ser
        incluído na lista de e-mail, entre em contato conosco para lhe enviarmos um link e
        realizar sua inscrição</p>";
        $subject = "Inscrição aprovada";

        }
        elseif($user_language == 'es'){
        // format the message
        $message = "<p><strong> Bienvenido/a a Ngondro Gar!\n\n </strong></p>";
        $message .= "<p>Para establecer tu contraseña, visita la siguiente dirección:\r\n\r\n</p>";
        $message .= site_url('/es/acceso/?action=lostpassword&reset=true');
        $message .= "<p>O haz clic en el siguiente enlace:\r\n\r\n</p><a href='" . site_url('/es/acceso/?action=lostpassword&reset=true') . "'>Haga clic aquí!</a></p>";
        $message .= "<p>Por favor, lee las directrices de Rinpoche sobre las Redes Sociales para los
        supuestos estudiantes de Vajrayana cuando te registres por primera vez. Las
        directrices se encuentran en el apartado &quot; VARIOS &quot; del panel de control.</p>";
        $message .= "<p>Hay una gran variedad de recursos de estudio en el sitio web que pueden ayudarte
        con tu práctica. Ten en cuenta que todos los recursos son exclusivos para los
        participantes de Ngongdro Gar y no debes compartirlos en las redes sociales ni con
        otras personas.</p>";
        $message .= "<p>Ten la amabilidad de informar de tus horas de práctica del mes anterior en el sitio
        web de Ngongdro Gar dentro de los tres primeros días de cada mes. Recibirás un
        correo electrónico recordatorio con anuncios de las actividades de Ngondro Gar a
        finales de cada mes. Si no has recibido el correo electrónico a finales del mes que
        viene y te gustaría que te incluyéramos en la lista de correo, ponte en contacto con
        nosotros para que te enviemos un enlace para suscribirte.</p>";
        $subject = "Inscripción aprobada";
        }
        else {
        // format the message
        $message = "<p><strong> Welcome to join Ngondro Gar!\n\n </strong></p>";
        $message .= "<p>To set your password, visit the following address:\r\n\r\n</p>";
        $message .= site_url('/login/?action=lostpassword&reset=true');
        $message .= "<p>or click the below link :\r\n\r\n</p><a href='" . site_url('/login/?action=lostpassword&reset=true') . "'>Click Here!</a></p>";
        $message .= "<p>Please read Rinpoche's guidance on Social Media Guidelines for so-called
        Vajrayana students when you log in for the first time. The guidelines is located under
        the “OTHERS” on the dashboard.</p>";
        $message .= "<p>There is a rich variety of study resources on the website that might help you with
        your practice. Please keep in mind that all of the resources are solely for Ngongdro
        Gar participants and do not share them on social media or with others.</p>";
        $message .= "<p>Please kindly report your previous month's practice hours on the Ngongdro Gar
        website within the first three days of each month. You will receive a reminder email
        containing announcements for Ngondro Gar's activities at the end of every month. If
        you haven't received the email by the end of next month and you'd like to be
        included to the mail list, please contact us to send you a link to subscribe.</p>";
        $subject = "Registration Approved";
        }

        $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
        $headers[] = "X-Mailer: PHP \r\n";
        $headers[] = 'From: NGONDRO GAR < ' . get_option('admin_email') . '>' . "\r\n";
        // send the mail
        $to = array("ngondro_gar@getnada.com", $user_email);
        wp_mail($to, $subject, $message, $headers);
        // change usermeta tag in database to approved
    }
    
    update_user_meta($user->ID, 'ng_user_approve_status', 'approved');

    $user = get_user_by('id', $user_id);

    $user_email = $user->data->user_email;
    $user_name = $user->data->display_name;
    
    
    $instructor_id = get_user_meta($user_id, 'instructor')[0];
    $instructor = get_user_by('id', $instructor_id);

    $instructor_email = $instructor->data->user_email;
    $instructor_name = $instructor->data->display_name;
    

    $message = "<p>Dear ".$instructor_name.",<br>";
    $message .= "A New Student has been assigned to you.</p><br><br><br>";
    $message .= "<p>Student Details :</p>";
    $message .= "<p>Student Name: ".$user_name." <br>Email: ".$user_email."</p><br><br>";
    $message .= "<p>Thank You,<br>Ngondro Gar Admin</p>";

    $subject = "New Student assigned ";
    $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
    $headers[] = "X-Mailer: PHP \r\n";
    $headers[] = 'From: NGONDRO GAR < ' . get_option('admin_email') . '>' . "\r\n";
    if($instructor_id == 26){
        $headers[] = 'cc: chunjing9822@163.com'; 
        $headers[] = 'cc: joyceleung1@sina.com'; 
        $headers[] = 'cc: myloft2002@163.com'; 
        $headers[] = 'cc: zuohuizi2008@163.com'; 
    }
    // send the mail
    wp_mail($instructor_email,$subject, $message, $headers);
    

}

add_action('load-users.php', 'update_ng_action');
add_filter('manage_users_columns', 'ng_add_column');
add_filter('user_row_actions', 'ng_user_table_actions', 10, 2);
add_filter('manage_users_custom_column', 'ng_status_column', 10, 3);
add_filter('manage_users_custom_column', 'ng_instructor_column', 10, 3);


function update_ng_action()
{
    if (isset($_GET['action']) && $_GET['action'] == 'approve') {
        $userid = $_GET['user'];
        ng_approve_user($userid);
    } else {
        $userid = $_GET['user'] ?? null;
        update_user_meta($userid, 'ng_user_approve_status', 'decline');
    }
}

function ng_add_column($columns)
{
    $the_columns['ng_user_approval_status_col'] = 'Status';
    $the_columns['ng_instructor'] = 'Instructor';
    $newcol = array_slice($columns, 0, -1);
    $newcol = array_merge($newcol, $the_columns);
    $columns = array_merge($newcol, array_slice($columns, 1));
    return $columns;
}


function ng_status_column($val, $column_name, $user_id)
{
    $status_val = "";
    switch ($column_name) {
        case 'ng_user_approval_status_col':
            $status = get_user_meta($user_id, 'ng_user_approve_status')[0] ?? null;
            if ($status == 'approved') {
                $status_val = "Approved";
            } else if ($status == 'decline') {
                $status_val = "Denied";
            } else if ($status == 'pending') {
                $status_val = "Pending";
            }
            return $status_val;
            break;
        default:
    }
    return $val;
}

function ng_instructor_column($val, $column_name, $user_id)
{
    $status_val = "";
    switch ($column_name) {
        case 'ng_instructor':
            $instructor_id = get_user_meta($user_id, 'instructor')[0] ?? null;
            $instructor = get_user_by('id', $instructor_id);
            $instructor_name = '';
            if($instructor){
               $instructor_name = $instructor->data->display_name;
            }
            return $instructor_name;
            break;
        default:
    }
    return $val;
}


/*
* @desc add actions in wp users table
* @params {get_user_meta} [object] Return all user meta values 
* @returns {get_current_user_id()} Return current user_id
*/
function ng_user_table_actions($actions, $user)
{
    if ($user->ID == get_current_user_id()) {
        return $actions;
    }
    $user_status = get_user_meta($user->ID, 'ng_user_approve_status')[0] ?? null;

    $approve_link = add_query_arg(array('action' => 'approve', 'user' => $user->ID));
    $approve_link = remove_query_arg(array('new_role'), $approve_link);
    $approve_link = wp_nonce_url($approve_link, 'ng_new-user-approve');

    $deny_link = add_query_arg(array('action' => 'deny', 'user' => $user->ID));
    $deny_link = remove_query_arg(array('new_role'), $deny_link);
    $deny_link = wp_nonce_url($deny_link, 'ng_new-user-approve');

    $approve_action = '<a href="' . esc_url($approve_link) . '"> Approve </a>';
    $deny_action = '<a href="' . esc_url($deny_link) . '"> Denied </a>';
    
    $history_link = admin_url("admin.php?page=student_reporting&view=edit&id=$user->ID");
    $report_history = '<a href="' . $history_link . '"> Reporting History </a>';

    if (($key = array_search("resetpassword", $actions)) !== false) {
        unset($actions[$key]);
    }

    if ($user_status == 'pending') {
        $actions[] = $approve_action;
        $actions[] = $deny_action;
    } else if ($user_status == 'approved') {
        $actions[] = $deny_action;
        $actions[] = $report_history;
    } else if ($user_status == 'decline') {
        $actions[] = $approve_action;
    } else {
        $actions[] = $approve_action;
        $actions[] = $deny_action;
    }

    
    
    return $actions;
}


add_filter('wp_authenticate_user', 'authenticate_user');

function authenticate_user($userdata)
{
    $status = get_user_meta($userdata->ID, 'ng_user_approve_status', true);
    if (empty($status)) {
        $status = 'approved';
    }

    if (empty($status)) {
        // the user does not have a status so let's assume the user is good to go
        return $userdata;
    }
    $message = false;
    switch ($status) {
        case 'pending':
            $pending_message = '<strong>ERROR</strong>: Your account is still pending approval.';
            $message = new WP_Error('pending_approval', $pending_message);
            break;
        case 'denied':
            $denied_message = '<strong>ERROR</strong>: Your account has been inactive on this site.';
            $message = new WP_Error('denied_access', $denied_message);
            break;
        case 'decline':
                $denied_message = '<strong>ERROR</strong>: Your account has been denied access to this site.';
                $message = new WP_Error('denied_access', $denied_message);
                break;
        case 'approved':
            $message = $userdata;
            break;
    }
    return $message;
}

/*
* @desc send instructor request
* @returns {get_userdata} [Array] Return users details 
*/
function send_both_instructor_msg($instructor, $new_instructor, $student)
{
    $old_instructor = get_userdata($instructor);
    $old_ins_email = $old_instructor->user_email;
    if(!empty($old_instructor->first_name)){
        $old_ins_name = $old_instructor->first_name . " " . $old_instructor->last_name;
    }
    else {
        $old_ins_name = null ; 
    }
    

    $new_instructor = get_userdata($new_instructor);
    $new_ins_email = $new_instructor->user_email;
    if(!empty($new_instructor->first_name)){
        $new_ins_name = $new_instructor->first_name . " " . $new_instructor->last_name;
    }
    else {
        $new_ins_name = null ; 
    }
    
	if($old_ins_email!=$new_ins_email){
		// changes_instructor_student($old_ins_email, $new_ins_email, $student, $new_ins_name, $old_ins_name);
	}
}


/*
* @desc send instructor request
* @returns {get_option} [value] Return option values 
*/

function changes_instructor_student($old_ins_email, $new_ins_email, $student, $new_ins_name, $old_ins_name)
{

    global $wpdb;
	$user = get_userdata($student);
	$student_name = $user->first_name." ".$user->last_name;
	$student_email = $user->user_email;
	$cid = get_the_author_meta( 'curriculum', $user->data->ID );

	$subjects = $wpdb->get_row("SELECT * from `ngondro_courses` where course_id = '$cid'");

	$message = "<p>Instructor of Student is changed from ".$old_ins_name." to ".$new_ins_name."</p><br><br><br>";
	$message .= "<p>Student Details</p>";
	$message .= "<p>Name: ".$student_name." <br><br>Curriculum: ".$subjects->short_name."<br><br>Email: ".$student_email."</p>";

    $subject = " Change of instructor";
    $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
    $headers[] = "X-Mailer: PHP \r\n";
    $headers[] = 'From: NGONDRO GAR < ' . get_option('admin_email') . '>' . "\r\n";
    // send the mail
	//$old_ins_email = "ngondro_gar@getnada.com";
	//$new_ins_email = "ngondro_gar@getnada.com";
    wp_mail($old_ins_email,$subject, $message, $headers);
    wp_mail($new_ins_email,$subject, $message, $headers);
}


/*student filter by status*/
add_action( 'manage_users_extra_tablenav', 'render_custom_filter_options', 10, 1 );
function render_custom_filter_options($query) {

	$options = $_GET['ng_user_status_filter'];

    if(isset($_GET['ng_user_status_filter']) && $_GET['ng_user_status_filter']=="pending"){
        
        $pending = get_users(array(
            'number' => -1,
            'fields' => array('ID'),
            'count_total'  => true,
            'meta_query'  => array(
                'relation' => 'OR',
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => "pending",
                        'compare' => '='
                    ),
            ),
        ));

        $approved = get_users(array(
            'number' => -1,
            'meta_query'  => array(
                'relation' => 'AND',
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => "approved",
                        'compare' => '='
                    ),
            ),
        ));
    
        $denied = get_users(array(
            'number' => -1,
            'meta_query'  => array(
                'relation' => 'AND',
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => "decline",
                        'compare' => '='
                    ),
            ),
        ));
        update_option("pending_user_count", count($pending));
        // update_option("approved_user_count", count($approved));
        // update_option("denied_user_count", count($denied));

    }
	
    $pending_data = (int)get_option("pending_user_count");

    //var_dump($pending_data, "data");

?>
	
    <a href="<?=admin_url('/users.php?s&action=-1&new_role&ng_user_status_filter=approved&ng_user_btn=Filter&paged=1')?>" class="button action" name="ng_user_btn">Approved Users</a>
    <a href="<?=admin_url('/users.php?s&action=-1&new_role&ng_user_status_filter=decline&ng_user_btn=Filter&paged=1')?>" class="button action" name="ng_user_btn">Denied Users</a>
	<a href="<?=admin_url('/users.php?s&action=-1&new_role&ng_user_status_filter=pending&ng_user_btn=Filter&paged=1')?>" class="button action" name="ng_user_btn">New Request (<?=$pending_data?>)</a>


<?php
}

add_action( 'pre_get_users', 'filter_users_by_student_status', 99, 1 );
function filter_users_by_student_status( $query ) {
	if ( ! is_admin() ) {
		return;
	}
	global $pagenow;

	if ( 'users.php' === $pagenow ) {

		if ( isset( $_GET['ng_user_status_filter'] ) && $_GET['ng_user_status_filter'] !== '0' && !$_GET['ng_user_status_filter']=="" ) 
        {
            $meta_query = array(
				array(
					'key' => 'ng_user_approve_status',
					'value' => $_GET['ng_user_status_filter'],
					'compare' => '='
				)
			);
            
			$query->set( 'meta_query', $meta_query );
		}

        if ( isset( $_GET['ng_user_status_filter_exempt'] )  ) {
            
            $meta_query = array(
				array(
					'key' => 'exempt',
					'value' => $_GET['ng_user_status_filter_exempt'],
					'compare' => '='
				)
			);
			$query->set( 'meta_query', $meta_query );
		}
       
        
	}

    

	return;
}


add_filter( 'default_hidden_columns', 'hide_ad_list_columns', 10, 2 );
function hide_ad_list_columns( $hidden, $screen ) {
    // "edit-advanced_ads" needs to be adjusted to your own screen ID, this one is for my "advanced_ads" post type
    if( isset( $screen->id ) && 'edit-advanced_ads' === $screen->id ){      
        $hidden[] = 'ad_shortcode';     
    }   
    return $hidden;
}

add_filter( 'manage_student_reporting_posts_columns','add_student_reporting_custom_columns');
function add_student_reporting_custom_columns( $columns ) {  
    $columns['region'] = 'Region';
    return $columns;
}


function change_link( $permalink, $post ) {
    if( $post->post_type == 'announcement' ) { // assuming the post type is video
        $permalink = home_url( 'announcements-events/?id='.$post->ID );
    }
	else if($post->post_type == 'tribe_events' ) { // assuming the post type is video
        //$permalink = home_url( 'event/?id='.$post->ID );
    }
    return $permalink;
}
add_filter('post_type_link',"change_link",10,2);


/*save pending users count into meta field*/
add_action( 'admin_init', 'admin_initial_function');
function admin_initial_function($users){
    
    global $pagenow;
    if ($pagenow != 'users.php') {

        $pending = get_users(array(
            'number' => -1,
            'fields' => array('ID'),
            'count_total'  => true,
            'meta_query'  => array(
                'relation' => 'AND',
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => "pending",
                        'compare' => '='
                    ),
            ),
        ));
        
        update_option("pending_user_count", count($pending));
    
    }
}

add_filter('manage_users_columns','remove_users_columns');
function remove_users_columns($column_headers) {
    if (current_user_can('administrator')) {
      unset($column_headers['wpdm_user_status']);
    }
 
    return $column_headers;
}

/*create taxonomy for rinpoche page*/
add_action( 'init', 'create_rinpoche_hierarchical_taxonomy', 0 );
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

function create_rinpoche_hierarchical_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Rinpoche Categories', 'Rinpoche Categories' ),
    'singular_name' => _x( 'Rinpoche Category', 'Rinpoche Category' ),
    'search_items' =>  __( 'Search Rinpoche Category' ),
    'all_items' => __( 'All Rinpoche Category' ),
    'parent_item' => __( 'Parent Rinpoche Category' ),
    'parent_item_colon' => __( 'Parent Rinpoche Category:' ),
    'edit_item' => __( 'Edit Rinpoche Category' ), 
    'update_item' => __( 'Update Rinpoche Category' ),
    'add_new_item' => __( 'Add New Rinpoche Category' ),
    'new_item_name' => __( 'New Rinpoche Category Name' ),
    'menu_name' => __( 'Rinpoche Categories' ),
  );    
 
// Now register the taxonomy
 
  register_taxonomy('rinpoche_cats',array('wpdmpro'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'rinpoche' ),
  ));
 
}

add_filter( 'password_change_email', 'wpse207879_change_password_mail_message', 10, 3 );
function wpse207879_change_password_mail_message( $pass_change_mail, $user, $userdata ) {
    
    //English
	$new_message_txt .= "Hi ###USERNAME###";
  $new_message_txt .= "<p>This notice confirms that your password was changed on Ngondro Gar.</p></br>";
   $new_message_txt .= "<p>If you did not change your password, please contact the Site Administrator at</br>";
  $new_message_txt .= "<a href='mailto:".get_option('admin_email')."'>".get_option("admin_email")."</a></p><br>";
    $new_message_txt .= "<p>This email has been sent to ###EMAIL###</p>";
    $new_message_txt .= "<p>Regards, <br>";
	$new_message_txt .= "All at Ngondro Gar <br>";
	$new_message_txt .= "<a href='".site_url()."'>".site_url()."</a></p></br></br>";
    
    //Spanish
    $new_message_txt .= "Hi ###USERNAME###";
  $new_message_txt .= "<p>Este aviso confirma que tu contraseña ha sido cambiada en Ngondro Gar.</p></br>";
   $new_message_txt .= "<p>Si no has cambiado tu contraseña, ponte en contacto con el administrador del sitio en</br>";
  $new_message_txt .= "<a href='mailto:".get_option('admin_email')."'>".get_option("admin_email")."</a></p><br>";
    $new_message_txt .= "<p>Este correo ha sido enviado a ###EMAIL###</p>";
    $new_message_txt .= "<p>Saludos, <br>";
	$new_message_txt .= "Todos en Ngondro Gar <br>";
	$new_message_txt .= "<a href='".site_url()."'>".site_url()."</a></p></br></br>";
    
    //Portuguese
    $new_message_txt .= "Hi ###USERNAME###";
  $new_message_txt .= "<p>Este aviso confirma que sua senha foi alterada no Ngondro Gar.</p></br>";
   $new_message_txt .= "<p>Caso você não tenha solicitado a alteração de sua senha, por favor, entre em contato com o administrador do site em</br>";
  $new_message_txt .= "<a href='mailto:".get_option('admin_email')."'>".get_option("admin_email")."</a></p><br>";
    $new_message_txt .= "<p>Este e-mail foi enviado para ###EMAIL###</p>";
    $new_message_txt .= "<p>Atenciosamente, <br>";
	$new_message_txt .= "Pessoal do Ngondro Gar <br>";
	$new_message_txt .= "<a href='".site_url()."'>".site_url()."</a></p></br></br>";
    
    //Chinese
    $new_message_txt .= "Hi ###USERNAME###";
  $new_message_txt .= "<p>此封郵件通知您在前行營的密碼已更改。</p></br>";
   $new_message_txt .= "<p>假如您未進行此項操作，請發郵件諮詢管理員</br>";
  $new_message_txt .= "<a href='mailto:".get_option('admin_email')."'>".get_option("admin_email")."</a></p><br>";
    $new_message_txt .= "<p>郵件已發送至 ###EMAIL###</p>";
    $new_message_txt .= "<p>順祝法安, <br>";
	$new_message_txt .= "前行營 <br>";
	$new_message_txt .= "<a href='".site_url()."'>".site_url()."</a></p></br></br>";
    
    
    $pass_change_mail[ 'message' ] = $new_message_txt;
  return $pass_change_mail;
}

add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );

function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
    $key = get_password_reset_key( $user );

    // English
    $message = "Username: ". $user->user_login . "</p>" ;
    $message .= '<p>To set your password, visit the following address: </p>';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . "</br>";
    $message .= "<a href='".wp_login_url()."'></a></br></br></br>";
    
    // Spanish
    $message .= "Nombre de usuario: ". $user->user_login . "</p>" ;
    $message .= '<p>Para establecer tu contraseña, visita la siguiente dirección: </p>';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . "</br>";
    $message .= "<a href='".wp_login_url()."'></a></br></br></br>";

    // Portuguese
    $message .= "Nome de usuário: ". $user->user_login . "</p>" ;
    $message .= '<p>Para definir sua senha, visite o seguinte endereço: </p>';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . "</br>";
    $message .= "<a href='".wp_login_url()."'></a></br></br></br>";

    // Chinese
    $message .= "用戶名: ". $user->user_login . "</p>" ;
    $message .= '<p> 請點擊以下連結,設置密碼: </p>';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . "</br>";
    $message .= "<a href='".wp_login_url()."'></a></br></br></br>";


    $wp_new_user_notification_email['message'] = $message;

    return $wp_new_user_notification_email;
}

// See https://developer.wordpress.org/reference/hooks/template_redirect/
add_action( 'template_redirect', 'cyb_redirect_not_found_paths' );
function cyb_redirect_not_found_paths() {

    // See https://developer.wordpress.org/reference/functions/is_404/
    if( is_404() ) {

    
            $url_to = 'https://ngondrogar.org/';

       
        wp_redirect( $url_to );
        //     exit;

    }

} 
