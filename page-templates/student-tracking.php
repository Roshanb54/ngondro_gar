<?php
/**
 * Template Name: Student Tracking Page
 * @desc Student Tracking Page. Page has list of all the enrolled students.
 * @function {get_current_user_id} Returns id of loggedin user 
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {get_users()} [object] Return users details
 * @returns {get_field()} [Value] Return acf field value base on field key
 */

get_header('loggedin');

$current_user_id = get_current_user_id();

$students = get_users(
    array(
        'role' => 'student',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'ng_user_approve_status',
                'value' => 'approved',
                'compare' => '='
            ),
            array(
                'key' => 'instructor',
                'value' => get_current_user_id(),
                'compare' => '='
            )
            ),
        // 'meta_key' => 'instructor',
        // 'meta_value' => get_current_user_id(),
        'number' => -1
    )
);

?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.1.0/css/fixedColumns.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

<style>
    .search-box {
    display: flex;
    margin-left: auto;
    justify-content: end;
    gap: 5px;
    flex-wrap: wrap;

}

.all-students input {
    visibility: visible;
    margin-left: 0 !important;
}

.all-students {
    display: flex;
    align-items: center;
    flex-direction: row-reverse;
    margin: 0 25px;
}

.all-students>span {
    margin: 0px 25px;
}
</style>

<div id="layoutSidenav_content">
    <div class="container h-100">
        <div class="row">
            <div class="col-md-12 pt-6">
                <h2 class="fw-bold"><?php echo __('Students Tracking','ngondro_gar');?></h2>
                <p><?php echo __('This page has list of all the enrolled students. Total students : ','ngondro_gar');?><?=count($students)?>
                </p>
                <div class="search-filter-wrapper clearfix">
                    <a id="filter-form-hideable_link" href="javascript:void(0);">
                        <?php echo __('Hide/show filtering options','ngondro_gar');?>
                    </a>
                </div>
                <?php
                    if(isset($_GET['report'])){
                        if($_GET['report']=="student"){
                            $rtitle = "Reported Student";
                        }
                        
                    }
                    else if(isset($_GET['filter']) && $_GET['filter']=="curriculum"){
                        if($_GET['filter']=="curriculum"){
                            $curr_val = $_GET['val'];
                            $ctitle = $wpdb->get_row("Select * from ngondro_courses where course_id = ".$curr_val);
                            $rtitle = "Filter By Curriculum :".$ctitle->short_name;
                        }
                    }
                    else if(isset($_GET['filter']) && $_GET['filter']=="language"){
                        $curr_val = $_GET['val'];
                        if($curr_val=="en"){$lang="English";}
                        if($curr_val=="zh-hant"){$lang="繁體中文";}
                        if($curr_val=="zh-hans"){$lang="简体中文";}
                        if($curr_val=="pt-br"){$lang="Português";}
                        if($curr_val=="es"){$lang="Spanish";}
                        $rtitle = "Filter By Language :".$lang;
                        
                    }
                    else if(isset($_GET['filter']) && $_GET['filter']=="graduate"){
                        $curr_val = $_GET['val'];
                        $rtitle = "Filter By Graduate :".$curr_val;
                    }
                    else if(isset($_GET['filter']) && $_GET['filter']=="exempt"){
                        $curr_val = $_GET['val'];
                        $rtitle = "Filter By Exempt :".$curr_val;
                    }
                    else if(isset($_GET['summary']) && $_GET['summary']=="not_reported"){
                        $rtitle = "Not Reported Student List";
                    }

                    else if(isset($_GET['summary']) && $_GET['summary']=="trailing"){
                        $rtitle = "Trailing Student List";
                    }

                    else if(isset($_GET['mfilter']) && $_GET['mfilter']=="missed"){
                        $rtitle = "Student List of missed report";
                    }
                    else{
                        $rtitle = "All Student List";
                    }
                ?>
                <p><?=$rtitle?></p>

                <div class="advanced-student-filter" id="filter-form-hideable" style="display: none;">
                    <?php 
			 $search_form_name = isset($_GET['search_form_name'])? $_GET['search_form_name'] : Null;
			 ?>
                    <form action="<?php echo home_url('student-tracking');?>" method="GET" id="student-filter-form"
                        class="student-filter-form">
                        <div class="form-item form-type-checkboxes form-item-label">
                            <label for="edit-ngondro" class="label-left"
                                style="width: 6rem; margin: 0;"><?php echo __('Language','ngondro_gar');?></label>
                            <div class="form-item form-type-checkbox form-item-ngondro-en">
                                <label class="option" for="edit-ngondro-en">
                                    <input id="edit-ngondro-en" name="lang[en]" value="en" class="form-checkbox"
                                        type="checkbox"
                                        <?php if (isset($_GET['lang']) && in_array('en', $_GET['lang'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    English </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-ngondro-zh-hant">
                                <label class="option" for="edit-ngondro-zh-hant">
                                    <input id="edit-ngondro-zh-hant" name="lang[zh-hant]" value="zh-hant"
                                        class="form-checkbox" type="checkbox"
                                        <?php if (isset($_GET['lang']) && in_array('zh-hant', $_GET['lang'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    Traditional </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-ngondro-zh-hans">
                                <label class="option" for="edit-ngondro-zh-hans">
                                    <input id="edit-ngondro-zh-hans" name="lang[zh-hans]" value="zh-hans"
                                        class="form-checkbox" type="checkbox"
                                        <?php if (isset($_GET['lang']) && in_array('zh-hans', $_GET['lang'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    Simplified </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-ngondro-pt-br">
                                <label class="option" for="edit-ngondro-pt-br">
                                    <input id="edit-ngondro-pt-br" name="lang[pt-br]" value="pt-br"
                                        class="form-checkbox" type="checkbox"
                                        <?php if (isset($_GET['lang']) && in_array('pt-br', $_GET['lang'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    Portuguese </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-ngondro-es">
                                <label class="option" for="edit-ngondro-es">
                                    <input id="edit-ngondro-es" name="lang[es]" value="es" class="form-checkbox"
                                        type="checkbox"
                                        <?php if (isset($_GET['lang']) && in_array('es', $_GET['lang'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    Spanish </label>
                            </div>
                        </div>
                        <div class="form-item form-type-textfield form-item-label">
                            <label for="edit-region"
                                style="width: 6rem; margin: 0;"><?php echo __('Region','ngondro_gar');?></label>
                            <?php 
				//get dropdown saved value
				global $wpdb;
				$countries = $wpdb->get_results("Select * From `countries_data`");
				$selected_region = $_GET['region'];
				?>
                            <select id="region" name="region">
                                <option value=""><?php echo __('Select Your Region','ngondro_gar');?></option>
                                <option value="Asia" <?php echo ('Asia'==$selected_region)?"selected":"";?>>Asia
                                </option>
                                <option value="North America"
                                    <?php echo ('North America'==$selected_region)?"selected":"";?>>North America
                                </option>
                                <option value="South America"
                                    <?php echo ('South America'==$selected_region)?"selected":"";?>>South America
                                </option>
                                <option value="Europe" <?php echo ('Europe'==$selected_region)?"selected":"";?>>Europe
                                </option>
                                <option value="Africa" <?php echo ('Africa'==$selected_region)?"selected":"";?>>Africa
                                </option>
                                <option value="Oceania" <?php echo ('Oceania'==$selected_region)?"selected":"";?>>
                                    Oceania</option>
                                <?php 
							$region = $selected_region;
							foreach($countries as $data): $selected = ($data->nicename==$region)?"selected":"";?>
                                <option value="<?=$data->nicename?>" <?=$selected?>><?=$data->name?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-item form-type-textfield form-item-label">
                            <label for="edit-address"
                                style="width: 6rem; margin: 0;"><?php echo __('Address','ngondro_gar');?></label>
                            <input id="edit-address" name="address" class="form-text" style="width:200px;" type="text"
                                value="<?php if(isset($_GET['address'])): echo $_GET['address']; endif; ?>" size="4"
                                maxlength="128">
                        </div>
                        <div class="form-item form-type-textfield form-item-label">
                            <label for="edit-city" style="width: 6rem; margin: 0;">City</label>
                            <input id="edit-city" name="city" class="form-text" style="width:200px;" type="text"
                                value="<?php if(isset($_GET['city'])): echo $_GET['city']; endif; ?>" size="4"
                                maxlength="128">
                        </div>
                        <div class="form-item form-type-checkboxes form-item-label">
                            <label for="edit-curriculum" class="label-left"
                                style="width: 6rem; margin: 0;"><?php echo __('Curriculum','ngondro_gar');?></label>

                            <div class="form-item form-type-checkbox form-item-curriculum-LNN">
                                <label class="option" for="edit-curriculum-LNN">
                                    <input id="edit-curriculum-LNN" name="curriculum[LNN]" value="2"
                                        class="form-checkbox" type="checkbox"
                                        <?php if (isset($_GET['curriculum']) && in_array(2, $_GET['curriculum'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    LNN </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-curriculum-CNN">
                                <label class="option" for="edit-curriculum-CNN">
                                    <input id="edit-curriculum-CNN" name="curriculum[CNN]" value="3"
                                        class="form-checkbox" type="checkbox"
                                        <?php if (isset($_GET['curriculum']) && in_array(3, $_GET['curriculum'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    CNN </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-curriculum-KMN">
                                <label class="option" for="edit-curriculum-KMN">
                                    <input id="edit-curriculum-KMN" name="curriculum[KMN]" value="4"
                                        class="form-checkbox" type="checkbox"
                                        <?php if (isset($_GET['curriculum']) && in_array(4, $_GET['curriculum'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    KMN </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-curriculum-Alt">
                                <label class="option" for="edit-curriculum-Alt">
                                    <input id="edit-curriculum-Alt" name="curriculum[Alt]" value="1"
                                        class="form-checkbox" type="checkbox"
                                        <?php if (isset($_GET['curriculum']) && in_array(1, $_GET['curriculum'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    Alt </label>
                            </div>
                        </div>
                        <div class="form-item form-type-checkboxes form-item-label">
                            <label for="edit-track" class="label-left"
                                style="width: 6rem; margin: 0;"><?php echo __('Track','ngondro_gar');?></label>
                            <div class="form-item form-type-checkbox form-item-track-5">
                                <label class="option" for="edit-track-5">
                                    <input id="edit-track-5" name="track[0.5]" value="0.5" class="form-checkbox"
                                        type="checkbox"
                                        <?php if (isset($_GET['track']) && in_array('0.5', $_GET['track'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    <?php echo __('Half Hour per Day','ngondro_gar');?> </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-track-1">
                                <label class="option" for="edit-track-1">
                                    <input id="edit-track-1" name="track[1]" value="1" class="form-checkbox"
                                        type="checkbox"
                                        <?php if (isset($_GET['track']) && in_array('1', $_GET['track'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    <?php echo __('One Hour per Day','ngondro_gar');?> </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-track-15">
                                <label class="option" for="edit-track-15">
                                    <input id="edit-track-15" name="track[1.5]" value="1.5" class="form-checkbox"
                                        type="checkbox"
                                        <?php if (isset($_GET['track']) && in_array('1.5', $_GET['track'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    <?php echo __('One & Half Hour per Day','ngondro_gar');?> </label>
                            </div>
                            <div class="form-item form-type-checkbox form-item-track-2">
                                <label class="option" for="edit-track-2">
                                    <input id="edit-track-2" name="track[2]" value="2" class="form-checkbox"
                                        type="checkbox"
                                        <?php if (isset($_GET['track']) && in_array('2', $_GET['track'])): echo 'checked'; endif;?>>
                                    <span></span>
                                    <?php echo __('Two Hours per Day','ngondro_gar');?> </label>
                            </div>
                        </div>
                        <div class="form-item form-type-textfield form-item-label">
                            <label for="edit-min_missed"
                                style="width: 6rem; margin: 0;"><?php echo __('Missed last','ngondro_gar');?></label>
                            <input id="edit-min_missed" style="width: 6rem;" name="min_missed" class="form-text number"
                                type="text"
                                value="<?php if(isset($_GET['min_missed'])): echo $_GET['min_missed']; endif; ?>"
                                size="4" maxlength="128">
                            <span class="suffix"> <?php echo __('reports.','ngondro_gar');?></span>
                        </div>
                        <div class="form-item form-type-checkbox2 form-item-label" style="margin: 0;">
                            <div class="label-left"
                                style="display: inline-block;  width: 6rem; margin: 0; font-weight: bold;">
                                <?php echo __('--Exempt','ngondro_gar');?> </div>
                            <label class="option" for="edit-exempt">
                                <input id="edit-exempt" name="exempt" value="exclude" class="form-checkbox"
                                    type="checkbox" <?php if (isset($_GET['exempt'])): echo 'checked'; endif;?>>
                                <span></span>
                                <div class="suffix">
                                    <?php echo __('Click to hide students exempt from reporting expectations.','ngondro_gar');?>
                                </div>
                            </label>
                        </div>

                        <div class="form-item form-type-checkbox2 form-item-label" style="margin: 0;">
                            <div class="label-left"
                                style="display: inline-block;  width: 6rem; margin: 0; font-weight: bold;">
                                <?php echo __('--Graduates','ngondro_gar');?> </div>
                            <label class="option" for="edit-graduate">
                                <input id="edit-graduate" name="graduate" value="exclude" class="form-checkbox"
                                    type="checkbox" <?php if (isset($_GET['graduate'])): echo 'checked'; endif;?>>
                                <span></span>
                                <div class="suffix"> <?php echo __('Click to hide graduates.','ngondro_gar');?></div>
                            </label>
                        </div>
                        <div class="form-item form-type-textfield form-item-label">
                            <label for="edit-started_after"
                                style="width: 6rem; margin: 0;"><?php echo __('Started before','ngondro_gar');?></label>
                            <input type="text" id="edit-started_after" name="started_after"
                                pattern="(?:0[1-9]|1[0-2])/[0-9]{2}" class="form-text number"
                                value="<?php if(isset($_GET['started_after'])): echo $_GET['started_after']; endif; ?>">
                            <span class="suffix">(mm/yy eg 06/22)</span>
                        </div>
                        <div class="form-item form-type-textfield form-item-label">
                            <label for="edit-max_net"
                                style="width: 6rem; margin: 0;"><?php echo __('More than','ngondro_gar');?></label>
                            <input id="edit-max_net" name="max_net" class="form-text number" type="text" value="0"
                                size="4" maxlength="128">
                            <span class="suffix"><?php echo __('hours remaining.','ngondro_gar');?> </span>
                        </div>
                        <input id="edit-update" name="filter_search" value="Filter Table" class="form-submit"
                            type="submit">
                        <input id="edit-clear" value="Reset" class="reset-btn form-submit" type="button">
                    </form>
                </div>

                <div class="row student-tracking-filter mt-2 mb-2">
                    <!-- <div class="col-md-3 ">
                <div class="input-group mb-3">
                    <input type="text" class="form-control sname_input" placeholder="Student Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary sname_btn track_search_btn" data-class=".sname_input" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control semail_input" placeholder="Student Email" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary semail_btn track_search_btn" data-class=".semail_input" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div> -->
                    <!--<div class="col-md-1">
                        <div class="input-group mb-3">
                            <Select class="form-control">
                                <option value="">LNN</option>
                                <option value="">CNN</option>
                                <option value="">KMN</option>
                            </Select>
                        </div>
                    </div>-->
                    <!-- <div class="col">
                        <div class="input-group mb-3">
                            <select class="form-control1 dropdown_filter w-100 px-2" id="course_select">
                                <option value="all">Course</option>
                                <option value="2">LNN</option>
                                <option value="3">CNN</option>
                                <option value="4">KMN</option>
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="col">
                        <div class="input-group mb-3">
                            <Select class="form-control1 dropdown_filter w-100 px-2" id="language_select">
                                <option value="all">Language</option>
                                <option value="en">English</option>
                                <option value="zh-hant">繁體中文</option>
                                <option value="zh-hans">简体中文</option>
                                <option value="pt-br">Português</option>
                            </Select>
                        </div>
                    </div> -->
                    <div class="col-md-9">
                        <div class="show-hide-columns">
                            <div class="hide-show-title" class="label-left">
                                <?php echo __('Hide Columns:','ngondro_gar');?></div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_name">
                                    <input id="col_name" name="col_name" value="1"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Name','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_comitted_hrs">
                                    <input id="col_comitted_hrs" name="col_comitted_hrs" value="2"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Comitted Hours','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_practice">
                                    <input id="col_practice" name="col_practice" value="3"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Practice','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_completed_hrs">
                                    <input id="col_completed_hrs" name="col_completed_hrs" value="4"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Completed  Hours','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_missed_report">
                                    <input id="col_missed_report" name="col_missed_report" value="5"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Missed Report','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_graduate">
                                    <input id="col_graduate" name="col_graduate" value="6"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Graduate','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="ept">
                                    <input id="ept" name="ept" value="7" class="form-checkbox show-hide-checkbox"
                                        type="checkbox">
                                    <span></span>
                                    <?php echo __('Ept','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_region">
                                    <input id="col_region" name="col_region" value="8"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Region','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_lang">
                                    <input id="col_lang" name="col_lang" value="9"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Language','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_email">
                                    <input id="col_email" name="col_email" value="10"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Email','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_social">
                                    <input id="col_social" name="col_social" value="11"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Social Media ID','ngondro_gar');?></label>
                            </div>
                            <div class="form-item form-type-checkbox">
                                <label class="option" for="col_remarks">
                                    <input id="col_remarks" name="col_remarks" value="12"
                                        class="form-checkbox show-hide-checkbox" type="checkbox">
                                    <span></span>
                                    <?php echo __('Remarks','ngondro_gar');?></label>
                            </div>

                            <!-- <label>Show/Hide columns: </label>
                            <a class="toggle-vis" data-column="1">Name</a> - 
                            <a class="toggle-vis" data-column="2">Position</a> - 
                            <a class="toggle-vis" data-column="3">Office</a> - 
                            <a class="toggle-vis" data-column="4">Age</a> - 
                            <a class="toggle-vis" data-column="5">Start date</a> - 
                            <a class="toggle-vis" data-column="6">Salary</a> -->
                        </div>
                    </div>
                    <!--<div class="col-md-2">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Export
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">CSV</a></li>
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">XLS</a></li>
                            </ul>
                        </div>
                    </div>
                    -->
                    <!-- <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div id="buttons"></div>
                        </div>
                    </div> -->
                </div>

                <div class="sidebar-inner-box">
                    <div class="students-list">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custom-table-responsive">
                                    <!-- Student Report history-->
                                    <table class="table table-hover" id="student-table" style="width:100% !important">
                                        <div class="search-box">
                                            <?php if(isset($_POST['submit'])){
                                                $search = $_POST['search_student'];
                                                $selected = '';

                                                if(isset($_POST['all_ndg_students']) && $_POST['all_ndg_students'] == 1){
                                                    $selected = 'checked';
                                                }
                                            }else{
                                                $search = '';
                                            } ?>
                                            <form method="post">
                                                <div class="all-students">
                                                    <!-- <label for="all-ndg-students">All NDG Students</label> -->
                                                    <span>All NDG Students</span>
                                                    <input type="checkbox" name="all_ndg_students" id="all_ndg_students"
                                                        value="1" <?php echo $selected; ?>>
                                                </div>
                                                <input type="text" id="search-student-input" name="search_student"
                                                    value="<?=$search; ?>" autocomplete="off" required>
                                                <input type="submit" value="submit" name="submit">
                                            </form>
                                        </div>
                                        <thead>
                                            <th><?php echo __('No.','ngondro_gar');?></th>
                                            <th style="text-align: left;"><?php echo __('Name','ngondro_gar');?></th>
                                            <th><?php echo __('Commited Hrs','ngondro_gar');?></th>
                                            <th><?php echo __('Practice','ngondro_gar');?></th>
                                            <th style="text-align: right;">
                                                <?php echo __('Completed Hrs','ngondro_gar');?></th>
                                            <th><?php echo __('Missed report','ngondro_gar');?></th>
                                            <th><?php echo __('Graduate','ngondro_gar');?></th>
                                            <th><?php echo __('Ept','ngondro_gar');?></th>
                                            <th><?php echo __('Region','ngondro_gar');?></th>
                                            <th><?php echo __('Language','ngondro_gar');?></th>
                                            <th><?php echo __('Email','ngondro_gar');?></th>
                                            <th><?php echo __('Social Media ID','ngondro_gar');?></th>
                                            <th><?php echo __('Remarks','ngondro_gar');?></th>
                                            <th><?php echo __('Action','ngondro_gar');?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                        $report_text = 'reports/all_student_report_'.$current_user_id.'.csv';
                                        $cfile = fopen($report_text, 'w');
                                        $heading = array("Name", "Commited Hrs", "Practice", "Completed Hrs", "Missed report", "Graduate", "Ept");
                                        fputcsv($cfile,$heading);
                                        global $wpdb;

                                        /*filters*/
                                        if(isset($_GET['filter']))
                                        {
                                            $filter_by = $_GET['filter'];
                                            $filter_val = $_GET['val'];
                                            $students = get_users(
                                                array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => $filter_by,
                                                            'value' => $filter_val,
                                                            'compare' => '='
                                                        )
                                                    )
                                                )
                                            );
                                        }

                                    /*start multiple filter search*/ 
                                    else if(isset($_GET['filter_search']) && 'Filter Table' == $_GET['filter_search']){
                                        $student_args = array(
                                            'role' => 'student',
                                            'meta_query' => array(
                                                'relation' => 'AND',
                                                array(
                                                    'key' => 'ng_user_approve_status',
                                                    'value' => 'approved',
                                                    'compare' => '='
                                                ),
                                                array(
                                                    'key' => 'instructor',
                                                    'value' => get_current_user_id(),
                                                    'compare' => '='
                                                )
                                            )
                                        );
                                        if( isset( $_GET['region'] ) && !empty($_GET['region']) ){
                                                $student_args['meta_query'][] = array(
                                                    'relation' => 'OR',
                                                    array(
                                                        'key'     => 'region',
                                                        'value'   => $_GET['region'],
                                                        'compare' => '=',
                                                    )
                                                );
                                            } 
                                            if( isset( $_GET['city'] ) && !empty($_GET['city']) ){
                                                $student_args['meta_query'][] = array(
                                                    'relation' => 'OR',
                                                    array(
                                                        'key'     => 'city',
                                                        'value'   => $_GET['city'],
                                                        'compare' => 'LIKE',
                                                    )
                                                );
                                            } 
                                            if( isset( $_GET['address'] ) && !empty($_GET['address']) ){
                                                $student_args['meta_query'][] = array(
                                                    'relation' => 'OR',
                                                    array(
                                                        'key'     => 'address',
                                                        'value'   => $_GET['address'],
                                                        'compare' => 'LIKE',
                                                    )
                                                );
                                            } 
                                            if( isset( $_GET['lang'] ) && !empty($_GET['lang']) ){
                                                    $student_args['meta_query'][] = array( 
                                                        'relation' => 'OR',
                                                        array(
                                                        'key' => 'language', 
                                                        'value' => $_GET['lang'], 
                                                        'compare' => 'IN' 
                                                        )
                                                    );
                                            } 
                                            if( isset( $_GET['curriculum'] ) && !empty($_GET['curriculum']) ){
                                                    $student_args['meta_query'][] = array( 
                                                        'relation' => 'OR',
                                                        array(
                                                        'key' => 'curriculum', 
                                                        'value' => $_GET['curriculum'], 
                                                        'compare' => 'IN' 
                                                        )
                                                    );
                                            } 
                                            if( isset( $_GET['track'] ) && !empty($_GET['track']) ){
                                                $student_args['meta_query'][] = array( 
                                                    'relation' => 'OR',
                                                    array(
                                                    'key' => 'track', 
                                                    'value' => $_GET['track'], 
                                                    'compare' => 'IN' 
                                                    )
                                                );
                                        } 
                                        if( isset( $_GET['min_missed'] ) && !empty($_GET['min_missed']) ){
                                            $student_args['meta_query'][] = array(
                                                'relation' => 'OR',
                                                array(
                                                    'key'     => 'missed_last_report',
                                                    'value'   => $_GET['min_missed'],
                                                    'type' => 'NUMERIC',
                                                    'compare' => '>=',
                                                )
                                            );
                                        } 
                                        if( isset( $_GET['exempt'] )  && !empty($_GET['exempt']) ){
                                            $student_args['meta_query'][] = array(
                                                'relation' => 'OR',
                                                array(
                                                    'key' => 'exempt',
                                                    'value' => 'No',
                                                    'compare' => '=',
                                                ),
                                                array(
                                                'key' => 'exempt',
                                                    'compare' => 'NOT EXISTS'
                                                )
                                            );
                                        } 
                                        if( isset( $_GET['graduate'] )  && !empty($_GET['graduate']) ){
                                            $student_args['meta_query'][] = array(
                                                'relation' => 'OR',
                                                array(
                                                    'key' => 'graduate',
                                                    'value' => 'No',
                                                    'compare' => '=',
                                                ),
                                                array(
                                                'key' => 'graduate',
                                                    'compare' => 'NOT EXISTS'
                                                )
                                            );
                                        } 
                                        if( isset( $_GET['started_after'] ) && !empty($_GET['started_after']) ){
                                            $full_date = $_GET['started_after'];
                                            $split_date = preg_split("#/#", $full_date); 
                                            $month = $split_date[0];
                                            $year = $split_date[1];
                                            $student_args['date_query'][] = array(
                                                'relation' => 'AND',
                                                array(
                                                    'before'        => '20'.$year.'-'.$month.'-31',
                                                    'inclusive'     => true,
                                                )
                                            );
                                        }

                                        if( isset( $_GET['max_net'] ) && !empty($_GET['max_net']) ){
                                            $student_args['meta_query'][] = array(
                                                'relation' => 'OR',
                                                array(
                                                    'key'     => 'total_hours_remaining',
                                                    'value'   => $_GET['max_net'],
                                                    'type' => 'numeric',
                                                    'compare' => '>',
                                                )
                                            );
                                        } 

                                        $student_args["offset"] = $paged ? ($paged - 1) * 10 : 0;
                                        //$student_args["number"] = 10;
                                        $students = get_users($student_args); 
                                        /*total student*/
                                        $student_args['fields'] = "ID";
                                        $student_args['number'] = -1;
                                        $total_student_pagination = get_users( $student_args );   
                                    }
                                    /*end multiple filter search*/

                                        else if(isset($_GET['report']))
                                        {
                                            $reported_students = [];
                                            $first_day_of_month = date('Y-m-01');
                                            $last_day_of_month = date('Y-m-t');
                                            $reported_users  = $wpdb->get_results("SELECT * from user_reporting WHERE `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
                                
                                            foreach($reported_users as $student)
                                            {
                                                $reported_students[] = $student->user_id;
                                            }
                                
                                
                                            $students = get_users(
                                                array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'include' => $reported_students,
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        )
                                                    )
                                                )
                                            );
                                
                                        }
                                        else if(isset($_GET['summary']))
                                        {
                                           
                                            $all_reporting_users  = $wpdb->get_results("SELECT * from `user_reporting` group by `user_id`");
                                            $reported_students = [];
                                            foreach($all_reporting_users as $student){
                                                $reported_students[] = $student->user_id;
                                            }
                                
                                            $first_day_of_month = date('Y-m-01');
                                            $last_day_of_month = date('Y-m-t');
                                            $ontrack = [];
                                            $ontrack_reported  = $wpdb->get_results("SELECT * from user_reporting WHERE `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
                                
                                            foreach($ontrack_reported as $student){
                                                $ontrack[] = $student->user_id;
                                            }
                                
                                            $ontrack = array_unique($ontrack);

                                            if($_GET['summary']=="not_reported"){
                                                $students = get_users(
                                                    array(
                                                        'role' => 'student',
                                                        'number' => -1,
                                                        'exclude'  => $reported_students,
                                                        'meta_query' => array(
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            )
                                                        )
                                                    )
                                                );
                                            }
                                            else if($_GET['summary']=="trailing"){
                                                
                                                $first_day_of_month = date('Y-m-01');
                                                $last_day_of_month = date('Y-m-t');

                                                $ontrack_user = implode(",", $ontrack);
                                                $last_12_months  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id NOT IN ($ontrack_user) AND `reporting_date` > now() - INTERVAL 12 month group by user_id");
                                                $trailing = [];
                                                foreach($last_12_months as $student){
                                                    $trailing[] = $student->user_id;
                                                }

                                                $students = get_users(
                                                    array(
                                                        'role' => 'student',
                                                        'number' => -1,
                                                        'include' => $trailing,
                                                        'meta_query' => array(
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            )
                                                        )
                                                    )
                                                );
                                            }
                                            else {
                                                $students = get_users(
                                                    array(
                                                        'role' => 'student',
                                                        'number' => -1,
                                                        'include' => $ontrack,
                                                        'meta_query' => array(
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            )
                                                        )
                                                    )
                                                );
                                            }
                                
                                
                                        }
                                        else if( isset($_GET['mfilter']) && $_GET['mfilter'] =="missed" )
                                        {    
                                            $students = get_users(
                                                array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        )
                                                    )
                                                )
                                            );
                                
                                            $missed_students = [];
                                            foreach($students as $student)
                                            {
                                                $reg_date = date("Y-m-d", strtotime($student->data->user_registered));
                                                $current_date = date('Y-m-d');
                                                                            
                                                $cid = get_the_author_meta( 'curriculum', $student->data->ID ); 
                                                $uid  = $student->data->ID;
                                                if($cid==""){$cid = 1;}
                                                $first_day_of_month = date('Y-m-01');
                                                $last_day_of_month = date('Y-m-t');
                                                $month_ini = new DateTime("first day of last month");
                                                $month_end = new DateTime("last day of last month");

                                                $last_report  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
                                                if(count($last_report)>0){
                                                    $ontrack++;
                                                }
                                                else{
                                                    $last_12_months  = $wpdb->get_results("SELECT * from user_reporting WHERE user_id = '$uid' AND `reporting_date` > now() - INTERVAL 12 month");
                                                    if(count($last_12_months)==0)
                                                    {
                                                        $missed_students[] = $student->data->ID;
                                                    }
                                                }
                                            }

                                            $students = get_users(
                                                array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'include' => $missed_students,
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        )
                                                    )
                                                )
                                            );
                                            /* end */

                                        }

                                       
                                        else{

                                            // $students = get_users(
                                            //     array(
                                            //         'role' => 'student',
                                            //         'number' => -1,
                                            //         'meta_query' => array(
                                            //             array(
                                            //                 'key' => 'ng_user_approve_status',
                                            //                 'value' => 'approved',
                                            //                 'compare' => '='
                                            //             ),
                                            //             array(
                                            //                 'key' => 'instructor',
                                            //                 'value' => get_current_user_id(),
                                            //                 'compare' => '='
                                            //             )
                                            //         )
                                            //     ),
                                            // );
                                            

                                                $number = 50;

                                                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
                                                $offset = ($paged - 1) * $number;

                                                $args = array(
                                                    'role' => 'student',
                                                    'number' => -1,
                                                    'meta_query' => array(
                                                        array(
                                                            'key' => 'ng_user_approve_status',
                                                            'value' => 'approved',
                                                            'compare' => '='
                                                        ),
                                                        array(
                                                            'key' => 'instructor',
                                                            'value' => get_current_user_id(),
                                                            'compare' => '='
                                                        )
                                                    )
                                                );
    
                                                if(isset($_POST['submit'])){

                                                    $search = $_POST['search_student'];
        
                                                    $args = array(
                                                        'role' => 'student',
                                                        'number' => -1,
                                                        'search' => "*{$search}*",
                                                        'search_columns' => array(
                                                        'user_login',
                                                        'user_nicename',
                                                        'user_email',
                                                        'display_name',
                                                        ),
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key' => 'ng_user_approve_status',
                                                                'value' => 'approved',
                                                                'compare' => '='
                                                            ),
                                                            array(
                                                                'key' => 'instructor',
                                                                'value' => get_current_user_id(),
                                                                'compare' => '='
                                                            ),
                                                            
                                                           
                                                        )
                                                    );
        
                                                    if(isset($_POST['all_ndg_students']) && $_POST['all_ndg_students'] == 1){
        
                                                        $args = array(
                                                            'role' => 'student',
                                                            'number' => -1,
                                                            'search' => "*{$search}*",
                                                            'search_columns' => array(
                                                            'user_login',
                                                            'user_nicename',
                                                            'user_email',
                                                            'display_name',
                                                            ),
                                                            'meta_query' => array(
                                                                'relation' => 'AND',
                                                                array(
                                                                    'key' => 'ng_user_approve_status',
                                                                    'value' => 'approved',
                                                                    'compare' => '='
                                                                )   
                                                            )
                                                        );
        
        
                                                    //     echo "<pre>";
                                                    // var_dump($_POST);
                                                    // echo "</pre>";
                                                    }
                                                   
            
                                                }
    
                                                $total_users_query = new WP_User_Query($args);
                                                $total_users = $total_users_query->total_users;
    
                                                $args['number'] = $number;
                                                $args['offset'] = $offset;
    
                                                $wp_user_query = new WP_User_Query($args);
    
                                                $total_query = $wp_user_query->total_users;
                                                $total_pages = intval($total_users / $number) + 1;
    
                                                $students = $wp_user_query->get_results();

                                        }
                                       
                                        if($students) :
                                            $ontrack = 0;
                                            $onbehind = 0;
                                            $missed_last_three = 0;
                                            $not_reported = 0;
                                            $missed_last_year = 0;
                                            $trailing = 0;

                                            $subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects`");
                                            $total_required = (int)$subjects_total->total_hour;
                                            $total_students = count($students);
                                            $all_hrs_total = 0;
                                            $reported_students = [];
                                            $sum_subject = "SUM(";
                                            for($i=1; $i<=22; $i++){
                                                if($i<22)
                                                $sum_subject.= 'sub_'.$i.' + ';
                                                else
                                                $sum_subject.= 'sub_'.$i;
                                            }
                                            $sum_subject .= ") As hour_total";


                                            foreach($students as $student):
                                                $title = $student->display_name;
                                                $email = $student->user_email;
                                                $sid = $student->ID;
                                                $track = get_the_author_meta( 'track', $sid );
                                                $curriculum = get_the_author_meta( 'curriculum', $sid );
                                                $social_media_icon = get_the_author_meta( 'social_icon', $sid );
                                                $social_media_id = get_the_author_meta( 'sociallink', $sid );
                                                $note = get_the_author_meta( 'instructor_note', $sid );

                                                if($social_media_icon == 'whatsapp'){
                                                    $social_link = 'https://wa.me/'.$social_media_id;
                                                    $icon_url = get_template_directory_uri().'/assets/images/whatsapp.png.';
                                                }
                                                else if($social_media_icon == 'wechat'){
                                                    $social_link = 'weixin://dl/chat?'.$social_media_id;
                                                    $icon_url = get_template_directory_uri().'/assets/images/wechat.png.';
                                                }
                                                else if($social_media_icon == 'telegram'){
                                                    $social_link = 'https://tttttt.me/'.$social_media_id;
                                                    $icon_url = get_template_directory_uri().'/assets/images/telegram.png.';
                                                }
                                                else {
                                                    $social_link = '';
                                                    $icon_url = '';
                                                }
                                                
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
                                                $user_language_short = get_the_author_meta( 'language', $uid );
												/*tracking report*/
                                                $total_students = count($students);

                                                $reg_date = date("Y-m-d", strtotime($student->data->user_registered));
                                                $current_date = date('Y-m-d');

                                                $begin = new DateTime( $current_date );
                                                $end   = new DateTime( $reg_date );
                                                $months = [];
                                                $total_months = 0;
                                                $begin = $begin->modify('-1 months');
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

                                                $all_reported_entries = $wpdb->get_results("SELECT user_id, date_format(reporting_date, '%b %Y') as 'reporting_date', `user_id` from user_reporting where `user_id` = ".$uid. " group by month(reporting_date) order by reporting_date desc");

                                                $total_reporting_hour  = $wpdb->get_row("SELECT $sum_subject from user_reporting WHERE user_id = '$uid' AND course_id = '$curriculum' ");
                                                $all_hrs_total += (int)$total_reporting_hour->hour_total;
                                                $individual_total_user_reporting = (int)$total_reporting_hour->hour_total;

                                                 $missed_report = get_user_meta($uid, 'missed_last_report')[0];
												 /*end*/

                                                ?>
                                            <tr data-sname="<?=strtolower($title)?>"
                                                data-email="<?=strtolower($email)?>"
                                                data-course="<?=$practice->course_id?>"
                                                data-language="<?php echo $user_language_short; ?>" class="noshowrow">
                                                <td></td>
                                                <td style="text-align: left;">
                                                    <a class="student-link1 student-name-field"
                                                        data-effect="mfp-move-from-right" data-title="<?=$title?>"
                                                        data-email="<?=$email?>"
                                                        href="<?=site_url('/student?sid='.$sid)?>">
                                                        <?=$title?>
                                                    </a>
                                                </td>
                                                <td><?=$track?></td>
                                                <td><?=$practice->short_name?></td>
                                                <td style="text-align: right">
                                                    <?=$individual_total_user_reporting?>/<?=$total_required?></td>
                                                <td><?=$missed_report?></td>
                                                <td><?=$graduate?></td>
                                                <td><?=$exempt?></td>
                                                <td>
                                                    <?=get_the_author_meta( 'region', $sid ); ?></td>
                                                <td><?php 
                                                     if($user_language_short == 'en'){
                                                         echo ucfirst('English');
                                                     }
                                                     else if($user_language_short == 'zh-hant'){
                                                         echo ucfirst('繁體中文');
                                                     }
                                                     else if($user_language_short == 'zh-hans'){
                                                         echo ucfirst('简体中文');
                                                     }
                                                     else if($user_language_short == 'pt-br'){
                                                         echo ucfirst('Português');
                                                     }
                                                    ?></td>
                                                <td><?=$email?></td>
                                                <td><?php if($icon_url):?><a href="<?php echo $social_link;?>"><img
                                                            src="<?=$icon_url?>" alt="social-link"></a><?php endif;?>
                                                </td>
                                                <td><?php if($note): echo $note; endif;?></td>
                                                <td>
                                                    <a class="student-link1" data-effect="mfp-move-from-right"
                                                        data-title="<?=$title?>" data-email="<?=$email?>"
                                                        href="<?=site_url('/student?sid='.$sid)?>">
                                                        <?php echo __('View','ngondro_gar');?></a>
                                                </td>
                                            </tr>

                                            <?php
                                                $cmp_hrs = $total_user_reporting.'/'.$total_required;
                                                $row_data = array($title, $track, $practice->short_name, $cmp_hrs, $missed_report, $graduate, $exempt);
                                                fputcsv($cfile,$row_data);
                                            endforeach; endif;

                                            if ($total_users >= $total_query) {
                                                echo '<div id="pagination" class="clearfix um-members-pagi">';
                                                    echo '<span class="pages">Pages:</span>';
                                                    $current_page = max(1, get_query_var('paged'));
                                            
                                                    echo paginate_links(array(
                                                      'base'      => get_pagenum_link(1) . '%_%',
                                                      'format'    => 'page/%#%/',
                                                      'current'   => $current_page,
                                                      'total'     => $total_pages,
                                                      'prev_next' => true,
                                                      'show_all'  => true,
                                                      'type'      => 'plain',
                                                    ));
                                                
                                                echo '</div>';
                                            }

                                        fclose($cfile);

										if($total_required > 0){
                                        $per = ($all_hrs_total * 100 )/$total_required;
                                        }
										$trailing = $total_students - $ontrack;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php get_footer() ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script> -->
    <script>
    var btn = document.getElementById('edit-clear');
    btn.addEventListener('click', function() {
        document.location.href = '<?php echo home_url('/student-tracking/');?>';
    });
    </script>
    <script>
    jQuery(document).ready(function() {
        // jQuery('#student-table').DataTable( {
        //     dom: 'Bfrtip',
        //     scrollX: true,
        //     searching: false,
        //     fixedColumns:   {
        //     left: 3
        //     },
        //     buttons: [
        //         'csv'
        //     ]
        // } );
        var t = $('#student-table').removeAttr('width').DataTable({
            dom: 'Bfrtip',
            // scrollX: true,
            responsive: true,
            // scrollCollapse: true,
            "pageLength": 50,
            searching: false,
            // fixedColumns:   {
            // left: 2
            // },
            buttons: [],
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 2,
                    targets: -1
                },
            ],
            order: [
                [1, 'asc']
            ],
            "language": {
                "paginate": {
                    "previous": "Prev",
                    'next': 'Next'
                }
            },
            language: {
                'paginate': {
                    'previous': ajaxObj.previous,
                    'next': ajaxObj.next
                }
            }

        });
        t.on('order.dt search.dt', function() {
            let i = 1;

            t.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
        var buttons = new $.fn.dataTable.Buttons(t, {
            buttons: [{
                extend: 'csv',
                text: 'Export CSV',
                key: {
                    key: 'p',
                    altkey: true
                },
            }]
        }).container().appendTo($('#student-table_wrapper .dt-buttons'));

        $('.show-hide-checkbox').change(function(e) {
            e.preventDefault();
            var column = t.column(jQuery(this).val());
            column.visible(!column.visible());
        });

        jQuery('a.toggle-vis').on('click', function(e) {
            e.preventDefault();
            // Get the column API object
            var column = t.column(jQuery(this).attr('data-column'));
            // Toggle the visibility
            column.visible(!column.visible());
        });
    });
    </script>

    <script>
    jQuery(document).ready(function() {
        jQuery(document).on('click', '.track_search_btn', function() {
            var classname = jQuery(this).attr('data-class');
            var input_val = jQuery(classname).val().toLowerCase();
            if (input_val != "") {
                jQuery('#student-table .noshowrow').hide();
                if (classname == ".sname_input") {
                    var sname = jQuery('#student-table .noshowrow').attr('data-sname');
                    console.log(`#student-table tr[data-sname='${input_val}']`);
                    jQuery(`#student-table tr[data-sname='${input_val}']`).show();
                } else {
                    var semail = jQuery('#student-table .noshowrow').attr('data-semail');
                    jQuery(`#student-table tr[data-email='${input_val}']`).show();
                }
            } else {
                jQuery(`#student-table tr`).show();
            }
        })

    })

    // jQuery('.course_select').on('change',function(){
    //     var cval = jQuery(this).val().toLowerCase();
    //     if(cval){
    //     jQuery('#student-table .noshowrow').hide();
    //     jQuery(`#student-table tr[data-course='${cval}'`).show();
    //     } else {
    //         jQuery('#student-table .noshowrow').show(); 
    //     }

    // });
    // jQuery('.language_select').on('change',function(){
    //     var cval = jQuery(this).val().toLowerCase();
    //     if(cval){
    //         jQuery('#student-table .noshowrow').hide();
    //     jQuery(`#student-table tr[data-language='${cval}'`).show();
    //     }
    //     else {
    //         jQuery('#student-table .noshowrow').show(); 
    //     }
    // });
    jQuery('.dropdown_filter').each(function() {
        jQuery(this).on('change', function() {
            const table = document.getElementById("student-table");
            // save all tr
            const tr = table.getElementsByTagName("tr");
            var course = document.getElementById("course_select").value;
            var language = document.getElementById("language_select").value;
            for (i = 1; i < tr.length; i++) {

                var rowCourse = tr[i].getAttribute("data-course");
                var rowLanguage = tr[i].getAttribute("data-language");

                var isDiplay = true;

                if (course != 'all' && rowCourse != course) {
                    isDiplay = false;
                }
                if (language != 'all' && rowLanguage != language) {
                    isDiplay = false;
                }
                if (isDiplay) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        });
    });

    jQuery(document).ready(function() {

        setTimeout(() => {

            document.querySelector('#student-table_info').style.visibility = 'hidden'
            document.querySelector('#student-table_paginate').style.display = 'none'
        }, 1000);

    });
    </script>