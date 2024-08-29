<?php
function practice_hours_accordion(){ 
	global $post;
	?>
<div class="practice-hours-section">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button button-lnn" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo __('Longchen Nyingtik Ngöndro (LNN)','ngondro_gar');?>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">

                    <?php
				$lnn_data = get_field('lnn',$post->ID);
				$lnn_total = 0;
				?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="bg-white">
                                    <?php echo __('Outer General Preliminaries','ngondro_gar');?></th>
                                <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($lnn_data['outer_preliminaries'] as $lnn):
						$lnn_total += (int)$lnn['hours'];
						?>
                            <tr>
                                <td><?php echo __($lnn['title'], 'ngondro_gar');?></td>
                                <td><?php echo __($lnn['hours'],'ngondro_gar');?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    <table class="table table-striped">
                        <thead class="">
                            <tr>
                                <th scope="col" class="bg-white">
                                    <?php echo __('Uncommon Inner Preliminaries','ngondro_gar');?></th>
                                <th scope="col" class="bg-white"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($lnn_data['inner_preliminaries'] as $lnn):
						$lnn_total += (int)$lnn['hours'];
						?>
                            <tr>
                                <td><?php echo __($lnn['title'],'ngondro_gar');?></td>
                                <td><?php echo __($lnn['hours'],'ngondro_gar');?></td>
                            </tr>
                            <?php endforeach;?>
                            <tr>
                                <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                <td><strong><?=$lnn_total?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button button-cnn collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <?php echo __('Chetsün Nyingtik Ngöndro (CNN)','ngondro_gar');?>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php
				$cnn_data = get_field('cnn', $post->ID);
				$cnn_total = 0;?>
                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="bg-white">
                                    <?php echo __('Outer General Preliminaries','ngondro_gar');?></th>
                                <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cnn_data['outer_preliminaries'] as $cnn):
						$cnn_total += $cnn['hours'];
						?>
                            <tr>
                                <td><?php echo __($cnn['title'],'ngondro_gar');?></td>
                                <td><?php echo __($cnn['hours'],'ngondro_gar');?></td>
                            </tr>
                            <?php endforeach;?>

                        </tbody>
                    </table>
                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="bg-white">
                                    <?php echo __('Uncommon Inner Preliminaries','ngondro_gar');?></th>
                                <th scope="col" class="bg-white"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cnn_data['inner_preliminaries'] as $cnn):
						$cnn_total += (int)$cnn['hours'];
						?>
                            <tr>
                                <td><?php echo __($cnn['title'],'ngondro_gar');?></td>
                                <td><?php echo __($cnn['hours'],'ngondro_gar');?></td>
                            </tr>
                            <?php endforeach;?>
                            <tr>
                                <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                <td><strong><?=$cnn_total?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button button-kmn collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <?php echo __('Kagyu Mahamudra Ngöndro (KMN)','ngondro_gar');?>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php
				$kmn_data = get_field('kmn', $post->ID);
				$kmn_total = 0;?>
                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="bg-white"></th>
                                <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($kmn_data['outer_preliminaries'] as $kmn):
						$kmn_total += (int)$kmn['hours'];
						?>
                            <tr>
                                <td><?php echo __($kmn['title'],'ngondro_gar');?></td>
                                <td><?=$kmn['hours']?></td>
                            </tr>
                            <?php endforeach;?>
                            <tr>
                                <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                <td><strong><?=$kmn_total?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
 }
add_shortcode('practice_hours', 'practice_hours_accordion');

function instructors_list_shortcode(){ ?>
<div class="row">
    <?php
		$type = "instructor";
		$wpml_lang = apply_filters( 'wpml_current_language', NULL );
		if($wpml_lang=="zh-hant" || $wpml_lang=="zh-hans"){
			$args = array (
				'post_type' => $type,
				'posts_per_page'=> -1,
				'meta_key' => 'first_name',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'hide_empty' => true,
				'meta_query' => array(
					array(
						'key' => 'availability',
						'value' => 'yes',
						'compare' => '='
					)					
				)
			);

			$instructors = new WP_Query( $args );
		}
        elseif($wpml_lang=="pt-pt"){
			$instructors = new WP_Query( 
				array(
					'post_type' => $type,
					'suppress_filters' => true,
					'posts_per_page'=> -1,
					'orderby' => 'title',
					'order' => 'ASC',
					'post_status' => 'publish',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
								array(
									'key' => 'primary_language',
									'value' => 'english',
									'compare' => '='
								),
								array(
									'key' => 'primary_language',
									'value' => 'portugues',
									'compare' => '='
								)
							),
						array(
							'key' => 'availability',
							'value' => 'yes',
							'compare' => '='
						)	
					)
				) 
			);

		}
        elseif($wpml_lang=="es"){
			$instructors = new WP_Query( 
				array(
					'post_type' => $type,
					'suppress_filters' => true,
					'posts_per_page'=> -1,
					'orderby' => 'title',
					'order' => 'ASC',
					'post_status' => 'publish',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
								array(
									'key' => 'primary_language',
									'value' => 'english',
									'compare' => '='
								),
								array(
									'key' => 'primary_language',
									'value' => 'portugues',
									'compare' => '='
								)
							),
						array(
							'key' => 'availability',
							'value' => 'yes',
							'compare' => '='
						)	
					)
				) 
			);

		}
		else{
			$instructors = new WP_Query( 
				array(
					'post_type' => $type,
					'posts_per_page'=> -1,
					'hide_empty' => true,
					'order' => 'ASC',
					'orderby' => 'title',
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
		}

		if($instructors -> have_posts()) :	
			while ($instructors -> have_posts()) : $instructors ->the_post();
			$ins_image = get_field('instructor_photo', get_the_ID());
			$primary_lang[] = get_field('primary_language', get_the_ID());
			$plang = get_field('primary_language', get_the_ID());
			$secondary_lang = get_field('secondary_languages', get_the_ID());
			$ins_userid = get_field('instructor', get_the_ID());
			$languages = array_unique(array_merge($primary_lang, $secondary_lang));
			$languages = implode(', ', $languages);
		?>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="instructor-box-wrapper">
            <a class="ajax-popup"
                href="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=instructor_popup_ajax&post_id=<?php echo get_the_ID(); ?>">
                <img class="instuctor-box" src="<?=$ins_image?>" alt="instructor name" />
                <div class="instructor-details">
                    <h4 class="instructor-name"><?php echo __(get_the_title(get_the_ID()), 'ngondro_gar');?></h4>
                    <div class="languages">
                        <?php echo __('Language: ', 'ngondro_gar');?><?php echo __($plang,'ngondro_gar');?>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>
</div>
<?php }
add_shortcode('instructors', 'instructors_list_shortcode');

function rinpoche_message_shortcode(){
	/* Resources by page type */
	global $post, $wpdb;
	// $resources = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'message'");
	/* Resources by page type */
	$my_current_lang = apply_filters( 'wpml_current_language', NULL );
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'wpdmpro', 
		'posts_per_page' => -1,
		'tax_query' => array(
			array (
				'taxonomy' => 'wpdmtag',
				'field' => 'slug',
				'terms' => 'rinpoche-'.$my_current_lang,
			)
		),
		'meta_query'      => array(
			array(
			'key'         => 'select_type',
			'value'       => 'message',
			'compare'     => '=',
			),
		),
	);
	$resources = get_posts($args);
	?>
<div class="row rinpoche-message-row">
    <div class="col-md-11">
        <div class="ps-10 ps-sm-0">
            <div class="sidebar-inner-box mt-3">
                <?php 
                            if($resources):?>
                <ul>
                    <?php $index = 1; foreach($resources as $resource):
                                        ?>
                    <li class="align-items-center justify-content-between py-3">
                        <div class="d-block align-items-center justify-content-between">
                            <p class="resource-title-wrapper py-2">
                                <?=$resource->post_title?> (<?=$resource->post_date?>)
                            </p>
                            <p> <?=$resource->post_content;?> </p>
                            <div class="d-block">
                                <?php
									echo do_shortcode('[wpdm_package id='.$resource->ID.']')
								?>
                            </div>
                        </div>
                    </li>
                    <?php $index++; endforeach;?>
                </ul>
                <?php else:?>
                <p> No Data Found ! </p>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<?php
}
add_shortcode('rinpoche_message', 'rinpoche_message_shortcode');

function rinpoche_teaching_shortcode(){ 	
	global $post, $wpdb;
	/* Resources by type */
	// $resources_tr = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'refuge'");
	// $resources_tb = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'bodhicitta'");
	// $resources_other = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'others'");
	/*Teaching on Refuge*/



	$args1 = array(
		'fields' => 'ids',
		'post_status' => 'publish',
		'post_type' => 'wpdmpro', 
		'posts_per_page' => 1,
			
	);


	$get_data = get_posts($args1);
	$pid = $get_data[0];
	$types = get_field_object('select_section',$pid)['choices'];




	?>
<div class="row rinpoche-teaching-row">
    <div class="col-md-11">
        <div class="ps-10 ps-sm-0">
			<?php foreach($types as $key=> $data){ ?>
				
            <h5 class="mt-5"><?php echo 'Teaching on ' . $data;?></h5>
            <div class="sidebar-inner-box">
                <?php 

					$args2 = array(
						'post_status' => 'publish',
						'post_type' => 'wpdmpro', 
						'posts_per_page' => -1,
						'tax_query' => array(
							array (
								'taxonomy' => 'wpdmtag',
								'field' => 'slug',
								'terms' => 'rinpoche',
							)
						),
						'meta_query'      => array(
							'relation' => 'AND',
							array(
							'key'         => 'select_type',
							'value'       => 'teaching',
							'compare'     => '=',
							),
							array(
								'key'         => 'select_section',
								'value'       => $key,
								'compare'     => '=',
							),
						),
					);

					$resources_new = get_posts($args2);
				if($resources_new):
				?>
                <ul>
                    <?php $index = 1; foreach($resources_new as $resource):
					?>
                    <li class="align-items-center justify-content-between py-3">
                        <div class="d-block align-items-center justify-content-between py-3">
                            <p class="resource-title-wrapper py-2">
                                <?=$resource->post_title?> (<?=$resource->post_date?>)
                            </p>
                            <p> <?=$resource->post_content;?> </p>
                            <div class="d-block">
                                <?php
									echo do_shortcode('[wpdm_package id='.$resource->ID.']')
								?>
                            </div>
                        </div>
                    </li>
                    <?php $index++; endforeach;?>
                </ul>
                <?php else:?>
                <p> No Data Found ! </p>
                <?php endif;?>
            </div>
			<?php } ?>
        </div>
    </div>
</div>

<?php }
add_shortcode('rinpoche_teaching', 'rinpoche_teaching_shortcode');

function rinpoche_teacher_shortcode(){ 	
	global $post, $wpdb;
	/* Resources by type */
	// $resources_tr = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'refuge'");
	// $resources_tb = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'bodhicitta'");
	// $resources_other = $wpdb->get_results("Select * from ngondro_rinpoche where page_type = 'teaching' AND cat_type= 'others'");
	/*Teaching on Refuge*/


 

    $cat_id = $_GET['id'];
    $term = get_term($cat_id);

    
    // echo "<pre>";
    // print_r($term);

 


    $arguments = array('taxonomy' => 'rinpoche_cats',
                    'orderby' => 'menu_order',
                    'order'   => 'ASC',  
                    'parent'=> $term->term_taxonomy_id,
                    'hide_empty' => 0);
                
    $sub_categories = get_categories($arguments);
    if($sub_categories){
    // echo "<pre>";
    // print_r($sub_categories);
	?>

<div class="row rinpoche-teaching-row">
    <div class="col-md-11">
        <div class="ps-10 ps-sm-0">
			<?php
            //  foreach($types as $key=> $data){
                foreach($sub_categories as $sub){
            ?>
				
            <h5 class="mt-5"><?php echo $sub->cat_name;?></h5>
            <div class="sidebar-inner-box">
                <?php 

                    

                    $args3 = array(
                        'post_status' => 'publish',
                        'post_type' => 'wpdmpro', 
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array (
                                'taxonomy' => 'rinpoche_cats',
                                'field' => 'slug',
                                'terms' => $sub->category_nicename,
                            )
                        ),
                    );
                    $new_data = get_posts($args3);


				if($new_data):
				?>
                <ul>
                    <?php $index = 1; foreach($new_data as $resource):
					?>
                    <li class="align-items-center justify-content-between py-3">
                        <div class="d-block align-items-center justify-content-between py-3">
                            <p class="resource-title-wrapper py-2">
                                <?=$resource->post_title?> (<?=$resource->post_date?>)
                            </p>
                            <p> <?=$resource->post_content;?> </p>
                            <div class="d-block">
                                <?php
									echo do_shortcode('[wpdm_package id='.$resource->ID.']')
								?>
                            </div>
                        </div>
                    </li>
                    <?php $index++; endforeach;?>
                </ul>
                <?php else:?>
                <p> No Data Found ! </p>
                <?php endif;?>
            </div>
			<?php } ?>
        </div>
    </div>
</div>

<?php 
    }else{

        $argumets_msg = array(
            'post_status' => 'publish',
            'post_type' => 'wpdmpro', 
            'posts_per_page' => -1,
            'tax_query' => array(
                array (
                    'taxonomy' => 'rinpoche_cats',
                    'field' => 'slug',
                    'terms' => $term->slug,
                )
            ),
        );
        $message_data = get_posts($argumets_msg);

        // echo "<pre>";
        // print_r($message_data);

  

    ?>
    <div class="row rinpoche-message-row">
    <div class="col-md-11">
        <div class="ps-10 ps-sm-0">
            <div class="sidebar-inner-box mt-3">
                <?php 
                            if($message_data):?>
                <ul>
                    <?php $index = 1; foreach($message_data as $resource):
                                        ?>
                    <li class="align-items-center justify-content-between py-3">
                        <div class="d-block align-items-center justify-content-between">
                            <p class="resource-title-wrapper py-2">
                                <?=$resource->post_title?> (<?=$resource->post_date?>)
                            </p>
                            <p> <?=$resource->post_content;?> </p>
                            <div class="d-block">
                                <?php
									echo do_shortcode('[wpdm_package id='.$resource->ID.']')
								?>
                            </div>
                        </div>
                    </li>
                    <?php $index++; endforeach;?>
                </ul>
                <?php else:?>
                <p> No Data Found ! </p>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
    <?php

    }
}
add_shortcode('rinpoche_teacher', 'rinpoche_teacher_shortcode');