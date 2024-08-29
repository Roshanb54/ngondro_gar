<?php
/**
 * Template Name: Student Profile Page
 * @desc Edit/update Student Profile Info
 * @function {get_current_user_id} Returns id of loggedin user 
 * @params {get_user_meta} [object] Return all user meta values 
 * @params {get_the_title} [Value] Return title of the page/post
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {get_users()} [object] Return users details
 * @returns {get_field()} [Value] Return acf field value base on field key
 * @returns {get_the_post_thumbnail_url()} Return the post featured image url by post ID
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */

if(!is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}

get_header('loggedin');
?>
<div id="layoutSidenav_content">
    <div class="container">

        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="">
                    <div class="box-title-wrapper">
                        <h2>Student Profile</h2>
                    </div>
                    <div class="sidebar-inner-box">
                        <div class="student-profile-table-wrapper">
                            <div class="d-flex align-items-center profile-heading">
                                <div class="me-5">
                                    <img src="https://ngondrogarodev.wpengine.com/wp-content/uploads/2022/06/220X250.png"
                                         alt="Profile Pic" class="w-100 h-100">
                                </div>
                                <div>
                                    <h3>John Doe</h3>
                                    <p>Member since : 1 month 1 week (22 May, 2022)</p>
                                </div>
                            </div>
                            <table class="table table-borderless mb-0">
                                <tbody>
                                <tr>
                                    <td rowspan="2">

                                    </td>
                                    <td style="vertical-align: bottom; padding: 0 0.5rem;"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top; padding: 0 0.5rem;"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>
                                        John David Doe
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Email :</th>
                                    <td>
                                        <div class="form-floating">
                                            johndoe123@gmail.com
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Address :</th>
                                    <td>
                                        Some town 123, Some city, Some country
                                </tr>
                                <tr>
                                    <th scope="row">Region :</th>
                                    <td>Asia
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Social media :</th>
                                    <td>
                                        <img src="<?php echo get_template_directory_uri();?>/assets/images/wechat.png" alt="">123jhonDoe
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Language:</th>
                                    <td>
                                        English
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-7">
            <div class="col-md-10 offset-md-1">
                <div class="sidebar-inner-box ">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true">Course information</button>
                            <button class="nav-link" id="nav-understanding-tab" data-bs-toggle="tab" data-bs-target="#nav-understanding" type="button" role="tab" aria-controls="nav-understanding" aria-selected="false">Understanding & Transfer</button>
                            <button class="nav-link" id="nav-reports-tab" data-bs-toggle="tab" data-bs-target="#nav-reports" type="button" role="tab" aria-controls="nav-reports" aria-selected="false">Missed reports</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                            <table class="table table-borderless mt-6 mb-6">
                                <tbody>
                                <tr>
                                    <th>Enrolled Course</th>
                                    <td>Longchen Nyingtik Ngondro (LNN)</td>
                                </tr>
                                <tr>
                                    <th>Instructor : </th>
                                    <td>
                                        <div class="d-flex">
                                            <img src="https://ngondrogarodev.wpengine.com/wp-content/uploads/2022/07/Jakob.jpeg" alt="" class="instructor-img rounded-circle">
                                            <p>
                                                Jens JakobLeschly
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Practice hours :</th>
                                    <td>1 hour / day</td>
                                </tr>
                                <tr>
                                    <th>Active Status :</th>
                                    <td>Active</td>
                                </tr>
                                <tr>
                                    <th>Graduation status:</th>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <Select class="form-control">
                                                    <option value="">Graduated</option>
                                                    <option value="">Not Graduated</option>

                                                </Select>
                                                <p class="text-muted">Note: Maggie.Chau has not completed the Ngondro hours reporting requirement</p>
                                            </div>
                                            <a href="#" class="btn btn-link-default">Save</a>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="">
                                                <input class="form-check-input" id="" type="radio" name="" id="" value="yes">
                                                <span></span>
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="">
                                                <input class="form-check-input" id="" type="radio" name="" id="" value="no" >
                                                <span></span>
                                                No
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="">
                                                <input class="form-check-input" id="" type="radio" name="" id="" value="pending" >
                                                <span></span>
                                                Pending
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="nav-understanding" role="tabpanel" aria-labelledby="nav-understanding-tab" tabindex="0">
                            <div class="mt-6 mb-6">
                                <h6>Understanding</h6>
                                <p>Learn more about the practice background and needs of the student.</p>

                                <h6>Learn more about the practice background and needs of the student.</h6>
                                <p>Students will progress through the Ngöndro one practice at a time, beginning with
                                    the 7 General Preliminary Contemplations and ending with Guru Yoga. Traditionally,
                                    there are three ways to measure accomplishment in a practice: by signs, by numbers
                                    of mantra and prayer accumulations, and by hours.
                                </p>

                                <h6>Previous buddhist practice and training experience</h6>
                                <p>
                                    Students will progress through the Ngöndro one practice at a time, beginning with
                                    the 7 General Preliminary Contemplations and ending with Guru Yoga. Traditionally,
                                    there are three ways to measure accomplishment in a practice: by signs, by
                                    numbers of mantra and prayer accumulations, and by hours.
                                </p>
                                <h6>Received teachings from Riponche ?</h6>
                                <p>
                                    Students will progress through the Ngöndro one practice at a time, beginning with
                                    the 7 General Preliminary Contemplations and ending with Guru Yoga. Traditionally,
                                    there are three ways to measure accomplishment in a practice: by signs, by numbers
                                    of mantra and prayer accumulations, and by hours.
                                </p>
                                <h6>Which practice track are you planning to join? What kind of obstacles will likely arise, and how will you handle these obstacles?</h6>
                                <p>
                                    Students will progress through the Ngöndro one practice at a time, beginning with
                                    the 7 General Preliminary Contemplations and ending with Guru Yoga. Traditionally,
                                    there are three ways to measure accomplishment in a practice: by signs, by numbers
                                    of mantra and prayer accumulations, and by hours.
                                </p>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div class="heading">
                                        <h4>Transfer information</h4>
                                        <p>Total transfer hours accumulated hours: 12 hours</p>
                                    </div>
                                    <a href="#" class="btn btn-link-default">Edit Course</a>
                                </div>
                                <table class="table table-borderless">
                                    <thead>
                                    <th>Practice Session</th>
                                    <th>Hours</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Outer Preliminaries</td>
                                        <td><input type="number" class="form-control" value="15" min="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Refuge & Bodhicitta</td>
                                        <td><input type="number" class="form-control" value="15" min="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Vajrasattva - Outer and Inner</td>
                                        <td><input type="number" class="form-control" value="15" min="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Mandala - Common and Uncommon</td>
                                        <td><input type="number" class="form-control" value="15" min="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Outer Preliminaries</td>
                                        <td><input type="number" class="form-control" value="15" min="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Guru Yoga</td>
                                        <td><input type="number" class="form-control" value="15" min="0"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-reports" role="tabpanel" aria-labelledby="nav-reports-tab" tabindex="0">
                            <div class="d-flex justify-content-between">
                                <div class="heading">
                                    <h4>Missed reports</h4>
                                    <p>This student is up-to-date with their hours reporting. Last reported: 2days ago.</p>
                                </div>
                                <a href="#" class="btn btn-link-default">Deactvate</a>
                            </div>

                            <div class="table-wrapper">
                                <table class="table table-borderless">
                                    <thead>
                                    <th>Date</th>
                                    <th>Curriculum</th>
                                    <th>Practice Sessions</th>
                                    <th>Hours</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>16/07</td>
                                        <td>LNN</td>
                                        <td>Outer Preliminaries</td>
                                        <td><input type="number" class="form-control" min="0" value="15"></td>
                                    </tr>
                                    <tr>
                                        <td>16/09</td>
                                        <td>LNN</td>
                                        <td>Outer Preliminaries</td>
                                        <td><input type="number" class="form-control" min="0" value="15"></td>
                                    </tr>
                                    <tr>
                                        <td>16/08</td>
                                        <td>LNN</td>
                                        <td>Outer Preliminaries</td>
                                        <td><input type="number" class="form-control" min="0" value="15"></td>
                                    </tr>
                                    <tr>
                                        <td>12/07</td>
                                        <td>LNN</td>
                                        <td>Outer Preliminaries</td>
                                        <td><input type="number" class="form-control" min="0" value="15"></td>
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

    <?php get_footer();?>
</div>