<<<<<<< HEAD
<?php
require('../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$order_type_show = get_option('fruity_feed_order_type');
$order = $order_type_show ? $order_type_show : 'DESC';

$table_posts = $wpdb->prefix . 'posts';
$table_postmeta = $wpdb->prefix . 'postmeta';
$table_relation = $wpdb->prefix . 'term_relationships';
//get result
$posts = $wpdb->get_results("select * from  $table_posts p INNER JOIN $table_relation tl ON p.ID = tl.object_id INNER JOIN $table_postmeta m ON m.post_id = tl.object_id WHERE meta_key='fruity_feed_hot' AND meta_value = 1  AND term_taxonomy_id NOT IN (16,17) ORDER BY p.ID $order");

$data = array();
foreach ($posts as $post) {
  $arg2 = array(
      'title'=>$post->post_title,
      'link'=>get_permalink($post->ID),
      'description'=>$post->post_content, 
      'createdate'=>$post->post_date,
      'image'=>'',
  );
  if (has_post_thumbnail()) {
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
        $arg2['image']=$image_url[0];
    }
  $data[]= $arg2;
} 

header('Content-type: text/json');
    echo json_encode(
            array(
                "status" => "success",
                'message' => '',
                'data' => $data,
    ));
    exit();
=======
<?php
require('../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$order_type_show = get_option('fruity_feed_order_type');
$order = $order_type_show ? $order_type_show : 'DESC';

$table_posts = $wpdb->prefix . 'posts';
$table_postmeta = $wpdb->prefix . 'postmeta';
$table_relation = $wpdb->prefix . 'term_relationships';
//get result
$posts = $wpdb->get_results("select * from  $table_posts p INNER JOIN $table_relation tl ON p.ID = tl.object_id INNER JOIN $table_postmeta m ON m.post_id = tl.object_id WHERE meta_key='fruity_feed_hot' AND meta_value = 1  AND term_taxonomy_id NOT IN (16,17) ORDER BY p.ID $order");

$data = array();
foreach ($posts as $post) {
  $arg2 = array(
      'title'=>$post->post_title,
      'link'=>get_permalink($post->ID),
      'description'=>$post->post_content, 
      'createdate'=>$post->post_date,
      'image'=>'',
  );
  if (has_post_thumbnail()) {
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
        $arg2['image']=$image_url[0];
    }
  $data[]= $arg2;
} 

header('Content-type: text/json');
    echo json_encode(
            array(
                "status" => "success",
                'message' => '',
                'data' => $data,
    ));
    exit();
>>>>>>> 866a2a89f634068fa942e1ff7981c15ced361c1e
