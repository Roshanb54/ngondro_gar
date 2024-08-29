<?php 
/**
 * Template Name: Student Reporting Page
 * @desc Student monthly hour reporting
 * @returns {is_user_logged_in()} Return true of false based on user loggedin info
 */
if(!is_user_logged_in()) {
    wp_safe_redirect( home_url() );
    exit();
}
get_header('loggedin');

?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

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
                                <div class="profile-image me-5">
                                </div>
                            </div>
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td rowspan="2">

                                        </td>
                                        <td style="vertical-align: bottom; padding: 0 0.5rem;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php get_footer();?>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>

jQuery(document).ready( function () {
    jQuery('#missed_report_student').DataTable( {
        dom: 'Bfrtip',
        searching: false,
        buttons: [
            'csv'
        ]
    } );

} );

     
</script>