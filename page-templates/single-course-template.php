<?php 
/**
 * Template Name: Single Course Page
 * @desc Single curriculum page 
 * @params {section_title} title of the section
 * @params {cid} current curriculum ID
 * @params {subcatid} sub curriculum ID
 */
get_header('loggedin');

global $wpdb;
$cid = isset($_GET['cid'])?$_GET['cid']:1;
$secid = isset($_GET['secid'])?$_GET['secid']:1;
$subcatid = isset($_GET['sub'])?$_GET['sub']:"";
$secid = str_replace("/","",$secid);

$course = $wpdb->get_row("Select * from ngondro_courses where course_id =".$cid);
$section = $wpdb->get_row("Select * from ngondro_course_cats where course_id =".$cid. " AND cat_id=".$secid);
$section_title = $section->title;

if($subcatid!="")
{
    $resources = $wpdb->get_results("Select * from ngondro_resources where category = '$cid' AND section ='$secid' AND subcat = '$subcatid'");
}
else{
    $resources = $wpdb->get_results('Select * from ngondro_resources where category = '.$cid.' AND section ='.$secid);
}

?>

<div id="layoutSidenav_content">
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
            <div class="container-xl px-10">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"></div>
                                <?php 
                                    if($course->title == 'Alt'){
                                        echo __('General','ngondro_gar');
                                    }
                                    else {
                                        echo __($course->title, 'ngondro_gar');
                                    } 
                                    ?> 
                                    <?php if($course->short_name!=""){
                                        // echo "(".__($course->short_name,'ngondro_gar').")";
                                    }
                                    else{
                                        if($course->short_name == 'Alt'){
                                            echo __('General','ngondro_gar');
                                        }
                                        else {
                                            echo __($course->short_name, 'ngondro_gar');
                                        }
                                    }
                                 ?>
                            </h1>
                        </div>
                    </div>


                </div>
            </div>
        </header>
        <!-- Main page content-->
        <section class="liturgy-page mb-12">
            <div class="container-xl px-10">
                <div class="row mt-6 mb-3">
                    <div class="col-auto">
                        <h4><?php echo __($section_title, 'ngondro_gar');?></h4>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="sidebar-inner-box">
                            <?php 
                                if($resources):?>
                                    <ul>
                                        <?php $index = 1; foreach($resources as $resource):
                                            ?>
                                            <li class="align-items-center justify-content-between py-3">
                                                <div class="d-flex align-items-center justify-content-between py-3">
                                                    <p>
                                                        <?=$index?>. <?=$resource->title?> (<?=$resource->created_at?>)
                                                    </p>
                                                   
                                                    <div class="d-flex">
                                                        <?php
                                                            if($resource->file_type=="file" || $resource->file_type=="external"):?>
                                                                <a href="<?=$resource->link?>" class="ellipse download d-flex align-items-center justify-content-center bg-white me-2" download>
                                                                    <i class="icon feather icon-download"></i>
                                                                </a>
                                                            <?php elseif($resource->file_type=="audio" || $resource->file_type=="video"):?>
                                                                <a href="<?=$resource->link?>" data-link="<?=$resource->link?>" class="ellipse read-more d-flex align-items-center justify-content-center me-2">
                                                                    <i class="icon feather icon-play"></i>
                                                                </a>
                                                            <?php endif;?>
                                                    </div>
                                                </div>
                                                <?php if($resource->password!="") :?> <p> <strong> Password: </strong> <?=$resource->password ?></p> <?php endif;?>
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
        </section>
    </main>
    <?php get_footer() ?>
</div>
