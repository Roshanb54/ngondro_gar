<?php 
/**
 * Template Name: Change Password Page
 * @desc: Change Password Page
 * @params [userdetails] [Array] Details of the current user
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */
get_header('loggedin');
$user = wp_get_current_user();
$user_meta = get_user_meta(get_current_user_id());
if(is_user_logged_in()):?>
    <div id="layoutSidenav_content">
        <section class="change-password-wrapper mt-10">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <ul class="nav nav-tabs profile-tabs">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="<?php echo home_url('/edit-profile/');?>"><?php echo __('Edit Profile','ngondro_gar');?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo home_url('/change-password/');?>"><?php echo __('Change Password','ngondro_gar');?></a>
                            </li>
                            <?php if(is_user_logged_in() && in_array( 'student', (array) $user->roles )){ ?>
                                <li class="nav-item">
                                    <a class="nav-link " href="<?php echo home_url('/edit-preferences/');?>"><?php echo __('Edit Preferences','ngondro_gar');?></a>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="change-password-box-wrapper">
                            <div class="">

                                <?php
                                if(isset($_POST['change_password'])){
                                    $userdetails = wp_get_current_user();
                                    $password = $_POST['old_password'];
                                    $hash = $userdetails -> user_pass;
                                    $user_id = $userdetails -> ID;
                                    if (wp_check_password( $password, $hash, $user_id ) ) {
                                        if(wp_verify_nonce($_POST['password_nonce'], 'password-nonce')) {
                                            if($_POST['new_password'] == '' || $_POST['confirm_password'] == '') {
                                                echo __("<p class='alert alert-warning'>Please enter a password, and confirm password!</p>",'ngondro_gar');
                                            }
                                            else if($_POST['new_password'] != $_POST['confirm_password']) {
                                                echo __("<p class='alert alert-warning'>Passwords do not match!</p>",'ngondro_gar');
                                            }
                                            else if($password == $_POST['new_password']) {
                                                echo __("<p class='alert alert-warning'>New Password should be different from old password!</p>",'ngondro_gar');
                                            }
                                            else{
                                                $user_data = array(
                                                    'ID' => $_POST['user_id'],
                                                    'user_pass' => $_POST['new_password']
                                                );
                                                wp_update_user($user_data);
                                                echo __("<p class='alert alert-success'> Password updated successfully!</p>",'ngondro_gar');
                                                wp_redirect( home_url() );
                                            }
                                        }
                                    }
                                    else {
                                        echo __("<p class='alert alert-warning'>Old password do not match!</p>",'ngondro_gar');
                                    }

                            }


                                ?>
                            </div>
                            <div class="change-password-inner-box">

                                <form method="POST" class="d-block d-md-none">
                                    <div class="change-password-table-wrapper common-form-style top_form">
                                        <h4><?php echo __('Change password','ngondro_gar');?></h4>
                                        <div class="row">
                                            <div class="form-floating mt-5">
                                                <input type="password" name="old_password" maxlength="50" class="form-control" placeholder="Old Password" required>
                                                <label for="old_password"><?php echo __('Old Password','ngondro_gar');?></label>
                                                <a href="javascript:void(0);" class="password-visibility"><i class="far fa-eye"></i></a>
                                            </div>

                                            <div class="form-floating mt-5">
                                                <input type="password" name="new_password" maxlength="50" class="form-control" placeholder="New Password" data-main = ".top_form" required>
                                                <label for="new_password"><?php echo __('New Password','ngondro_gar');?></label>
                                                <a href="javascript:void(0);" class="password-visibility"><i class="far fa-eye"></i></a>
                                            </div>
                                           
                                            <div class="form-floating mt-5">
                                                <input type="password" name="confirm_password" maxlength="50" class="form-control" data-main = ".top_form" placeholder="Confirm Password" required>
                                                <label for="confirm_password"><?php echo __('Confirm Password','ngondro_gar');?></label>
                                                <a href="javascript:void(0);" class="password-visibility"><i class="far fa-eye"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-buttons-wrapper mt-7 mb-5">
                                            <input type="hidden" name="user_id" value="<?=get_current_user_id()?>">
                                            <input type="hidden" name="password_nonce" value="<?=wp_create_nonce('password-nonce'); ?>"/>
                                            <button class="btn btn-lg btn-default me-4" name="change_password" type="submit"><?php echo __('Save','ngondro_gar');?></button>
                                            <a href="<?php echo home_url('/your-profile/');?>" class="btn btn-lg btn-tranparent" name="change_password_cancel"><?php echo __('Cancel','ngondro_gar');?></a>
                                        </div>

                                    </div>
                                </form>
                                <form method="POST" class="d-none d-md-block">
                                    <div class="change-password-table-wrapper form-buttons-wrapper common-form-style mb-5">
                                        <table class="table table-borderless mb-0 bottom_form">
                                            <tbody>
                                            <tr>
                                                <th scope="row"><?php echo __('Old Password <span class="asterisk">*</span> :','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input type="password" name="old_password" maxlength="50" class="form-control" placeholder="Old Password" required>
                                                        <label for="old_password"><?php echo __('Old Password','ngondro_gar');?></label>
                                                        <a href="javascript:void(0);" class="password-visibility"><i class="far fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('New Password <span class="asterisk">*</span>:','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input type="password" name="new_password" maxlength="50" minlength="4" class="form-control" placeholder="New Password" data-main = ".bottom_form" required>
                                                        <label for="new_password"><?php echo __('New Password','ngondro_gar');?></label>
                                                        <a href="javascript:void(0);" class="password-visibility"><i class="far fa-eye"></i></a>
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo __('Confirm Password <span class="asterisk">*</span>:','ngondro_gar');?></th>
                                                <td>
                                                    <div class="form-floating">
                                                        <input type="password" name="confirm_password" maxlength="50" minlength="4" class="form-control" placeholder="Confirm Password" data-main = ".bottom_form" required>
                                                        <label for="confirm_password"><?php echo __('Confirm Password','ngondro_gar');?></label>
                                                        <a href="javascript:void(0);" class="password-visibility"><i class="far fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                                                     
                                        <input type="hidden" name="user_id" value="<?=get_current_user_id()?>">
                                        <input type="hidden" name="password_nonce" value="<?=wp_create_nonce('password-nonce'); ?>"/>
                                        <button class="btn btn-lg btn-default me-4 mt-8" name="change_password" type="submit"><?php echo __('Save','ngondro_gar');?></button>
                                        <a href="<?php echo home_url('/your-profile/');?>" class="btn btn-lg btn-tranparent mt-8" name="change_password_cancel"><?php echo __('Cancel','ngondro_gar');?></a>
                                    </div>
                                </form>
                                <span id="password-strength"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php get_footer();?>
    </div>

<?php else:
	get_template_part( 'page-templates/permission_denied', 'page' ); 
	exit();	
?>

<?php endif;?>

