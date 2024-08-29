<?php 
/**
 * Template Name: Diff Page
 */
global $wpdb;
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//  require_once('adapter.php');

 echo "Hello<br>";

//  $user = wpp_check_password('lnnstudent***', '$S$DIfC5sQ/.uo7eSfdsmfWCCCkxY7omgLDL4CsH8X6EarIolPwfHJz');
// $user = wpp_hash_password('lnnstudent***');
// update_user_meta($id, 'drupalpass', '$S$Dx0LYGyPWf3jBgm/83mlPfSEHEAO5ZEVEgBeSBvSOLwVcYUqB8Fr');
// $meta_field = get_user_meta($id, 'drupalpass');




$drupal_users = $wpdb->get_results("SELECT * FROM users ORDER BY 'ASC'");


// echo "<pre>";
// print_r($drupal_users);

// $our_users = get_user_by('email', $drupal_users[4]->init);
// print_r($our_users->drupalpass);


foreach($drupal_users as $list){
    $our_users = get_user_by('email', $list->mail);
    
    
    $update = add_user_meta($our_users->data->ID,'drupalpass', $list->pass, true);
        // var_dump($update);
        if($update){
            var_dump($update);
            $get = get_user_meta($our_users->data->ID, 'drupalpass');
            echo "<pre>";
            print_r($get);
        }else{
            echo "can't update<br>";
        }

    $get_all_meta = get_user_meta($our_users->data->ID, 'drupalpass');
    // $count[] = null;
    if(!empty($get_all_meta) || $get_all_meta != null){
        $count[] = count($get_all_meta);
    }

}

echo "<pre>";
    print_r(count($count));
  

 ?>