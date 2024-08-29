<?php
/**
 * Ngondro Gar functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ngondro_Gar
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ngondro_gar_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Ngondro Gar, use a find and replace
		* to change 'ngondro_gar' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ngondro_gar', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'ngondro_gar' ),
			'menu-mobile' => esc_html__( 'Primary Mobile Menu', 'ngondro_gar' ),
			'menu-2' => esc_html__( 'Primary After Login', 'ngondro_gar' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'ngondro_gar' ),
			'user-profile' => esc_html__( 'User Profile Menu', 'ngondro_gar' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'ngondro_gar_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ngondro_gar_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ngondro_gar_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ngondro_gar_content_width', 640 );
}
add_action( 'after_setup_theme', 'ngondro_gar_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ngondro_gar_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ngondro_gar' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ngondro_gar' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Menu 1 (After Login)', 'ngondro_gar' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'ngondro_gar' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Menu 2 (After Login)', 'ngondro_gar' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'ngondro_gar' ),
			'before_widget' => '<section id="%1$s after-login" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<p class="widget-title">',
			'after_title'   => '</p>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Menu 3 (After Login)', 'ngondro_gar' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'ngondro_gar' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'ngondro_gar_widgets_init' );

function my_login_logo() { ?>
    <style type="text/css">
		.wp-core-ui .button, .wp-core-ui .button-secondary {
    color: #BD5D72!important;
    border-color: #BD5D72!important;
    background: #f6f7f7!important;
    vertical-align: top;
}
.wp-core-ui .button-secondary:hover, .wp-core-ui .button.hover, .wp-core-ui .button:hover {
    background: #f0f0f1!important;
    border-color: #BD5D72!important;
    color: #0a4b78!important;
}
        .wp-core-ui .button-primary {
		background: #BD5D72!important;
		border-color: #BD5D72!important;
		color: #fff !important;
		text-decoration: none;
		text-shadow: none;
	}
	.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {
    background: #BD5D72!important;
    border-color: #BD5D72 !important;
    color: #fff!important;
}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/**
 * Enqueue scripts and styles.
 */
function ngondro_gar_scripts() {
	$mobile_menu_logo = get_theme_mod( 'mobile_menu_logo' );
	wp_enqueue_style( 'ngondro_gar-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_script( 'password-strength-meter' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() .'/assets/css/bootstrap.min.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'fontawesome-css', get_template_directory_uri() .'/assets/css/fontawesome.min.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'magnific-css', get_template_directory_uri() .'/assets/css/magnific-popup.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'fancybox-css', get_template_directory_uri() .'/assets/css/fancybox.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'fonts-css', get_template_directory_uri() .'/assets/css/fonts.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'registration-form-css', get_template_directory_uri() .'/assets/css/registration-form.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'feather-icons-css', get_template_directory_uri() .'/assets/feather-icons/css/iconfont.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'slick-css', get_template_directory_uri() .'/assets/css/slick.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'slick-theme-css', get_template_directory_uri() .'/assets/css/slick-theme.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'jquery-confirm-css', get_template_directory_uri() .'/assets/css/jquery-confirm.min.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'custom-css', get_template_directory_uri() .'/assets/css/style.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'dashboard-css', get_template_directory_uri() .'/assets/css/dashboard.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'hc-offcanvas-nav-css', get_template_directory_uri() .'/assets/css/hc-offcanvas-nav.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'hc-offcanvas-nav-carbon-css', get_template_directory_uri() .'/assets/css/hc-offcanvas-nav.carbon.css', array(),date('Hms'), 'all');
	wp_enqueue_style( 'responsive-css', get_template_directory_uri() .'/assets/css/responsive.css', array(),date('Hms'), 'all');

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), date('Hms'), true );
	wp_enqueue_script( 'magnific-js', get_template_directory_uri() . '/assets/js/magnific-popup.min.js', array('jquery'), date('Hms'), true );
	wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/assets/js/fancybox.umd.js', array('jquery'), date('Hms'), true );
	wp_enqueue_script( 'resizesensor-js', get_template_directory_uri() . '/assets/js/ResizeSensor.js', array('jquery'), date('Hms'), true );
	// wp_enqueue_script( 'sticky-js', get_template_directory_uri() . '/assets/js/jquery.sticky-sidebar.min.js', array('jquery','resizesensor-js'), date('Hms'), true );
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), date('Hms'), true );
	wp_enqueue_script( 'validate-js', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array('jquery'), date('Hms'), true );
	//wp_enqueue_script( 'SmoothScroll-js', get_template_directory_uri() . '/assets/js/SmoothScroll.js', array('jquery'), date('Hms'), true );
	wp_enqueue_script( 'jquery-confirm-js', get_template_directory_uri() . '/assets/js/jquery-confirm.min.js', array('jquery'), date('Hms'), true );
	wp_enqueue_script( 'registration-form-js', get_template_directory_uri() . '/assets/js/registration-form.js', array('jquery','validate-js'), date('Hms'), true );
	wp_enqueue_script( 'hc-offcanvas-nav-js', get_template_directory_uri() . '/assets/js/hc-offcanvas-nav.js', array('jquery'), date('Hms'), true );
	wp_enqueue_script( 'custom-script-js', get_template_directory_uri() . '/assets/js/custom-script.js', array('jquery','slick-js','jquery-confirm-js','hc-offcanvas-nav-js','fancybox-js'), date('Hms'), true );
	
	wp_localize_script( 'custom-script-js', 'ajaxObj',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce('ajax-nonce'),
			'HomeURL' =>home_url('/'),
			'mobileLogo' =>$mobile_menu_logo,
			'previous'	=> __('Previous','ngondro_gar'),
			'next'	=>__('Next','ngondro_gar'),
			'resetText'	=>__('Reset Password?','ngondro_gar')
			
        )
    );
	wp_localize_script( 'registration-form-js', 'ajaxObj',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce('ajax-nonce'),
        )
    );

	wp_localize_script( 'password-strength-meter', 'pwsL10n', array(
		'empty' => __( 'Strength indicator' ),
		'short' => __( 'Very weak' ),
		'bad' => __( 'Weak' ),
		'good' => _x( 'Medium', 'password strength' ),
		'strong' => __( 'Strong' ),
		'mismatch' => __( 'Mismatch' )
	) );

	wp_enqueue_script( 'ngondro_gar-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ngondro_gar_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom Functions
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Shortcode Functions
 */
require get_template_directory() . '/inc/shortcode-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer/ngondro_gar-default-values.php';
require get_template_directory() . '/inc/customizer/functions/customizer-control.php';
require get_template_directory() . '/inc/customizer/functions/sanitize-functions.php';
require get_template_directory() . '/inc/customizer/ngondro_gar-color-picker/ngondro_gar-color-picker.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Custom Breadcrumb
 */
require get_template_directory() . '/inc/custom-breadcrumb.php';
/**
 * nav walker
 */
require get_template_directory() . '/bt5navwalker.php';

if(!function_exists('ngondro_gar_get_theme_options')):
    function ngondro_gar_get_theme_options() {
        return wp_parse_args(  get_option( 'ngondro_gar_theme_options', array() ), ngondro_gar_get_option_defaults_values() );
    }
endif;

function add_classes_on_li($classes, $item, $args) {
    $classes[] = 'nav-item';
    return $classes;
}
add_filter('nav_menu_css_class','add_classes_on_li',1,3);
        
/**
 * Add CSS class for "<a>" tags in menu
 */
function roshan_theme_add_menu_link_class( $classes, $item ) {
    $classes['class'] = "nav-link hover";
    if ( in_array('current_page_item', $item->classes) ) {
        $classes['class'] = 'nav-link hover active'; 
    }
    return $classes;
}
add_filter( 'nav_menu_link_attributes', 'roshan_theme_add_menu_link_class', 10, 2 );


/*Instructor ajax popup*/ 

add_action ( 'wp_ajax_nopriv_instructor_popup_ajax', 'roshan_instructor_popup_ajax' );
add_action ( 'wp_ajax_instructor_popup_ajax', 'roshan_instructor_popup_ajax' );
function roshan_instructor_popup_ajax () {
    $pid        = intval($_GET['post_id']);
    $the_query  = new WP_Query(array(
        'post_type' => 'instructor',
        'posts_per_page' => 1,
        'p' => $pid
    ));
    if ($the_query->have_posts()) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            //template file
			get_template_part( 'template-parts/content', 'instructor-ajax' );
        }
    } else {
        echo '<div id="postdata">'.esc_html__('Didn\'t find anything', 'ngondro_gar').'</div>';
    }
    wp_reset_postdata(); 
    die();
}

/*announcement ajax popup*/ 

add_action ( 'wp_ajax_nopriv_announcement_popup_ajax', 'roshan_announcement_popup_ajax' );
add_action ( 'wp_ajax_announcement_popup_ajax', 'roshan_announcement_popup_ajax' );
function roshan_announcement_popup_ajax () {
    $pid        = intval($_GET['post_id']);
    $the_query  = new WP_Query(array(
        'post_type' => 'announcement',
        'posts_per_page' => 1,
        'p' => $pid
    ));
    if ($the_query->have_posts()) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            //template file
			get_template_part( 'template-parts/content', 'announcement-ajax' );
        }
    } else {
        echo '<div id="postdata">'.esc_html__('Didn\'t find anything', 'ngondro_gar').'</div>';
    }
    wp_reset_postdata(); 
    die();
}


/*Events ajax Slide*/ 

add_action ( 'wp_ajax_nopriv_events_ajax_slide', 'dps_ims_events_ajax_slide' );
add_action ( 'wp_ajax_events_ajax_slide', 'dps_ims_events_ajax_slide' );
function dps_ims_events_ajax_slide () {
    $pid        = intval($_GET['post_id']);
    $the_query  = new WP_Query(array(
        'post_type' => 'tribe_events',
        'posts_per_page' => 1,
        'p' => $pid
    ));
    if ($the_query->have_posts()) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            //template file
			get_template_part( 'template-parts/content', 'event-ajax' );
        }
    } else {
        echo '<div id="postdata">'.esc_html__('Didn\'t find anything', 'ngondro_gar').'</div>';
    }
    wp_reset_postdata(); 
    die();
}


add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
	wp_safe_redirect( home_url() );
	exit;
}

/*/---- Validate contact Form  ----/*/
add_filter( 'wpcf7_validate_text*', 'custom_text_validation_filter', 50, 2 );

function custom_text_validation_filter( $result, $tag ) {
	// Your name
	if ( 'your-name' == $tag->name ) {
		$your_name = isset( $_POST['your-name'] ) ? trim( $_POST['your-name'] ) : '';
			if(strlen($your_name) == 0){
				$result->invalidate( $tag, "The field is required." );
			}
		}
	// Your Subject
	if ( 'your-subject' == $tag->name ) {
		$your_subject = isset( $_POST['your-subject'] ) ? trim( $_POST['your-subject'] ) : '';
			if(strlen($your_subject) == 0){
				$result->invalidate( $tag, "The field is required." );
			}
		}	
return $result;
}



/*save transfer list*/ 

add_action ( 'wp_ajax_nopriv_transfer_information', 'ngondro_transfer_information' );
add_action ( 'wp_ajax_transfer_information', 'ngondro_transfer_information' );
function ngondro_transfer_information () {
	global $wpdb;
	$data = $_POST['data'];
	foreach($data as $val)
	{
		$name = $val['name'];
		$val = $val['value'];
		$report[$name] = $val;
	}
	$report['reporting_date']= date('Y-m-d');
	$report['type']= "transfer";
	$id = $wpdb->insert('user_reporting', $report);
	if($id)
	{
		$msg = true;
	}
	else{
		$msg = false;
	}
	echo $msg;exit;
}



/*save graduated data*/ 

add_action ( 'wp_ajax_nopriv_save_graduated_info', 'ngondro_save_graduated_info' );
add_action ( 'wp_ajax_save_graduated_info', 'ngondro_save_graduated_info' );
function ngondro_save_graduated_info () {
	global $wpdb;
	$option = $_POST['option'];
	$user = $_POST['user'];
	update_user_meta($user, 'graduate', $option );
	echo true; exit;
}

/*save exempt data*/ 

add_action ( 'wp_ajax_nopriv_save_exempt_info', 'ngondro_save_exempt_info' );
add_action ( 'wp_ajax_save_exempt_info', 'ngondro_save_exempt_info' );
function ngondro_save_exempt_info () {
	global $wpdb;
	$option = $_POST['option'];
	$user = $_POST['user'];
	update_user_meta($user, 'exempt', $option );
	echo true; exit;
}


/*save_update_status_info*/ 

add_action ( 'wp_ajax_nopriv_save_update_status_info', 'ngondro_save_update_status_info' );
add_action ( 'wp_ajax_save_update_status_info', 'ngondro_save_update_status_info' );
function ngondro_save_update_status_info () {
	global $wpdb;
	$user_id = $_POST['user'];
	$status = $_POST['status'];
	$newstatus = "approved";
	if($status=="activate"){$newstatus = "approved";}else{$newstatus = "denied";}
	update_user_meta($user_id, 'ng_user_approve_status', $newstatus );
	echo true; exit;
}


/*add roles*/

add_action('init', 'add_new_role_method');
function add_new_role_method(){
	$role = add_role( 'manager', 'Manager', array(
		'read' => true,
	) );
	$role = add_role( 'principal', 'Principal', array(
		'read' => true,
	) );
	$role = add_role( 'tech', 'Tech', array(
		'read' => true,
	) );
}

add_action( 'wp_ajax_nopriv_check_user_email', 'check_user_email_callback' );
function check_user_email_callback() {
    global $wpdb; // this is how you get access to the database
    if(email_exists($_POST['register_email'])){
        echo json_encode(false);
    }
    else{
        echo json_encode(true);
    }
    die();
}

add_action( 'wp_ajax_nopriv_check_user_name', 'check_user_name_callback' );
function check_user_name_callback() {
    global $wpdb; // this is how you get access to the database
    if(username_exists($_POST['register_username'])){
        echo json_encode(false);
    }
    else{
        echo json_encode(true);
    }
    die();
}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

add_action( 'wp_ajax_activate_deactivate_user', 'rp_activate_deactivate_user');
function rp_activate_deactivate_user() {
    if(empty($_REQUEST ) || !isset($_REQUEST )) {
        ajaxStatus('error', 'Nothing to update.');
    } else {
        try {
            $user = wp_get_current_user();
            $user_id = $_REQUEST['user_id'];
			$user_status = $_REQUEST['user_status'];
            if ($user_status == 'approved') {
                update_user_meta($user_id, 'ng_user_approve_status', 'decline' );
				wp_send_json('decline');
            } elseif ($user_status == 'decline') {
                update_user_meta($user_id, 'ng_user_approve_status', 'approved' );
				wp_send_json('approved');
            }
			$datas = get_user_meta($user_id, 'ng_user_approve_status');
            die();
        } catch (Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}

/*last user login */ 
function user_last_login( $user_login, $user ) {
    update_user_meta( $user->ID, 'last_login', date('Y-m-d') );
}
add_action( 'wp_login', 'user_last_login', 10, 2 );


/*save remarks data*/ 
add_action ( 'wp_ajax_nopriv_save_remarks', 'ngondro_save_remarks' );
add_action ( 'wp_ajax_save_remarks', 'ngondro_save_remarks' );
function ngondro_save_remarks () {
	global $wpdb;
	$notes = $_POST['notes'];
	$user = $_POST['user'];
	update_user_meta($user, 'instructor_note', $notes );
	echo true; exit;
}
/*extended user search function on admin*/
if(is_admin()) {
	// Action to inject custom search queries
    //add_action('pre_user_query', 'extend_user_search');	

   // Main function responsible for enhancing the search
    function extend_user_search($wp_user_query) {
        if(false === strpos($wp_user_query->query_where, '@') && !empty($_GET["s"])) {
            global $wpdb;
            $uids=array();			
			$flsiwa_add = "";
			// Escaped query string
			$qstr = esc_sql($_GET["s"]);
			if(preg_match('/\s/',$qstr)){
				$pieces = explode(" ", $qstr);
				$user_ids_collector = $wpdb->get_results("SELECT DISTINCT user_id FROM $wpdb->usermeta WHERE (meta_key='first_name' AND LOWER(meta_value) LIKE '%".$pieces[0]."%')");
	            foreach($user_ids_collector as $maf) {
	                if(strtolower(get_user_meta($maf->user_id, 'last_name', true)) == strtolower($pieces[1])){
						array_push($uids,$maf->user_id);
	                }
	            }
			}else{				
				$user_ids_collector = $wpdb->get_results("SELECT DISTINCT user_id FROM $wpdb->usermeta WHERE (meta_key='first_name' OR meta_key='last_name'".$flsiwa_add.") AND LOWER(meta_value) LIKE '%".$qstr."%'");
					foreach($user_ids_collector as $maf) {
	                array_push($uids,$maf->user_id);
	            }
			}
            $id_string = implode(",",$uids);
			if (!empty($id_string))
			{
				$search_meta = "ID IN ($id_string)";
				$wp_user_query->query_where = str_replace(
					'WHERE 1=1 AND (',
					"WHERE 1=1 AND ( " . $search_meta . " OR ",
					$wp_user_query->query_where );
			}
        }
        return $wp_user_query;
    }
}



add_action('wp_ajax_ngondro_gar_instructor_student_download', "ngondro_gar_instructor_student_download_handler");
add_action('wp_ajax_nopriv_ngondro_gar_instructor_student_download', "ngondro_gar_instructor_student_download_handler");


function ngondro_gar_instructor_student_download_handler(){

	global $wpdb;

	$instructor_id = $_POST['id'];
	$cfile = fopen($_SERVER['DOCUMENT_ROOT'].'/reports/csv/instructor_student_data.csv', 'w');
	$heading = array("Name", "Commited Hrs", "Practice", "Section", "Completed Hrs", "Missed report", "Graduate", "Ept");
	fputcsv($cfile,$heading);

	$students = get_users(
		array(
			'role' => 'student',
			'number' => -1,
			'field' => 'ID',
			'meta_query' => array(
				array(
					'key' => 'ng_user_approve_status',
					'value' => 'approved',
					'compare' => '='
				),
				array(
					'key' => 'instructor',
					'value' => $instructor_id,
					'compare' => '='
				)
			)
		)
	);

	$subjects_total1 = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects`");
	$total_required1 = (int)$subjects_total->total_hour;

	$sum_subject1 = "SUM(";
	for($i=1; $i<=21; $i++){
		if($i<21)
		$sum_subject1.= 'sub_'.$i.' + ';
		else
		$sum_subject1.= 'sub_'.$i;
	}
	$sum_subject1 .= ") As hour_total";

	


	// var_dump($_SESSION['students']);
$reported_students = [];
$ontrack = 0;
$not_reported = 0;
$trailing = 0;
$missed_report = 0;
$subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects`");
$total_required = (int)$subjects_total->total_hour;
$total_students = count($students);
$all_hrs_total = 0;

if($students){
   /*tracking report*/
	$sum_subject = "SUM(";
	for($i=1; $i<=22; $i++){
		if($i<22)
		$sum_subject.= 'sub_'.$i.' + ';
		else
		$sum_subject.= 'sub_'.$i;
	}
	$sum_subject .= ") As hour_total";
	
	foreach($students as $student):
		$missed_report = 0;
		if(!empty($student->first_name)){
			$title = $student->first_name.' '.$student->last_name;
		}
		else {
			$title = $student->display_name;
		}
		$email = $student->user_email;
		$sid = $student->ID;
		$reported_students[] = $sid;
		$track = get_the_author_meta( 'track', $sid );
		$curriculum = get_the_author_meta( 'curriculum', $sid );

		
		$instructor = get_user_by('id',$student->instructor);
		$instructor_name = $instructor->first_name .' '.$instructor->last_name;
		// echo "<pre>";
		// print_r($instructor->first_name .' '.$instructor->last_name);
		// echo "</pre>";

		$uid = $sid;
		$first_day_of_month = date('Y-m-01');
		$last_day_of_month = date('Y-m-t');
		$user_course_id = get_the_author_meta( 'curriculum', $sid );
		$cid = $user_course_id;

		$subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = '$curriculum'");
		$subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = '$curriculum'");

		$total_required = (int) $subjects_total->total_hour;
		$practice = $wpdb->get_row("Select * from ngondro_courses where id =".$user_course_id);

		$graduate = get_the_author_meta( 'graduate', $uid );
		$exempt = get_the_author_meta( 'exempt', $uid );

		/*tracking report*/
		$total_students = count($students);

		$reg_date = date("Y-m-d", strtotime($student->data->user_registered));
		$current_date = date('Y-m-d');

		$begin = new DateTime( $current_date );
		$end   = new DateTime( $reg_date );
		$months = [];
		$total_months = 0;
		//$begin = $begin->modify('-1 months');
		for($i = $begin; $i >= $end; $i->modify('-1 months')){
			$months[] = $i->format("M Y");
			$total_months++;
		}

		if($cid==""){$cid = 1;}
		$first_day_of_month = date('Y-m-01');
		$last_day_of_month = date('Y-m-t');

		$last_report  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
		if(count($last_report)>0){
			$ontrack++;
		}
		else{
			$last_12_months  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `reporting_date` > now() - INTERVAL 12 month");
			if(count($last_12_months)>0){
				$trailing++;
			}
			else{
				$missed_report++;
			}
		}
		$all_reported_entries = $wpdb->get_results("SELECT user_id, date_format(reporting_date, '%b %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " group by date_format(reporting_date, '%m-%Y') order by reporting_date desc");
		$total_reporting_hour  = $wpdb->get_row("SELECT $sum_subject from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' ");
		$all_hrs_total += (int)$total_reporting_hour->hour_total;
		$individual_total_user_reporting = (int)$total_reporting_hour->hour_total;

		$last_report_section = $wpdb->get_row("SELECT * from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' order by id DESC");
		$sections = array();
		foreach($subjects as $subs){
			 $sub_slug = $subs->slug;
			 $sub_hours = (int)$last_report_section->$sub_slug;
			 if($sub_hours>0){
				$sections[] = $subs->title;
			 }
		}
		$sections_string  = implode(', ', $sections);

		$missed_report = get_user_meta($uid, 'missed_last_report')[0];
		 /*end*/
		//  var_dump($missed_report);
		
		if($total_required > 0){
			$cmp_hrs = $individual_total_user_reporting.'/'.$total_required;
		}
		else {
			$cmp_hrs = 0; 
		}

		// $data[] =  $title;
		// $data[] =  $track;
		// $data[] =  $practice->short_name;
		// $data[] =  $sections_string;
		// $data[] = $individual_total_user_reporting / $total_required;
		// $data[] = $missed_report;
		// $data[] = $graduate;
		// $data[] = $exempt;

		$data = array($title, $track, $practice->short_name, $sections_string, $cmp_hrs, $missed_report, $graduate, $exempt);

		fputcsv($cfile, $data);
	endforeach;
	fclose($cfile);
	echo site_url()."/reports/csv/instructor_student_data.csv?v=".time();
    
}else{
	echo site_url()."?v=".time();
}
	exit();
}