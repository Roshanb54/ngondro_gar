<style>
.nav-link {
	padding: 0.5rem 0.5rem!important;
}
</style>

<?php 
/**
 * Template Name: Student Summary Report Page
 * @desc Student Summary Report Page
 * @function {get_current_user_id} Returns id of loggedin user 
 * @returns {get_the_author_meta()} Return meta value of the given user based on meta key
 * @returns {get_users()} [object] Return users details
 * @returns {get_field()} [Value] Return acf field value base on field key
 */
session_start();  
get_header('loggedin');


global $wpdb;
$current_user_id = get_current_user_id();	

$table = 'instructor_summary';
$data = $wpdb->get_row("SELECT * FROM $table WHERE instructor_id = '$current_user_id'");


    $report_text = 'reports/all_student_report_'.$current_user_id.'.csv';

    global $wpdb;








        $ontrack = $data->ontrack;  //d
        $not_reported = $data->not_reported; //d
    
        $trailing = $data->trailing; //d
        $missed_report = $data->missed_report;  //d
        $all_hrs_total = $data->all_hrs_total;  //d
        $lnn_count = $data->lnn_count;          //d
        $cnn_count = $data->cnn_count;          //d
        $kmn_count = $data->kmn_count;          //d
        $alt_count = $data->alt_count;          //d
        $total_graduate = $data->total_graduate; //d
        $not_graduate = $data->not_graduate;    //d
        $total_students = $data->total_students;   //d
        $exempt = $data->exempt;                 //d
        $not_exempt = $data->not_exempt;         //d
        $eng_count = $data->eng_count;           //d
        $hant_count = $data->hant_count;         //d
        $hans_count = $data->hans_count;         //d
        $ptbr_count = $data->ptbr_count;         //d
        $es_count = $data->es_count;             //d
        $lnn_subject_data = json_decode($data->lnn_subject_data);   //d
        $cnn_subject_data = json_decode($data->cnn_subject_data);   //d
        $kmn_subject_data = json_decode($data->kmn_subject_data);   //d


       


   
/*end*/

?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<div id="layoutSidenav_content">
    <div class="container px-sm-1 px-10">
        <div class="row">
            <!-- Display Student summary report with graphs -->
            <div class="col-md-12 pt-6">
                <h2 class="fw-bold mt-3"><?php echo __('Students summary','ngondro_gar');?></h2>
                <p><?php echo __('This page has list of all the enrolled students. Total students :','ngondro_gar');?> <?=$total_students;?>  </p>
                
                <div class="row ">
                    <div class="col-md-6">
                        <div class="sidebar-inner-box" style="height:500px;">
                            <div class="student-summary-filter-bar mb-2">
                                <!--<a href="#">Reported</a>
                                <a href="#">Missed</a>
                                <a href="#">Graduated</a>-->
                                <nav class="mb-10">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-reported-tab" data-bs-toggle="tab" data-bs-target="#nav-reported" type="button" role="tab" aria-controls="nav-reported" aria-selected="true">
                                        <?php echo __('Reported','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-missed-tab" data-bs-toggle="tab" data-bs-target="#nav-missed" type="button" role="tab" aria-controls="nav-missed" aria-selected="false">
                                        <?php echo __('Missed','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-graduated-tab" data-bs-toggle="tab" data-bs-target="#nav-graduated" type="button" role="tab" aria-controls="nav-graduated" aria-selected="false">
                                        <?php echo __('Graduated','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-exempt-tab" data-bs-toggle="tab" data-bs-target="#nav-exempt" type="button" role="tab" aria-controls="nav-exempt" aria-selected="false">
                                        <?php echo __('Exempt','ngondro_gar');?>
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content mt-4" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-reported" role="tabpanel" aria-labelledby="nav-reported-tab" tabindex="0">
                                        <div class="student-summary-bar-chart d-flex justify-content-around">
                                            <?php 
                                                //$sontrack = number_format( ($ontrack * 100 )/$total_students,0);
                                                //$strailing = number_format(($trailing * 100 )/$total_students,0);
                                                //$not_reported1 = number_format(($not_reported * 100 )/$total_students,0);
                                            ?>
                                            
                                            <div class="chart_section" style="height:300px;">
                                                <canvas id="summary_reported"></canvas>
                                                <div class="overall text-left" style="text-align:left;">
                                                    <p style="font-size:14px;"> <strong><?php echo __('Tracking:','ngondro_gar');?> </strong><?=$ontrack>0 ? $ontrack : ''?> students are on track while <?=$trailing ? $trailing : '' ?> students are behind in reporting hours.</p>
                                                </div>
                                            </div>
                                            
                                            <script>
                                               
                                                const bar_reported_labels =  [
                                                    'On Track',
                                                    'Trailing'
                                                ];
                                                const bar_reported_data = {
                                                labels: bar_reported_labels,
                                                datasets: [{
                                                        label: "Reported Summary",
                                                        data: [<?=$ontrack?>, <?=$trailing?>],
                                                        backgroundColor: [
                                                        '#b13b55',
                                                        '#651a55e0',
                                                        ],
                                                        borderColor: [
                                                        '#BD5D72',
                                                        '#651A55',
                                                        ],
                                                        borderWidth: 1
                                                    }
                                                ]
                                                };
                                                const bar_reported_config = {
                                                    type: 'bar',
                                                    data: bar_reported_data,
                                                    options: {
                                                        maintainAspectRatio: false,
                                                        responsive: true,
                                                        layout: {
                                                            padding: 10
                                                        },
                                                        legend: {
                                                            display: false
                                                        },
                                                        title: {
                                                            display: true,
                                                            text: 'Reported Summary'
                                                        },
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                                //display:false
                                                            }
                                                        },
                                                        plugins: {
                                                            legend: {
                                                                display: true,
                                                                position:'bottom'
                                                            }
                                                        }
                                                    },
                                                };
                                            const bar_summary_Chart = new Chart(
                                                document.getElementById('summary_reported'),
                                                bar_reported_config
                                            );

                                            var summary_chart_ele = document.getElementById('summary_reported');
                                            
                                            summary_chart_ele.onclick = function(e) {
                                                var slice = bar_summary_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'On Track':
                                                        window.open('student-tracking/?report=student');
                                                        break;
                                                    case 'Trailing':
                                                        window.open('student-tracking/?summary=trailing');
                                                        break;
                                                }
                                            }

                                            </script>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-missed" role="tabpanel" aria-labelledby="nav-missed-tab" tabindex="0">
                                        <div class="student-summary-bar-chart mt-4 d-flex justify-content-around">
                                            <div class="chart_section" style="height:400px;">
                                                <canvas id="summary_missed" height ="300px"></canvas>
                                            </div>
                                            <script>
                                                const bar_missed_labels =  [
                                                    'Missed',
                                                    'Not Reported',
                                                ];
                                                const bar_missed_data = {
                                                labels: bar_missed_labels,
                                                datasets: [{
                                                    label: 'Missed Report',
                                                    data: [<?=$missed_report?>, <?=$not_reported?>],
                                                    backgroundColor: [
                                                        '#cda86d',
                                                        '#b13b55',
                                                    ],
                                                    borderColor: [
                                                        '#E6C99A',
                                                        '#BD5D72',
                                                    ],
                                                    borderWidth: 1
                                                }]
                                                };
                                                const bar_missed_config = {
                                                    type: 'bar',
                                                    data: bar_missed_data,
                                                    options: {
                                                        maintainAspectRatio: false,
                                                        responsive: false,
                                                        layout: {
                                                            padding: 10
                                                        },
                                                        legend: {
                                                            display: false
                                                        },
                                                        title: {
                                                            display: true,
                                                            text: 'Missed Report'
                                                        },
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                            }
                                                        },
                                                        plugins: {
                                                            legend: {
                                                                display: true,
                                                                position:'bottom'
                                                            }
                                                        }
                                                    },
                                                };

                                                const bar_missed_Chart = new Chart(
                                                    document.getElementById('summary_missed'),
                                                    bar_missed_config
                                                );

                                            var missed_chart_ele = document.getElementById('summary_missed');
                                            missed_chart_ele.onclick = function(e) {
                                                var slice = bar_missed_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Missed':
                                                        window.open('student-tracking/?mfilter=missed');
                                                        break;
                                                    case 'Not Reported':
                                                        window.open('student-tracking/?summary=not_reported');
                                                        break;
                                                }
                                            }

                                            </script> 

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-graduated" role="tabpanel" aria-labelledby="nav-graduated-tab" tabindex="0">
                                        <div class="student-summary-bar-chart d-flex justify-content-around mt-4">
                                            <?php 
                                           
                                                ?>
                                                
                                                <div class="chart_section" style="height:400px;">
                                                    <canvas id="summary_graduated" height ="300px"></canvas>
                                                </div>
                                                <script>
                                                    const bar_graduated_labels =  [
                                                        'Yes',
                                                        'No',
                                                    ];
                                                    const bar_graduated_data = {
                                                        labels: bar_graduated_labels,
                                                        datasets: [{
                                                            label: ['Graduated Summary'],
                                                            data: [<?=$total_graduate?>, <?=$not_graduate?>],
                                                            backgroundColor: [
                                                            '#b13b55',
                                                            '#651a55e0',
                                                            ],
                                                            borderColor: [
                                                            '#BD5D72',
                                                            '#651A55',
                                                            ],
                                                            borderWidth: 1
                                                        }
                                                    ]
                                                    };
                                                    const bar_graduated_config = {
                                                        type: 'bar',
                                                        data: bar_graduated_data,
                                                        options: {
                                                            maintainAspectRatio: false,
                                                            responsive: false,
                                                            layout: {
                                                                padding: 10
                                                            },
                                                            legend: {
                                                                display: false
                                                            },
                                                            title: {
                                                                display: true,
                                                                text: 'Graduated Summary'
                                                            },
                                                            scales: {
                                                                y: {
                                                                    beginAtZero: true,
                                                                    //display:false
                                                                }
                                                            },
                                                            plugins: {
                                                                legend: {
                                                                    display: true,
                                                                    position:'bottom'
                                                                }
                                                            }
                                                        },
                                                    };

                                                const bar_graduated_Chart = new Chart(
                                                    document.getElementById('summary_graduated'),
                                                    bar_graduated_config
                                                );

                                            var graduate_chart_ele = document.getElementById('summary_graduated');
                                            
                                            graduate_chart_ele.onclick = function(e) {
                                                var slice = bar_graduated_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                console.log(label);
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Yes':
                                                        window.open('student-tracking/?filter=graduate&val=Yes');
                                                        break;
                                                    case 'No':
                                                        window.open('student-tracking/?filter=graduate&val=No');
                                                        break;
                                                }
                                            }
                                            </script>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-exempt" role="tabpanel" aria-labelledby="nav-exempt-tab" tabindex="0">
                                        <div class="student-summary-bar-chart d-flex justify-content-around mt-4">
                                            <?php
                                           
                                                ?>
                                                
                                                <div class="chart_section" style="height:400px;">
                                                    <canvas id="summary_exempt" height ="300px"></canvas>
                                                </div>
                                                <script>
                                                    const bar_exempt_labels =  [
                                                        'Yes',
                                                        'No',
                                                    ];
                                                    const bar_exempt_data = {
                                                    labels: bar_exempt_labels,
                                                    datasets: [{
                                                        label: ['Exempt'],
                                                        data: [<?=$exempt?>, <?=$not_exempt?>],
                                                        backgroundColor: [
                                                        '#b13b55',
                                                        '#651a55e0',
                                                        ],
                                                        borderColor: [
                                                        '#BD5D72',
                                                        '#651A55',
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                                    };
                                                    const bar_exempt_config = {
                                                        type: 'bar',
                                                        data: bar_exempt_data,
                                                        options: {
                                                            maintainAspectRatio: false,
                                                            responsive: false,
                                                            layout: {
                                                                padding: 10
                                                            },
                                                            legend: {
                                                                display: false
                                                            },
                                                            title: {
                                                                display: true,
                                                                text: 'Exempt'
                                                            },
                                                            scales: {
                                                                y: {
                                                                    beginAtZero: true,
                                                                    //display:false
                                                                }
                                                            },
                                                            plugins: {
                                                                legend: {
                                                                    display: true,
                                                                    position:'bottom'
                                                                }
                                                            }
                                                        },
                                                    };

                                                const bar_exempt_Chart = new Chart(
                                                    document.getElementById('summary_exempt'),
                                                    bar_exempt_config
                                                );

                                            var exempt_chart_ele = document.getElementById('summary_exempt');
                                            
                                            exempt_chart_ele.onclick = function(e) {
                                                var slice = bar_exempt_Chart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                console.log(label);
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Yes':
                                                        window.open('student-tracking/?filter=exempt&val=Yes');
                                                        break;
                                                    case 'No':
                                                        window.open('student-tracking/?filter=exempt&val=No');
                                                        break;
                                                }
                                            }
                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 mtop-sm-5">
                        <div class="sidebar-inner-box" style="height:500px;">
                            <div class="student-summary-filter-bar mb-2">
                                <!--<a href="#">Overall</a>
                                <a href="#">By Curriculum </a>
                                <a href="#">By Language</a>-->
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-overall-tab" data-bs-toggle="tab" data-bs-target="#nav-overall" type="button" role="tab" aria-controls="nav-overall" aria-selected="true">
                                        <?php echo __('Overall','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-curriculum-tab" data-bs-toggle="tab" data-bs-target="#nav-curriculum" type="button" role="tab" aria-controls="nav-curriculum" aria-selected="false">
                                        <?php echo __('Curriculum','ngondro_gar');?>
                                        </button>
                                        <button class="nav-link" id="nav-language-tab" data-bs-toggle="tab" data-bs-target="#nav-language" type="button" role="tab" aria-controls="nav-language" aria-selected="false">
                                        <?php echo __('Language','ngondro_gar');?>
                                        </button>
                                    </div>

                                <div class="tab-content mt-4" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-overall" role="tabpanel" aria-labelledby="nav-overall-tab" tabindex="0">
                                        <div class="student-summary-doughnut-chart text-center">
                                                <div class="chart_section" style="height:300px;width:auto;">
                                                        <canvas id="overall_chart"></canvas>
                                                </div>
                                                <div class="overall text-left" style="text-align:left;">
                                                    <p> <strong> <?php echo __('Overall:','ngondro_gar');?> </strong> <?php echo __('Out of','ngondro_gar');?> <?=$total_students?> <?php echo __('students','ngondro_gar');?>,  <?=$ontrack?> <?php echo __('have reported hours; they accumulated','ngondro_gar');?> <?=number_format($all_hrs_total)?> <?php echo __('hours for practice.','ngondro_gar');?></p>
                                                </div>
                                        </div>
                                        <script>
                                            const overall_data = {
                                                labels: [
                                                    'Total Students',
                                                    'Reported',
                                                ],
                                                datasets: [{
                                                    //label: 'Languages',
                                                    data: [<?=$total_students?>, <?=$ontrack?>],
                                                    backgroundColor: [
                                                    '#BD5D72',
                                                    '#CFB58B',
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            };
                                            const overall_config = {
                                                type: 'pie',
                                                data: overall_data,
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position:'bottom'
                                                        }
                                                    }
                                                }
                                            };
                                            
                                            const overall_myChart = new Chart(
                                                document.getElementById('overall_chart'),
                                                overall_config
                                            );
                                            var overall_chart_ele = document.getElementById('overall_chart');
                                            
                                            overall_chart_ele.onclick = function(e) {
                                                var slice = overall_myChart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'Total Students':
                                                        window.open('student-tracking/');
                                                        break;
                                                    case 'Reported':
                                                        window.open('student-tracking/?report=student');
                                                        break;
                                                }
                                            }
                                        </script>
                                    </div>
                                    <div class="tab-pane fade" id="nav-curriculum" role="tabpanel" aria-labelledby="nav-curriculum-tab" tabindex="0">
                                        <div class="student-summary-doughnut-chart text-center mt-4">
                                            <?php
                                               
                                            ?>
                                                <div class="chart_section" style="height:300px;">
                                                    <canvas id="curriculum_chart"></canvas>
                                                </div>
                                        </div>
                                        <script>
                                            const curr_data = {
                                                labels: [
                                                    'LNN',
                                                    'CNN',
                                                    'KMN',
                                                    'ALT'
                                                ],
                                                datasets: [{
                                                    //label: 'Curriculum',
                                                    data: [<?=$lnn_count?>, <?=$cnn_count?>, <?=$kmn_count?>, <?=$alt_count?>],
                                                    backgroundColor: [
                                                    '#BD5D72',
                                                    '#651A55',
                                                    '#e1b672',
                                                    '#2271b1'
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            };
                                            const curr_config = {
                                                type: 'pie',
                                                data: curr_data,
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            display: true,
                                                            position:'bottom'
                                                        }
                                                    }
                                                }
                                            };
                                            const curr_myChart = new Chart(
                                                document.getElementById('curriculum_chart'),
                                                curr_config
                                            );

                                            var curr_chart = document.getElementById('curriculum_chart');
                                            
                                            curr_chart.onclick = function(e) {
                                                var slice = curr_myChart.getElementAtEvent(e);
                                                if (!slice.length) return; // return if not clicked on slice
                                                var label = slice[0]._model.label;
                                                switch (label) {
                                                    // add case for each label/slice
                                                    case 'LNN':
                                                        window.open('student-tracking/?filter=curriculum&val=2');
                                                        break;
                                                    case 'CNN':
                                                        window.open('student-tracking/?filter=curriculum&val=3');
                                                        break;
                                                    case 'KMN':
                                                        window.open('student-tracking/?filter=curriculum&val=4');
                                                        break;
                                                    case 'ALT':
                                                        window.open('student-tracking/?filter=curriculum&val=1');
                                                        break;
                                                }
                                            }
                                        </script>
                                    </div>

                                    <div class="tab-pane fade" id="nav-language" role="tabpanel" aria-labelledby="nav-language-tab" tabindex="0">
                                        <div class="student-summary-doughnut-chart text-center mt-4">
                                            <?php    
                                             
                                            ?>
                                                <div class="chart_section" style="height:300px;">
                                                    <canvas id="language_chart"></canvas>
                                                </div>
                                                <script>
                                                    const lang_data = {
                                                        labels: [
                                                        'EN',
                                                        '繁體',
                                                        '简体',
                                                        'PT',
                                                        'ES'
                                                    ],
                                                        datasets: [{
                                                            //label: 'Languages',
                                                            data: [<?=$eng_count?>, <?=$hant_count?>, <?=$hans_count?>, <?=$ptbr_count?>,<?=$es_count?>],
                                                            backgroundColor: [
                                                            '#BD5D72',
                                                            '#651A55',
                                                            '#e1b672',
                                                            '#2271b1',
                                                            '#EA6618'
                                                            ],
                                                            hoverOffset: 4
                                                        }]
                                                    };
                                                    const lang_config = {
                                                        type: 'pie',
                                                        data: lang_data,
                                                        options: {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            plugins: {
                                                                legend: {
                                                                    display: true,
                                                                    position:'bottom'
                                                                }
                                                            }
                                                        }
                                                    };
                                                    const lang_myChart = new Chart(
                                                        document.getElementById('language_chart'),
                                                        lang_config
                                                    );

                                                    var lang_chart = document.getElementById('language_chart');
                                                    
                                                    lang_chart.onclick = function(e) {
                                                        var slice = lang_myChart.getElementAtEvent(e);
                                                        if (!slice.length) return; // return if not clicked on slice
                                                        var label = slice[0]._model.label;
                                                        switch (label) {
                                                            // add case for each label/slice
                                                            case 'EN':
                                                                window.open('student-tracking/?filter=language&val=en');
                                                                break;
                                                            case '繁體':
                                                                window.open('student-tracking/?filter=language&val=zh-hant');
                                                                break;
                                                            case '简体':
                                                                window.open('student-tracking/?filter=language&val=zh-hans');
                                                                break;
                                                            case 'PT':
                                                                window.open('student-tracking/?filter=language&val=pt-br');
                                                                break;
                                                            case 'ES':
                                                                window.open('student-tracking/?filter=language&val=es');
                                                                break;
                                                        }
                                                    }

                                                </script>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>

                <?php
                    /*tracking report*/
                
                    
                    function get_data($cid, $cstudent){
                        global $wpdb;
                        if($cstudent != null){
                        $ins_std = implode(',',$cstudent);
                        $subjects = $wpdb->get_results("SELECT * from `reporting_subjects` where course_id = ".$cid);
                        $subjects_total = $wpdb->get_row("SELECT sum(total) as total_hour from `reporting_subjects` where course_id = ".$cid);
                        $cols = "";
                        foreach($subjects as $subject){
                            $cols .= "SUM(".$subject->slug.") as ".$subject->slug." ,"; 
                        }

                        $user_reports  = $wpdb->get_row("SELECT $cols user_id from `user_reporting` WHERE user_id IN ($ins_std) AND `course_id`=".$cid, ARRAY_A);
                        $total_user_reporting = 0;
                        $subject_with_total = [];
                        foreach($subjects as $subject){
                            $total_user_reporting += (int)$user_reports[$subject->slug];
                            $subject_with_total[$subject->title] = (int)$user_reports[$subject->slug];
                        }
                        
                        $total_required = (int) $subjects_total->total_hour;
                        $subject_with_total['total'] = $total_user_reporting;
                        //$subject_with_total['total_reporting'] = $total_user_reporting;
                        return $subject_with_total;
                    }
                    }

                ?>

                    <?php if($lnn_subject_data != '' && $cnn_subject_data != '' && $kmn_subject_data != '' ){ ?>
                <div class="curriculum-row mt-3">
                    <div class="col-md-12">
                        <div class="sidebar-inner-box text-left mb-10">
                            <h6 class="fw-bold"><?php echo __('Count of students in each curriculum and section','ngondro_gar');?></h6>
                            <nav>
                                <div class="nav nav-tabs" id="nav-count" role="tablist">
                                    <button class="nav-link active" id="nav-lnn-tab" data-bs-toggle="tab" data-bs-target="#nav-lnn" type="button" role="tab" aria-controls="nav-lnn" aria-selected="true">
                                        LNN
                                    </button>
                                    <button class="nav-link" id="nav-cnn-tab" data-bs-toggle="tab" data-bs-target="#nav-cnn" type="button" role="tab" aria-controls="nav-cnn" aria-selected="false">
                                        CNN
                                    </button>
                                    <button class="nav-link" id="nav-kmn-tab" data-bs-toggle="tab" data-bs-target="#nav-kmn" type="button" role="tab" aria-controls="nav-kmn" aria-selected="false">
                                        KMN
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active py-5" id="nav-lnn" role="tabpanel" aria-labelledby="nav-lnn-tab" tabindex="0">
                                    <div class="custom-table-responsive students-list">
                                        <!-- LNN -->
                                        <table class="table table-borderless summary_report_table">
                                            <thead>
                                                <th><?php echo __('Practice','ngondro_gar');?></th>
                                                <?php foreach($lnn_subject_data as $key => $sub):?>
                                                    <th><?=$key?></th>
                                                <?php endforeach;?>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>LNN</td>
                                                    <?php foreach($lnn_subject_data as $key => $sub):?>
                                                        <td><?=$sub;?></td>
                                                    <?php endforeach;?>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- LNN -->
                                    </div>
                                </div>
                                <div class="tab-pane fade py-5" id="nav-cnn" role="tabpanel" aria-labelledby="nav-cnn-tab" tabindex="0">
                                    <div class="custom-table-responsive students-list">
                                        <table class="table table-borderless summary_report_table">
                                            <thead>
                                                <th><?php echo __('Practice','ngondro_gar');?></th>
                                                <?php foreach($cnn_subject_data as $key => $sub):?>
                                                    <th><?=$key?></th>
                                                <?php endforeach;?>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>CNN</td>
                                                    <?php foreach($cnn_subject_data as $key => $sub):?>
                                                        <td><?=$sub?></td>
                                                    <?php endforeach;?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade py-5" id="nav-kmn" role="tabpanel" aria-labelledby="nav-kmn-tab" tabindex="0">
                                    <div class="custom-table-responsive students-list">
                                        <table class="table table-borderless summary_report_table">
                                            <thead>
                                                <th><?php echo __('Practice','ngondro_gar');?></th>
                                                <?php foreach($kmn_subject_data as $key => $sub):?>
                                                    <th><?=$key?></th>
                                                <?php endforeach;?>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>KMN</td>
                                                    <?php foreach($kmn_subject_data as $key => $sub):?>
                                                        <td><?=$sub?></td>
                                                    <?php endforeach;?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php } ?>

               
            </div>
        </div>
    </div>
</div>

<?php get_footer() ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

<script>
    jQuery(document).ready( function () {
        jQuery('.summary_report_table').DataTable( {
            dom: 'Bfrtip',
            responsive: true,
            language: {
                'paginate': {
                'previous': ajaxObj.previous,
                'next': ajaxObj.next
                }
            }
        } );

    } );
    jQuery('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        jQuery('.summary_report_table').DataTable( {
            dom: 'Bfrtip',
            bDestroy: true,
            responsive: true,
            language: {
                'paginate': {
                'previous': ajaxObj.previous,
                'next': ajaxObj.next
                }
            }
        } );
    });
</script>
