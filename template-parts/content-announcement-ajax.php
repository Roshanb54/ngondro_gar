<?php 
/*
 * @desc show instruction information on popup
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {get_user_meta} [object] Return all user meta values 
 * @params {get_the_title} [Value] Return title of the page/post
 * @returns {get_field()} [Value] Return acf field value base on field key
 * @returns {the_content()} Return content of the post
 */

$announcement_title = get_the_title();
$my_current_lang = apply_filters( 'wpml_current_language', NULL );
$post = get_post(get_the_ID());
$title = get_the_title(get_the_ID());
$name = get_field('name', get_the_ID());
$location = get_field('location', get_the_ID());
$external_link = get_field('external_link', get_the_ID());
$external_link_title = get_field('external_link_title', get_the_ID());
$email = get_field('email', get_the_ID());
$short_description = get_field('short_description', get_the_ID());
$fdate = get_field('from_date',get_the_ID());
$tdate = get_field('to_date', get_the_ID());
if($my_current_lang == 'zh-hans' || $my_current_lang == 'zh-hant'){
	$fdate = date_i18n('Y年 n月 j日', strtotime($fdate));
	$tdate = date_i18n('Y年 n月 j日', strtotime($tdate));
}
elseif($my_current_lang == 'pt-pt'){
	$fdate = date_i18n('j \d\e F, Y', strtotime($fdate));
	$tdate = date_i18n('j \d\e F, Y', strtotime($tdate));
}
else {
	$fdate = date_i18n('j F Y', strtotime($fdate));
	$tdate = date_i18n('j F Y', strtotime($tdate));
}
?>
<div class="white-popup-block mfp-with-anim announcement-popup-block">
	<div cllass="announcement-inner-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="announcement-content-inner">
						<h4><?=$title?></h4>
						<?php if(($fdate!=NULL || $fdate!="") ):?>
							<div class="popup-announcement-date">
								<?php if(($fdate!=NULL || $fdate!="") && ($tdate!=NULL || $tdate!="") ):?>
									<i class="icon feather icon-calendar"></i>
									<h5><?=$fdate?></h5>
									<p><?php echo __('to','ngondro_gar');?></p>
									<h5><?=$tdate?></h5>
								<?php elseif( ($tdate==NULL || $tdate=="") && ($fdate!=NULL || $fdate!="") ) :?>
									<i class="icon feather icon-calendar"></i>
									<h5><?=$fdate?></h5>
								<?php endif;?>
								</div>
						<?php endif;?>
						<p>
							<?php 
							the_content();
						?>
						</p>
						<div class="announcement-more-info-wrapper">
						<ul class="announcement-more-info-box">
							<?php if($name):?><li><i class="icon feather icon-user"></i> <?=$name?></li><?php endif;?>
							<?php if($location):?><li><i class="icon feather icon-map-pin"></i> <?=$location?></li><?php endif;?>
							<?php if($email):?><li><i class="icon feather icon-mail"></i><?=$email?></li><?php endif;?>
							<?php if($external_link):?><li><i class="icon feather icon-link"></i><a target="_blank" href="<?=$external_link?>"><?php echo ($external_link_title) ? $external_link_title : $external_link;?></a></li><?php endif;?>
						</ul>
						</div>        
					</div>
				</div>
			</div>
		</div>
	</div>
</div>