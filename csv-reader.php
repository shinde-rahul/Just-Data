<?php
  define('DRUPAL_ROOT', getcwd());

  require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
  drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

  $is_courses = ($_GET["is_courses"])  ? 1 : 0;
  
  $file_name = $_SERVER['DOCUMENT_ROOT'].  "/feed_data/csv/Fellowships.csv";
  
  if($is_courses) {
    $file_name = $_SERVER['DOCUMENT_ROOT'].  "/feed_data/csv/Courses and Meetings.csv";
  }

  $fp = fopen($file_name, "r") ;
  
  $specialty_mapping = array(
    6 => "Hip",
    7 => "Knee",
    9 => "Upper limb",
    10 => "Spine",
    11 => "Trauma",
    13 => "Oncology",
    14 => "Children's Orthopaedics",
    17 => "Research",
    18 => "Foot and Ankle ",
  );
  
  $course_type_mapping = array(
    1 => "Conference",
    2 => "Seminar",
    3 => "Workshop",
    4 => "Course",
    5 => "Meeting",
    6 => "Symposium",
    7 => "Other"
  );
  
  $header_count = 0;
  $header = array();
  $specialty_id = 0;

  header("Content-type:text/octect-stream");
  if($is_courses){
   header("Content-Disposition:attachment;filename=Courses_and_Meeting.csv"); 
  }
  else {
     header("Content-Disposition:attachment;filename=Fellowships.csv");
  }
  
  $next_line = "";
  while(($data = fgetcsv($fp, 10000, ",")) != FALSE) {
    if($header_count == 0) {
      $header = $data;
      $header_count++;
      
      $specialty_id = array_search("SpecialtyID", $header);
      $course_type_id = -1;
      $end_date = -1;
      if($is_courses) {
        $course_type_id = array_search("CourseTypeID", $header);
        $end_date = array_search("EndDate", $header);
      }
       
      $start_date = array_search("StartDate", $header);
      $date_submitted = array_search("DateSubmitted", $header);
      $date_approved = array_search("DateApproved", $header);
      
      
      $next_line = '"' .  implode('","',$header) . '"' . PHP_EOL;
    }
    else {
      if(array_key_exists($data[$specialty_id] , $specialty_mapping)) {
        $temp_array = array();
        foreach($data as $key => $val) {
          switch($key) {
            case $specialty_id:
              $temp_array[$key] = $specialty_mapping[$val];
              break;
            
            case $course_type_id:
              $temp_array[$key] = $course_type_mapping[$val];
              break;            
            
            case $start_date:
              $date = $data[$start_date];
              $str_date = strtotime(str_replace("/", "-", $date));
              $new_date = date('m/d/Y',$str_date);              
              $temp_array[$key] = $new_date;
              break;            
            
            case $end_date:
              $date = $data[$end_date];
              $str_date = strtotime(str_replace("/", "-", $date));
              $new_date = date('m/d/Y',$str_date);              
              $temp_array[$key] = $new_date;
              break;
            
            case $date_submitted:
              $date = $data[$date_submitted];
              $str_date = strtotime(str_replace("/", "-", $date));
              $new_date = date('m/d/Y',$str_date);              
              $temp_array[$key] = $new_date;
              break;
            
            case $date_approved:
              $date = $data[$date_submitted];
              $str_date = strtotime(str_replace("/", "-", $date));
              $new_date = date('m/d/Y',$str_date);              
              $temp_array[$key] = $new_date;
              break;
            
            default:
              $allEntities = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
              $specialEntities = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES);
              $noTags = array_diff($allEntities, $specialEntities);
  
              $temp_str = strtr($val, $noTags); 
              
              $temp_array[$key] = check_plain($temp_str);
                
              break;
          }
        }

        $next_line .= '"' .  implode('","',$temp_array) . '"' . PHP_EOL;
      }
      
    }
    
  }
  print($next_line);
  exit; 