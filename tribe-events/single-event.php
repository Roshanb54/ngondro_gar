<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

/**
 * Setting up the cookie if it doesn't exist yet and grabbing the browser time zone string.
 */
if ( ! isset( $_COOKIE['tribe_browser_time_zone'] ) ) { ?>
	<script type="text/javascript">
	  if ( navigator.cookieEnabled ) {
		document.cookie = "tribe_browser_time_zone=" + Intl.DateTimeFormat().resolvedOptions().timeZone + "; path=/";
	  }
	</script>
  <?php }
   
  /**
   * Calculating the event start time and time zone based on the browser time zone of the visitor.
   */
   
  // Setting default values in case the cookie doesn't exist.
  $user_time_output = "<small>Your time zone couldn't be detected. Try <a href=''>reloading</a> the page.</small>";
  $browser_time_zone_string = "not detected";
   
  if ( isset( $_COOKIE['tribe_browser_time_zone'] ) ) {
	// Grab the time zone string from the cookie.
	$browser_time_zone_string = $_COOKIE['tribe_browser_time_zone'];
   
	// Grab the event time zone string.
	$event_time_zone_string = Tribe__Events__Timezones::get_event_timezone_string( $event_id );
   
	// Grab the event start date in UTC time from the database.
	$event_start_utc = tribe_get_event_meta( $event_id, '_EventStartDateUTC', true );
   
	// Set up the DateTime object.
	$event_start_date_in_utc_timezone = new DateTime( $event_start_utc, new DateTimeZone( 'UTC' ) );
   
	// Convert the UTC DateTime object into the browser time zone.
	$event_start_date_in_browser_timezone = $event_start_date_in_utc_timezone->setTimezone( new DateTimeZone( $browser_time_zone_string ) )->format( get_option( 'time_format' ) );
   
	// Grab the time zone abbreviation based on the browser time zone string.
	$browser_time_zone_abbreviation = Tribe__Timezones::abbr( 'now', $browser_time_zone_string );
   
	// Compile the output string with time zone abbreviation.
	$user_time_output = $event_start_date_in_browser_timezone . " " . $browser_time_zone_abbreviation;
   
	// Compile the string of the time zone for the tooltip.
	$browser_time_zone_string .= ' detected';
  }

/**
 * Allows filtering of the single event template title classes.
 *
 * @since 5.8.0
 *
 * @param array  $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 */
$title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event_id );
$title_classes = implode( ' ', tribe_get_classes( $title_classes ) );

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @since 5.8.0
 *
 * @param string $before HTML string to display before the title text.
 * @param string $event_id The ID of the displayed event.
 */
$before = apply_filters( 'tribe_events_single_event_title_html_before', '<h1 class="' . $title_classes . '">', $event_id );

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display after the title text.
 * @param string $event_id The ID of the displayed event.
 */
$after = apply_filters( 'tribe_events_single_event_title_html_after', '</h1>', $event_id );

/**
 * Allows filtering of the single event template title HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display. Return an empty string to not display the title.
 * @param string $event_id The ID of the displayed event.
 */
$title = apply_filters( 'tribe_events_single_event_title_html', the_title( $before, $after, false ), $event_id );

?>

<div id="tribe-events-content" class="tribe-events-single">

	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<?php echo $title; ?>

	<div class="tribe-events-schedule tribe-clearfix" style="flex-direction: column;">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h2><b>', '</b></h2>' ); ?>

		
<?php
/**
 * Adding the event start time in the visitor's time zone.
 */
if ( ! tribe_event_is_all_day( $event_id ) ) {
  echo "<div class='tribe-events-schedule--browser-time-zone'><p>";
  echo "<div id='custom-time' style='display: none;'>".$event_time_zone_string."</div>";
  echo "Start time where <span style='text-decoration-style: dotted; text-decoration-line: underline; cursor: help;' title='This is based on your browser time zone (" . $browser_time_zone_string . ") and it might not be fully accurate.'>you are</span>: " . $user_time_output;
  echo "</p></div>";
}
?>

		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> Previous Event' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( 'Next Event <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> Previous Event' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( 'Next Event <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->

<script>
	let new_time = document.querySelector('#custom-time').innerHTML;
	document.querySelector('.timezone').innerHTML = new_time;
	
</script>