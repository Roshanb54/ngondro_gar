<?php

	$title = get_the_title(get_the_ID());
	$meta_data = get_post_meta(get_the_ID());
	$end_date = $meta_data['_EventEndDate'];
	$start_date = $meta_data['_EventStartDate'];

	if($start_date && $end_date){
		$sdate=date_create($start_date[0]);
		$event_start_time = date_format($sdate, "g:i:s A");
		$sdate = date_format($sdate, "M d");
		$edate=date_create($end_date[0]);
		$edate = date_format($edate, "M d");
		$event_date = $sdate. " - ".$edate;
		
	}
	else{
		$sdate=date_create($start_date[0]);
		$event_start_time = date_format($sdate, "g:i:s A");
		$sdate = date_format($sdate, "M d");
		$event_date = $sdate;
	}
	
	$orgs = $meta_data['_EventOrganizerID'];
	$timezone = $meta_data['_EventTimezone'][0];
	$featured_img = get_the_post_thumbnail_url(get_the_ID());
?>

<div class="white-popup-block event-popup-right-sidebar mfp-with-anim">
	<div cllass="event-inner-wrapper">
		<div class="container p-0">
			<div class="row g-5">
				<div class="col-md-12">
					<div class="event-image">
						<?php if($featured_img!=""):?>
							<img src="<?=$featured_img?>" style="width:50%">
						<?php endif;?>
					</div>
					<div class="event-date">Event - <br><?=$event_date?></div>
					<div class="event-title py-10"><h4><?=$title?></h4></div>
					<div class="event-details">
						<ul>
							<?php foreach($orgs as $org):
								$org_name = get_the_title($org);
							?>
							<li><i class="icon feather icon-user"></i> <?=$org_name?></li>
							<?php endforeach;?>
							<li><i class="icon feather icon-clock"></i> <?php echo $event_start_time." ".$timezone;?></li>
						</ul>
					</div>
			</div>
		</div>
	</div>
</div>