<?php
require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if(!get_option('fruity_feed_option')) die;

$args = array(
  'orderby' => 'name',
  'order' => 'ASC',
  'hide_empty'=>0,
  'taxonomy'=> 'products_categories',
  );
$categories = get_categories($args);

$data = array();
$number = count($categories);
global $wpdb;
$table_toe_currency = $wpdb->prefix . 'toe_currency';

foreach ($categories as $category) {

    $arr = array(
        'id'=>$category->term_id,
        'slug'=>$category->slug,
        'title'=>$category->name,
        'content'=>$category->description,
        'parent'=>$category->parent,
        'post_count'=>$category->count,
        //'link'=>plugins_url('list-shop.php?slug='.$category->slug, __FILE__),
        'link'=>'shop/list-shop.php?slug='.$category->slug,
        'image'=>get_option('z_taxonomy_image'.$category->term_id),//$image_link,
	
    );
    $data[] = $arr;
}

header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "ok",
            'count' => $number,
            "categories" => $data,
));
exit();

/*
$args = array(
  'orderby' => 'name',
  'order' => 'ASC',
  'hide_empty'=>0,
  'taxonomy'=> 'fruity_product_categories',
  );
$categories = get_categories($args);

$data = array();
$number = count($categories);

foreach ($categories as $category) {
    $arr = array(
        'id'=>$category->term_id,
        'slug'=>$category->slug,
        'title'=>$category->name,
        'description'=>$category->description,
        'parent'=>$category->parent,
        'post_count'=>$category->count,
        'link'=>plugins_url('list-shop.php?slug='.$category->slug, __FILE__),
    );
    $data[] = $arr;
}

header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "ok",
            'count' => $number,
            "categories" => $data,
));
exit();
 */