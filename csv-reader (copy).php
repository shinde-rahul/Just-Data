<?php
  define('DRUPAL_ROOT', getcwd());

  require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
  drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
  
  $fp = fopen($_SERVER['DOCUMENT_ROOT'].  "/csvs/Courses and Meetings 13 Dec 2012.csv", "r") ;
  
  
  $specialty_mapping = array(
//    1 => "Editorials",
//    2 => "Review Article",
//    3 => "Aspects of Current Management",
//    4 => "Annotation",
//    5 => "Operative technique",
    6 => "Hip",
    7 => "Knee",
//    8 => "Lower limb",
    9 => "Upper limb",
    10 => "Spine",
    11 => "Trauma",
//    12 => "Arthroplasty",
    13 => "Oncology",
    14 => "Children's Orthopaedics",
//    15 => "General Orthopaedics",
//    16 => "Case Reports",
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
  
  //$specialty_mapping  = array_flip($specialty_mapping);
//  krumo($specialty_mapping);
  $header_count = 0;
  $header = array();
  $specialty_id = 0;
  
//  header("Content-type:text/octect-stream");
//  header("Content-Disposition:attachment;filename=data.csv");
  $next_line = "";
  while(($data = fgetcsv($fp, 10000, ",")) != FALSE) {
    if($header_count == 0) {
      $header = $data;
      $header_count++;
      krumo()
      $specialty_id = array_search("SpecialtyID", $header);
      $course_type_id = array_search("CourseTypeID", $header); 
      $next_line = '"' .  implode('","',$header) . '"' . PHP_EOL;
    }
    else {
      if(array_key_exists($data[$specialty_id] , $specialty_mapping)) {
        $temp_array = array();
        
        foreach($data as $key => $val) {
          if($specialty_id == $key) {
            $temp_array[$key] = $specialty_mapping[$val];
          }
          elseif($course_type_id == $key) {
            $temp_array[$key] = $course_type_mapping[$val];
          }
          else {
            $allEntities = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
            $specialEntities = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES);
            $noTags = array_diff($allEntities, $specialEntities);

            $temp_str = strtr($val, $noTags); 
            $temp_array[$key] = $temp_str;
            
          }
        }
        $next_line .= '"' .  implode('","',$temp_array) . '"' . PHP_EOL;
      }
      
    }
    
  }
  print($next_line);
  exit; 