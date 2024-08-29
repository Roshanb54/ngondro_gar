<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Ngondro_Gar
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ngondro_gar_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'ngondro_gar_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ngondro_gar_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'ngondro_gar_pingback_header' );

/*get thumbnail from url*/ 
function get_video_thumbnail( $src ) {

	$url_pieces = explode('/', $src);
	
	if (preg_match('#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $src, $match)) { // If Vimeo
    $data = json_decode( file_get_contents( 'http://vimeo.com/api/oembed.json?url=' . $src ) );
    $thumbnail_small = $data->thumbnail_url;
    preg_match("/[^\/]+$/", $thumbnail_small, $matches);
    $file_name = $matches[0]; // test
    $thumbnail_large = preg_replace('/_[^_.]*\./', '.', $file_name);
    $old_file_name = basename($thumbnail_small);
    $new_file_name = $thumbnail_large;
    $hash_url = str_replace($old_file_name, $new_file_name, $thumbnail_small);
	$hash = (explode("_640",$hash_url));
	$thumbnail = $hash[0].'_1400';

  } elseif (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match)) { // If Youtube

    // parse_str( parse_url( $src, PHP_URL_QUERY ), $my_array_of_vars );
		$thumbnail = 'http://img.youtube.com/vi/' . $match[1] . '/hqdefault.jpg';

  }

	return $thumbnail;

}

add_action('wp_ajax_rp_send_message', 'rp_send_message');
add_action('wp_ajax_nopriv_rp_send_message', 'rp_send_message');

 function rp_send_message() {
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die( 'Nonce value cannot be verified.' );
    }
       
        if (isset($_POST['message'])) {
            $ins_id = $_POST['ins_id'];
            $to = $_POST['email'];;
            $student_email = $_POST['student_email'];
            $subject = "Message from " . $_POST['name'];
            $name = $_POST['name'];
            $form_sub = $_POST['subject'];
            $headers[] = 'Content-type: text/html;charset=UTF-8' . "\r\n";
            $headers[] = "X-Mailer: PHP \r\n";
            $headers[] = 'From: NGONDRO GAR < '.get_option( 'admin_email' ).'>' . "\r\n";
            $headers[] = 'Reply-To: '.$name.' <'.$student_email.'>' . "\r\n";
            if($ins_id == 26){
                $headers[] = 'cc: chunjing9822@163.com'; 
                $headers[] = 'cc: joyceleung1@sina.com'; 
                $headers[] = 'cc: myloft2002@163.com'; 
                $headers[] = 'cc: zuohuizi2008@163.com'; 
            }
            $message =  $_POST['message'];
            $msgBody = "<h3>Instructor Contact Form</h3>";
            $msgBody .= "<p>Name: $name <br></p>";
            $msgBody .= "<p>Subject: $form_sub <br></p>";
            $msgBody .= "<p>Email: <a href='mailto:$student_email'>$student_email</a> <br></p>";
            $msgBody .= "<p>Message: $message <br></p>";
            wp_mail($to, $subject, $msgBody, $headers);
            die();
        }  
    }

  
/**
 * add students menu under "Users".
 */
function rp_student_users_menu() {
    add_users_page(
        __( 'All Students', 'ngondro_gar' ),
        __( '<span id="custom_students_link">All Students</span>', 'ngondro_gar' ),
        'read',
        '/users.php?role=student',
        '',
        1
    );
}
add_action('admin_menu', 'rp_student_users_menu');
add_action( 'admin_head-users.php', 'rp_student_users_highlight_menu_item' );
function rp_student_users_highlight_menu_item(){
  global $current_screen;
  if( isset( $_GET['role'] ) && 'student' == $_GET['role'] )
  {       
      ?>
      <script type="text/javascript">
          jQuery(document).ready( function($) 
          {
              var reference = $('#custom_students_link').parent().parent();

              // add highlighting to our custom submenu
              reference.addClass('current');

              //remove higlighting from the default menu
              reference.parent().find('li').eq(1).removeClass('current');  
              console.log(reference.parent().find('li').eq(1));           
          });     
      </script>
      <?php
  }
}

add_action( 'init', 'roshan_change_post_object' );
// Change dashboard Posts to News
function roshan_change_post_object() {
    $get_post_type = get_post_type_object('wpdmpro');
    $labels = $get_post_type->labels;
    if($labels->name != null){
        $labels->name = 'Resources';}
    if($labels->singular_name != null){
        $labels->singular_name = 'Resources'; }
    if($labels->add_new != null){
        $labels->add_new = 'Add Resource';}
    if($labels->add_new_item != null){
        $labels->add_new_item = 'Add Resource'; }
    if($labels->edit_item != null){
        $labels->edit_item = 'Edit Resource'; }
    if($labels->new_item != null){
        $labels->new_item = 'Resources'; }
    if($labels->view_item != null){
        $labels->view_item = 'View Resource'; }
    if($labels->search_items != null){
        $labels->search_items = 'Search Resources'; }
    if($labels->not_found != null){
        $labels->not_found = 'No Resources found'; }
    if($labels->not_found_in_trash != null){
        $labels->not_found_in_trash = 'No Resources found in Trash'; }
    if($labels->all_items != null){
        $labels->all_items = 'All Resources'; }
    if($labels->menu_name != null){
        $labels->menu_name = 'Resources'; }
        if($labels->name_admin_bar != null){
        $labels->name_admin_bar = 'Resources'; }
}

add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});

function fix_svg_mime_types($mime){
	$mime['svg']='image/svg+xml';
	$mime['tiff']='image/tiff';
	return $mime;
}
add_filter('upload_mimes', 'fix_svg_mime_types', 99);

