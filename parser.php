<?php
  
  // include the xpath file
  require_once("xpath.php");
  
  // read the xml source as string
  $str = file_get_contents("imoracle.xml");
  
  // load the string as xml object
  $xml = simplexml_load_string($str);
  
  // initialize the return array
  $result = array();
  
  // parse the xml nodes
  foreach($user_status as $key => $xpath) {
    $values = $xml->xpath("{$xpath}");
    foreach($values as $value) {
      $result[$key][] = (string)$value;
    }
  }
  
  // print the return array
  print_r($result);
  
?>
