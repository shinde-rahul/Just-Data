<?php
  define('DRUPAL_ROOT', getcwd());

  require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
  drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
//  
//  //$info = _field_info_collate_fields();
//  $info = field_info_instances(NULL, "courses_and_meetings");
//  krumo($info);
//  
//  
//  exit;s
  
  $sql = "select nid,title, type from node where type = 'fellowship'";
  
  $record_set = db_query($sql);
  
  //krumo(count($record_set));
  
  foreach($record_set as $n) {
    //node_delete($n->nid);
//    //krumo(node_load($n->nid));
//    krumo($n);
//    exit;
    db_delete('node')
      ->condition('nid', $n->nid)
      ->execute();
    db_delete('node_revision')
      ->condition('nid', $n->nid)
      ->execute();
    db_delete('history')
      ->condition('nid', $n->nid)
      ->execute();
    db_delete('node_access')
     ->condition('nid', $n->nid)
     ->execute();
     
//    krumo($n);
//    exit;
  }
