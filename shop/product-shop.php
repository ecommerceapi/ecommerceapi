<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
die;

$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : '';
//$post_id = 90;
if (empty($post_id)) {
    header('Content-type: text/json');
    echo json_encode(array("status" => "error", "message" => "Required fields are missing.."));
    exit();
}

global $wpdb;
$table_posts = $wpdb->prefix . 'posts';
$table_toe_product = $wpdb->prefix . 'toe_products';
$table_toe_currency = $wpdb->prefix . 'toe_currency';

//get result
$posts = $wpdb->get_results("select * from  $table_posts p INNER JOIN $table_toe_product tp ON tp.post_id = p.ID WHERE post_type = 'product' AND p.ID = $post_id");

$currency = $wpdb->get_results("SELECT * FROM  wp_toe_currency WHERE use_as_default = 1");
$value = $currency[0]->value;
$symbol = $currency[0]->symbol;

$data = array();
$i = 0;

$arg = array(
    'post_parent'=>$post_id,
    'post_type'=>'attachment',  
    'post_status'=>'inherit',
    );
$attachments = query_posts($arg);
$gallery = '';
foreach ($attachments as $item){
    $gallery[]= array(
        'image'=> $item->guid,
    );
}
//var_dump($gallery);die;
foreach ($posts as $post) {
$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
$promotion = get_post_meta($post->ID, 'fruity_feed_price',TRUE);
$promotion_price = $promotion*$value;
$arr = array(
'id' => $post->ID,
 //'slug'=>$category->slug,
'title' => get_the_title(),
 'content' => get_the_content(),
 'excerpt' => get_the_excerpt(),
 'price' => ($post->price)*$value,
 'currency' => $symbol,
 'weight' => $post->weight,
 'sku' => $post->sku,
 'quantity' => $post->quantity,
 'featured' => $post->featured,
 'mark_as_new' => $post->mark_as_new,
 'width' => $post->width,
 'height' => $post->height,
 'length' => $post->length,
 'sort_order' => $post->sort_order,
 'promotion_price'=>$promotion_price,
 'thumbnail' => $image_url[0],
 'category_slug' => $post->slug,
 'categories' => get_the_product_category(), //get_the_category(),
 'gallery'=>  $gallery,
);
$data[] = $arr;
$i++;
}

header('Content-type: text/json');
echo json_encode(
array(
"status" => "ok",
 'count' => $i,
 "data" => $data,
));
exit();

/*
  $arg = array(
  'post_type'=>'fruity_product',
  );
  $slug = '';
  if(isset($_GET['slug'])){
  $slug = $_GET['slug'];
  $arg['fruity_product_categories'] = $slug;
  }
  //var_dump($arg);die;

  $data = array();
  //$number = count($categories);
  $i = 0;
  $array1 = array('type'=>'text');
  query_posts($arg);
  if (have_posts()) : while (have_posts()) : the_post();
  $arr = array(
  'id'=>get_the_ID(),
  //'slug'=>$category->slug,
  'title'=>get_the_title(),
  'description'=>get_the_content(),
  'price'=> rwmb_meta('fruity_feed_price',$array1),
  );
  $data[] = $arr;
  $i++;
  endwhile;
  endif;

  header('Content-type: text/json');
  echo json_encode(
  array(
  "status" => "ok",
  'count' => $i,
  "data" => $data,
  ));
  exit();
 */

