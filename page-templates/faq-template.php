<?php 
/**
 * Template Name: FAQs Page
 * @desc Student FAQs Page
 * @params {title} title of the page
 * @params {short_content} content of the page
 * @params {faqs} [Array] array of faqs
 * @params {newfaqs} [Array] array of faqs of the students
*  @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */
if(is_user_logged_in()){
    get_header('loggedin');
}else{
    get_header();
}
$page_title = get_field('page_title');
$short_content = get_field('short_content'); 
$faqs = get_field('faqs'); 
$newfaqs = get_field('new_student_faqs'); 
?>
<?php
if(is_user_logged_in()){
    ?>
    <div id="layoutSidenav_content">
<?php
}
?>
<section class="faqs-box-wrapper pb-15">
	<div class="inner-page-heading pt-15 pb-8">
		<div class="container">
			<div class="row">
				<div class="col-md-10 offset-md-1">
				<div class="breadcrumb-wrapper d-none">
				<?php roshan_breadcrumbs();?>
				</div>
				<h1><?php if($page_title ): echo $page_title ; endif;?></h1>
				<p><?php if($short_content ): echo $short_content ; endif;?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1">
			<?php if(is_user_logged_in()) {?>
                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="<?php echo home_url('/faqs/');?>" class="nav-link active" id="nav-faqs-tab" data-bs-toggle="pill" data-bs-target="#nav-faqs" type="button" role="tab" aria-controls="nav-faqs" aria-selected="true"><?php echo __('FAQs','ngondro_gar');?></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="<?php echo home_url('/new-student-faqs/');?>" class="nav-link"><?php echo __('New Student FAQs','ngondro_gar');?></a>
                    </li>
                </ul>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-faqs" role="tabpanel" aria-labelledby="nav-faqs-tab">
                    <div class="faqs-box-inner">
                    <div class="accordion" id="accordionfaq">
                        <?php
                        if($faqs) {
                            $i = 0;
                            foreach( $faqs as $faq ) {
                                $faq_question = $faq['faq_question'];
                                $faq_answer = $faq['faq_answer']; ?>
                                <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?php echo $i;?>">
                                <button class="accordion-button <?php echo ($i == 0) ? '': 'collapsed';?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapse<?php echo $i;?>">
                                <?php if($faq_question): echo $faq_question; endif;?>
                                </button>
                                </h2>
                                <div id="collapse<?php echo $i;?>" class="accordion-collapse collapse <?php echo ($i == 0) ? 'show': '';?>" aria-labelledby="heading<?php echo $i;?>" data-bs-parent="#accordionfaq">
                                <div class="accordion-body">
                                <p><?php if($faq_answer): echo $faq_answer; endif;?></p>
                                </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                            }
                        } ?>
                        </div>
                    </div>
                    </div>

                </div>
            <?php } else { ?>
				<div class="faqs-box-inner">
				<div class="accordion" id="accordionfaq">
					<?php
					if($faqs) {
						$i = 0;
						foreach( $faqs as $faq ) {
							$faq_question = $faq['faq_question'];
							$faq_answer = $faq['faq_answer']; ?>
							<div class="accordion-item">
							<h2 class="accordion-header" id="heading<?php echo $i;?>">
							<button class="accordion-button <?php echo ($i == 0) ? '': 'collapsed';?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapse<?php echo $i;?>">
							<?php if($faq_question): echo $faq_question; endif;?>
							</button>
							</h2>
							<div id="collapse<?php echo $i;?>" class="accordion-collapse collapse <?php echo ($i == 0) ? 'show': '';?>" aria-labelledby="heading<?php echo $i;?>" data-bs-parent="#accordionfaq">
							<div class="accordion-body">
							<p><?php if($faq_answer): echo $faq_answer; endif;?></p>
							</div>
							</div>
						</div>
						<?php
						$i++;
						}
					} ?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<section class="contact-cta-section pb-15">
	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4">
				<div class="cta-box-inner text-center">
					<h4><?php echo __('Still have questions?','ngondro_gar');?> </h4>
					<p><?php echo __('Please send us your enquiries','ngondro_gar');?></p>
					<a href="<?=home_url('/contact')?>" class="btn btn-lg btn-default"><?php echo __('Contact us','ngondro_gar');?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
if(is_user_logged_in()){
    ?>
    <?php get_footer();?>
    </div>
    <?php
}
?>
<?php get_footer();?>