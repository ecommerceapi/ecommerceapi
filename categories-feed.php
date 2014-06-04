<?php
require('../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if(!get_option('fruity_feed_option')) die;



function fruity_rss_date( $timestamp = null ) {
  $timestamp = ($timestamp==null) ? time() : $timestamp;
  echo date(DATE_RSS, $timestamp);
}

$args = array(
  'orderby' => 'name',
  'order' => 'ASC',
  'hide_empty'=>0,
  );
$categories = get_categories($args);
//var_dump($categories);die;
$data = array();
foreach ($categories as $category){
  if(!in_array($category->term_id,array(16,17))){
      $data[]= array(
          'id'=>$category->term_id,
          'name'=>$category->name,
          //'link'=>plugins_url('/fruity-feed/feed.php').'?cat='.$category->term_id,
          'link'=>'feed.php?cat='.$category->term_id,
      );
  }
} 

header('Content-type: text/json');
    echo json_encode(
            array(
                "status" => "success",
                'message' => '',
                'data' => $data,
    ));
    exit();
