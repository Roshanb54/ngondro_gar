<?php 
/**
 * Template Name: Overview Page
 * @desc Practice hours for each Ngöndro section
 * @params {title} title of the page
 * @params {short_content} content of the page
 * @returns {wp_get_current_user} [Array] Returns array of loggedin user info
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {terms} [object] Return all curriculums 
 * @params {subjects} [Array] Array of curriculum
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {get_users()} [object] Return users details
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */
if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
}
global $post;
$page_title = get_field('page_title');
$short_content = get_field('short_content');
if(!is_user_logged_in()){
?>
<section class="overview-page-wrapper pb-15">
	<div class="inner-page-heading pt-15 pb-8">
		<div class="container">
			<div class="row">
				<div class="col-md-10 offset-md-1">
				<div class="breadcrumb-wrapper d-none">
				<?php roshan_breadcrumbs();?>
				</div>
				<h2><?php if($page_title ): echo $page_title ; endif;?></h2>
					<p><?php if($short_content ): echo $short_content ; endif;?>
  					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<div class="overview-content-inner">
				<?php the_content();?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="practice-hours-section pb-15">
	<div class="container">
		<div class="row"><div class="col-md-10 offset-md-1 pb-8"><h4 class="text-center"><?php echo __('Practice hours for each Ngöndro section','ngondro_gar');?></h4></div></div>
		<div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button button-lnn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo __('Longchen Nyingtik Ngöndro (LNN)','ngondro_gar');?>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <?php
                                $lnn_data = get_field('lnn', $post->ID);
                                $lnn_total = 0;
                                ?>
                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="bg-white"><?php echo __('Outer General Preliminaries','ngondro_gar');?></th>
                                        <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($lnn_data['outer_preliminaries'] as $lnn):
                                        $lnn_total += $lnn['hours'];
                                        ?>
                                        <tr>
                                            <td><?php echo __($lnn['title'], 'ngondro_gar');?></td>
                                            <td><?php echo __($lnn['hours'],'ngondro_gar');?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                                <table class="table table-borderless">
                                    <thead class="">
                                    <tr>
                                        <th scope="col" class="bg-white"><?php echo __('Uncommon Inner Preliminaries','ngondro_gar');?></th>
                                        <th scope="col" class="bg-white"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($lnn_data['inner_preliminaries'] as $lnn):
                                        $lnn_total += $lnn['hours'];
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
                            <button class="accordion-button button-cnn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <?php echo __('Chetsün Nyingtik Ngöndro (CNN)','ngondro_gar');?>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php
                                $cnn_data = get_field('cnn', $post->ID);
                                $cnn_total = 0;?>
                                <table class="table table-borderless">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="bg-white"><?php echo __('Outer General Preliminaries','ngondro_gar');?></th>
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
                                <table class="table table-borderless">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="bg-white"><?php echo __('Uncommon Inner Preliminaries','ngondro_gar');?></th>
                                        <th scope="col" class="bg-white"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($cnn_data['inner_preliminaries'] as $cnn):
                                        $cnn_total += $cnn['hours'];
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
                            <button class="accordion-button button-kmn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <?php echo __('Kagyu Mahamudra Ngöndro (KMN)','ngondro_gar');?>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php
                                $kmn_data = get_field('kmn', $post->ID);
                                $kmn_total = 0;?>
                                <table class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="bg-white"></th>
                                        <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($kmn_data['outer_preliminaries'] as $kmn):
                                        $kmn_total += $kmn['hours'];
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
                                <?php
/*                                if($kmn_data['inner_preliminaries']):*/?><!--
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="bg-white">Special Preliminaries</th>
                                            <th scope="col" class="bg-white"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php /*foreach($kmn_data['inner_preliminaries'] as $kmn):
                                            $kmn_total += $kmn['hours'];
                                            */?>
                                            <tr>
                                                <td><?/*=$kmn['title']*/?></td>
                                                <td><?/*=$kmn['hours']*/?></td>
                                            </tr>
                                        <?php /*endforeach;*/?>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td><strong><?/*=$kmn_total*/?></strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                --><?php /*endif;*/?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		</div>
	</div>
</section>
    <?php get_footer();?>
    <?php }else {
        ?>
    <div id="layoutSidenav_content">
        <section class="overview-page-wrapper pb-15">
            <div class="inner-page-heading pt-10 pb-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="breadcrumb-wrapper">
                                <?php roshan_breadcrumbs();?>
                            </div>
                            <h2><?php if($page_title ): echo $page_title ; endif;?></h2>
                            <p><?php if($short_content ): echo $short_content ; endif;?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="overview-content-inner">
                            <?php the_content();?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="practice-hours-section pb-15">
            <div class="container">
                <div class="row"><div class="col-md-12 pb-8"><h4 class="text-center"><?php echo __('Practice hours for each Ngöndro section','ngondro_gar');?></h4></div></div>
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button button-lnn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <?php echo __('Longchen Nyingtik Ngöndro (LNN)','ngondro_gar');?>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table table-borderless">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="bg-white"><?php echo __('Outer General Preliminaries','ngondro_gar');?></th>
                                                <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?php echo __('1. Precious Human Rebirth','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('2. Impermanence and Death','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('3. Karma','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('4. Defects of Samsara','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>

                                            <tr>
                                                <td><?php echo __('5. Benefits of liberation','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('6. Attending a Spiritual Master','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('7. Shamatha','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-borderless">
                                            <thead class="">
                                            <tr>
                                                <th scope="col" class="bg-white"><?php echo __('Uncommon Inner Preliminaries','ngondro_gar');?></th>
                                                <th scope="col" class="bg-white"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?php echo __('1. Refuge and Prostrations','ngondro_gar');?></td>
                                                <td>360</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('2. Bodhicitta','ngondro_gar');?></td>
                                                <td>360</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('3. Vajrasattva - Outer','ngondro_gar');?></td>
                                                <td>360</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('3. Vajrasattva - Inner','ngondro_gar');?></td>
                                                <td>60</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('4. Mandala Offering','ngondro_gar');?></td>
                                                <td>300</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('5. Kusali Mandala Offering','ngondro_gar');?></td>
                                                <td>60</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('6. Guru Yoga: Seven Line Prayer','ngondro_gar');?> </td>
                                                <td>120</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('7. Guru Yoga: Seven Branch Offering','ngondro_gar');?> </td>
                                                <td>120</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('8. Guru Yoga: Short Supplication ','ngondro_gar');?></td>
                                                <td>120</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('9. Guru Yoga: Mantra','ngondro_gar');?> </td>
                                                <td>120</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('10. Guru Yoga: Empowerments ','ngondro_gar');?></td>
                                                <td>60</td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                                <td><strong>2258</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button button-cnn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <?php echo __('Chetsün Nyingtik Ngöndro (CNN)','ngondro_gar');?>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table table-borderless">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="bg-white"><?php echo __('Longchen Nyingtik Ngöndro (LNN)','ngondro_gar');?></th>
                                                <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?php echo __('1. Impermanence ','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('2. Futility of Samsaric Pleasure ','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('3. Endlessness of Ordinary Activities','ngondro_gar');?> </td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('4. Pointlessness of This Life\'s Projects','ngondro_gar');?> </td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('5. The Value of Liberation','ngondro_gar');?> </td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('6. The Value of the Guru\'s Instructions ','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('7. The Ground of Meditation ','ngondro_gar');?></td>
                                                <td>14</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-borderless">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="bg-white"><?php echo __('Uncommon Inner Preliminaries','ngondro_gar');?></th>
                                                <th scope="col" class="bg-white"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?php echo __('1. Refuge ','ngondro_gar');?></td>
                                                <td>360</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('2. Bodhicitta','ngondro_gar');?></td>
                                                <td>360</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('3. Vajrasattva - outer ','ngondro_gar');?></td>
                                                <td>300</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('4. Vajrasattva - inner','ngondro_gar');?> </td>
                                                <td>60</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('5. Common Mandala ','ngondro_gar');?></td>
                                                <td>300</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('6. Tummo Mandala offering ','ngondro_gar');?></td>
                                                <td>60</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('7. GY:Seven Branches','ngondro_gar');?></td>
                                                <td>180</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('8. GY: Osel nang zhi','ngondro_gar');?></td>
                                                <td>180</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('9. GY: Mantra','ngondro_gar');?></td>
                                                <td>180</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('10. GY Empowerments ','ngondro_gar');?></td>
                                                <td>180</td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                                <td><strong>2258</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button button-kmn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <?php echo __('Kagyu Mahamudra Ngöndro (KMN)','ngondro_gar');?>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="bg-white"></th>
                                                <th scope="col" class="bg-white"><?php echo __('Hours','ngondro_gar');?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?php echo __('1. General Preliminaries, Taking Refuge, and Bodhicitta ','ngondro_gar');?></td>
                                                <td>680</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('2. Meditation and Recitation Practice of Vajrasattva ','ngondro_gar');?></td>
                                                <td>430</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('3. Mandala Offering ','ngondro_gar');?></td>
                                                <td>420</td>
                                            </tr>
                                            <tr>
                                                <td><?php echo __('4. Guru Yoga ','ngondro_gar');?></td>
                                                <td>728</td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo __('Total','ngondro_gar');?></strong></td>
                                                <td><strong>2258</strong></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <?php get_footer()?>
    </div>
    <?php
        }
    ?>


