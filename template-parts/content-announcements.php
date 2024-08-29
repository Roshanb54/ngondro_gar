<?php
/*
 * @desc display all announcements
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {get_user_meta} [object] Return all user meta values 
 * @params {get_the_title} [Value] Return title of the page/post
 * @returns {get_field()} [Value] Return acf field value base on field key
 * @returns {get_the_permalink()} Return the post url by post ID
 */
?>

<div class="announcement-row mt-5 newclass">
    <div class="col-md-12 offset-md-0 mb-1">
        <div class="announcements-box-wrapper">
            <div class="box-title-wrapper align-items-center justify-content-start">
                <div class="ellipse d-flex align-items-center justify-content-center me-2">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.907 5.622c.062.208.093.424.093.641V17.74a2.25 2.25 0 0 1-2.891
                                                2.156l-5.514-1.64a4.002 4.002 0 0 1-7.59-1.556L6 16.5l-.001-.5-2.39-.711A2.25 2.25
                                                0 0 1 2 13.131V10.87a2.25 2.25 0 0 1 1.61-2.156l15.5-4.606a2.25 2.25 0 0 1 2.797
                                                1.515ZM7.499 16.445l.001.054a2.5 2.5 0 0 0 4.624 1.321l-4.625-1.375Zm12.037-10.9-15.5
                                                4.605a.75.75 0 0 0-.536.72v2.261a.75.75 0 0 0 .536.72l15.5 4.607a.75.75 0 0
                                                0 .964-.72V6.264a.75.75 0 0 0-.964-.719Z" fill="#5C144D"/>
                    </svg>
                </div>
                <h3><?php echo __('Recent announcements','ngondro_gar');?></h3>
            </div>
            <div class="announcements-content-wrapper">
                <?php
                $my_current_lang = apply_filters( 'wpml_current_language', NULL );
                $lang = get_the_author_meta( 'language', get_current_user_id() );
                $type = "announcement";
				
				$neutral = get_posts(array(
                    'numberposts'   => -1,
                    'fields' => 'ids',
                    'post_type'     => $type,
                    'meta_key'      => 'language',
                    'meta_value'    => 'und',
                    'meta_compare' => '='
                ));

                $ann_posts = get_posts(array(
                        'post_type' => $type,
                    	'fields' => 'ids',
                        'suppress_filters' => false,
                        'numberposts'   => -1,
                        'orderby' => 'Id',
                        'hide_empty' => true,
                        'order' => 'DESC',
                        'post_status' => 'publish',
                    ) 
                );
				
				$ann = array_merge($neutral, $ann_posts);
				$announcements = array_unique($ann);

                ?>
                <div class="announcements-slider">

                    <?php
                    if($announcements) :
                        foreach($announcements as $ann):
							$post = get_post($ann);
                            $title = get_the_title($ann);
                            $name = get_field('name', $ann);
                            $location = get_field('location', $ann);
                            $external_link = get_field('external_link', $ann);
                            $external_link_title = get_field('external_link_title', $ann);
                            $email = get_field('email', $ann);
                            $short_description = get_field('short_description', $ann);
                            $fdate = get_field('from_date',$ann);
                            $tdate = get_field('to_date', $ann);

                            $fdate = date_create($fdate);
                            $fdate = date_format($fdate, 'j F Y');
                            // $tdate = date("j F Y");
                            $tdate = date_create($tdate);
                            $tdate = date_format($tdate, 'j F Y');

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

                            <div class="single-announcement-item">
                                <?php if(($fdate!=NULL || $fdate!="") ):?>
                                    <div class="accouncement-date-wrapper">
                                        <div class="text-center announcement-date-inner">
                                            <?php if(($fdate!=NULL || $fdate!="") && ($tdate!=NULL || $tdate!="") ):?>
                                                <i class="icon feather icon-calendar"></i>
                                                <h4 style="font-size: 1rem;"><?=$fdate?></h4>
                                                <p><?php echo __('to','ngondro_gar');?></p>
                                                <h4 style="font-size: 1rem;"><?=$tdate?></h4>
                                            <?php elseif( ($tdate==NULL || $tdate=="") && ($fdate!=NULL || $fdate!="") ) :?>
                                                <i class="icon feather icon-calendar"></i>
                                                <h4 style="font-size: 1rem;"><?=$fdate?></h4>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                <?php endif;?>
                                <div class="announcement-content-inner">
                                    <h4><?=$title?></h4>
                                    <p>
                                        <?php 
                                        $content_post = get_post($ann);
                                        $content = $content_post->post_content;
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        // strip tags to avoid breaking any html
                                        $string = strip_tags($content);
                                        if (strlen($string) > 250) {

                                            // truncate string
                                            $stringCut = substr($string, 0, 250);
                                            $endPoint = strrpos($stringCut, ' ');

                                            //if the string doesn't contain any space then it will cut without word basis.
                                            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                            $string .= '... <a  class="ajax-popup" href="'.admin_url( 'admin-ajax.php' ).'?action=announcement_popup_ajax&post_id='.$ann.'">Read More</a>';
                                        }
                                        echo $string;
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
                        <?php endforeach; endif;?>

                </div>
            </div>
        </div>
    </div>
</div>