<?php
/*
Template Name: testpage
*/
global $wpdb;




$table = 'instructor_summary';

        $instructors = get_users(
            array(
                'role' => 'instructor',
                'number' => -1,
                'field' => 'ID',
            )
        );

        
        
        foreach($instructors as $instructor_add){
           
            $check_instructor = $wpdb->get_row("SELECT instructor_id FROM $table WHERE instructor_id = '".$instructor_add->data->ID."'");
            if(!$check_instructor){
                $wpdb->insert($table, array('instructor_id' => $instructor_add->data->ID));
            }
        }

        $instructor = $wpdb->get_results("select instructor_id from $table where status ='0' ORDER BY id DESC LIMIT 1");

        if(!$instructor){
            // global $wpdb;
            $ins = $wpdb->get_results("SELECT instructor_id FROM $table");
            foreach ($ins as $instr) {
                
                $update1 = $wpdb->update($table, array('status' => 0), array('instructor_id' => $instr->instructor_id));
                // if(!$update1){
                //     var_dump($wpdb->last_error);
                // }else{
                //     var_dump($instr->instructor_id, "status updated successfully");
                // }
            }
            die;
        }
        
        $inst_id = $instructor[0]->instructor_id;
        // $inst_id = 3239;
        

   
        


            $students = get_users(
                array(
                    'role' => 'student',
                    'number' => -1,
                    'field' => 'ID',
                    'meta_query' => array(
                        array(
                            'key' => 'ng_user_approve_status',
                            'value' => 'approved',
                            'compare' => '='
                        ),
                        array(
                            'key' => 'instructor',
                            'value' => (int) $inst_id,
                            'compare' => '='
                        )
                    )
                )
            );

            

            

            $ontrack = 0;
            $not_reported = 0;
            $trailing = 0;
            $missed_report = 0;
            $all_hrs_total = 0;
            $gen_student = [];
            $lnn_student = [];
            $cnn_student = [];
            $kmn_student = [];
            $reported_students = [];
            $total_students = 0;

            $data = [];
            
            if($students){
               /*tracking report*/
               /*tracking report*/

               $total_students = count($students);

               $data['total_students'] = $total_students;
               
               
               
                  $sum_subject = "SUM(";
                  for($i=1; $i<=21; $i++){
                   if($i<21)
                   $sum_subject.= 'sub_'.$i.' + ';
                   else
                   $sum_subject.= 'sub_'.$i;
               }
               $sum_subject .= ") As hour_total";
            
               foreach($students as $student):
                   $missed_report = 0;
                 //    $title = $student->display_name;
                 //    $email = $student->user_email;
                   $sid = $student->ID;
                   $reported_students[] = $sid;
                   $track = get_the_author_meta( 'track', $sid );
                   $curriculum = get_the_author_meta( 'curriculum', $sid );
                   
                   if($curriculum =="2"){
                        $lnn_student[] = $sid; 
                   }
                   else if($curriculum =="3"){
                        $cnn_student[] = $sid; 
                   }
                   else if($curriculum =="4"){
                        $kmn_student[] = $sid; 
                   }
                   else{
                        $general_student[] = $sid;
                   }
                  
                   
                   $uid = $sid;
                   $first_day_of_month = date('Y-m-01');
                   $last_day_of_month = date('Y-m-t');
                   $user_course_id = get_the_author_meta( 'curriculum', $sid );
                   $cid = $user_course_id;
        
        
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
        
                   $last_report  = $wpdb->get_results("SELECT id from user_reporting WHERE user_id = '$uid' AND `course_id`='$cid' AND `reporting_date` BETWEEN '$first_day_of_month' AND '$last_day_of_month'");
                   if(count($last_report)>0){
                       $ontrack++;
                   }
                   else{
                       $last_12_months  = $wpdb->get_results("SELECT id from user_reporting WHERE user_id = '$uid' AND `reporting_date` > now() - INTERVAL 12 month");
                       if(count($last_12_months)>0){
                           $trailing++;
                       }
                       else{
                           $missed_report++;
                       }
                   }
        

        
                   $total_reporting_hour  = $wpdb->get_row("SELECT $sum_subject from user_reporting WHERE user_id = '$uid' ");
                   $all_hrs_total += (int)$total_reporting_hour->hour_total;
                   $individual_total_user_reporting = (int)$total_reporting_hour->hour_total;

                endforeach; 
                
                
                
                // fclose($cfile);
                if($reported_students != null){
                    $rids = implode(',', $reported_students);
                    $all_reporting_users  = $wpdb->get_results("SELECT id from `user_reporting` where user_id in ($rids) group by `user_id`");
                    $not_reported =  $total_students - count($all_reporting_users);
                    
                $data['ontrack'] = $ontrack;
                $data['trailing'] = $trailing;
                $data['missed_report'] = $missed_report;
                $data['not_reported'] = $not_reported;
                $data['all_hrs_total'] = $all_hrs_total;

                }
                
            
        /*end*/


        $graduated = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                    array(
                        'key'     => "graduate",
                        'value'   => 'Yes',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => 'approved',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'instructor',
                        'value' => $inst_id,
                        'compare' => '='
                    ),
            ),
        ));
        $not_graduate = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                    array(
                        'key'     => "graduate",
                        'value'   => 'No',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => 'approved',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'instructor',
                        'value' => $inst_id,
                        'compare' => '='
                    ),
            ),
        ));
        $graduated = (int) count($graduated);
        
        if($total_students){
            $total_graduate = (float)number_format( ($graduated * 100 )/$total_students,0);
            
        
        }
        else{
            $total_graduate = 0;
        }
        
        $not_graduate = count($not_graduate);

        $data['total_graduate'] = $graduated;
        $data['not_graduate'] = $not_graduate;
                


        $exempt = get_users(array(
            'role' => 'student',
            'number' => -1,
            'filed' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                    array(
                        'key'     => "exempt",
                        'value'   => 'Yes',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => 'approved',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'instructor',
                        'value' => $inst_id,
                        'compare' => '='
                    ),
            ),
        ));
        $not_exempt = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                    array(
                        'key'     => "exempt",
                        'value'   => 'No',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'ng_user_approve_status',
                        'value' => 'approved',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'instructor',
                        'value' => $inst_id,
                        'compare' => '='
                    ),
            ),
        ));
        $exempt = (int) count($exempt);
        $not_exempt = (int) count($not_exempt);

        $data['exempt'] = $exempt;
        $data['not_exempt'] = $not_exempt;
        

        $lnn = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "curriculum",
                    'value'   => '2',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
               
            ),
        ));

        $cnn = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "curriculum",
                    'value'   => '3',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
               
            ),
        ));

        $kmn = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "curriculum",
                    'value'   => '4',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
               
            ),
        ));

        $alt = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "curriculum",
                    'value'   => '1',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
               
            ),
        ));

        // $student_count = count($all_students);
        $lnn_count = count($lnn);
        $kmn_count = count($kmn);
        $cnn_count = count($cnn);
        $alt_count = count($alt);

        // echo "<pre>";
        // var_dump($lnn_count);
        // die;

        $data['lnn_count'] = $lnn_count;
        $data['kmn_count'] = $kmn_count;
        $data['cnn_count'] = $cnn_count;
        $data['alt_count'] = $alt_count;
        


        $eng = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "language",
                    'value'   => 'en',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
            
            ),
        ));

        $hant = get_users(array(
            'role' => 'student',
            'field' => 'ID',
            'number' => -1,
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "language",
                    'value'   => 'zh-hant',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
            
            ),
        ));

        $hans = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "language",
                    'value'   => 'zh-hans',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
            
            ),
        ));

        $ptbr = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "language",
                    'value'   => 'pt-br',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
            
            ),
        ));
        $es = get_users(array(
            'role' => 'student',
            'number' => -1,
            'field' => 'ID',
            'meta_query'  => array(
                'relation' => 'AND',
                array(
                    'key'     => "language",
                    'value'   => 'es',
                    'compare' => '='
                ),
                array(
                    'key' => 'ng_user_approve_status',
                    'value' => 'approved',
                    'compare' => '='
                ),
                array(
                    'key' => 'instructor',
                    'value' => $inst_id,
                    'compare' => '='
                ),
            
            ),
        ));

        // $student_count = count($all_students);
        $eng_count = count($eng);
        $hant_count = count($hant);
        $hans_count = count($hans);
        $ptbr_count = count($ptbr);
        $es_count = count($es);


        $data['eng_count'] = $eng_count;
        $data['hant_count'] = $hant_count;
        $data['hans_count'] = $hans_count;
        $data['ptbr_count'] = $ptbr_count;
        $data['es_count'] = $es_count;
        


       

        
        
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

        $general_subject_data = get_data(1, $gen_student);
        $lnn_subject_data = get_data(2, $lnn_student);
        $cnn_subject_data = get_data(3, $cnn_student);
        $kmn_subject_data = get_data(4, $kmn_student);
                        
        $data['lnn_subject_data'] = json_encode($lnn_subject_data);
        $data['cnn_subject_data'] = json_encode($cnn_subject_data);
        $data['kmn_subject_data'] = json_encode($kmn_subject_data);

        $data['status'] = 1;


        $insert = $wpdb->update($table,$data,array('instructor_id' => $inst_id));
        if(!$insert){
            $wpdb->last_error;
        }else{
            var_dump($inst_id, 'data of instructor updated');
        }

    }else{
        $data['status'] = 1;
        $insert = $wpdb->update($table,$data,array('instructor_id' => $inst_id));
        if(!$insert){
            var__dump($wpdb->last_error);
        }else{
            var_dump($inst_id,'No students present, Only id id updated');
        }
    }
?>