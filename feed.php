<?php
require('../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$cat = (get_query_var('cat')) ? get_query_var('cat') : 0;

$number_post_show = get_option('fruity_feed_post_number');
$numposts = $number_post_show?$number_post_show:20;

$order_type_show = get_option('fruity_feed_order_type');
$order = $order_type_show?$order_type_show:'DESC';



//$posts = query_posts('showposts='.$numposts);

$arg = array(
    'post_type' => 'post',
    'posts_per_page' => $numposts,
    'paged' => $paged,
    'order'=>$order,
    'cat'=>'-16,-17',
);
if ($cat != 0)
    $arg['cat'] = $cat;

//$posts = query_posts('post_type=post&posts_per_page=20&paged=' . $paged.'&cat='.$cat);
$posts = query_posts($arg);
//$lastpost = $numposts - 1;

$data = array();
foreach ($posts as $post) {
  $arg2 = array(
      'title'=>$post->post_title,
      'link'=>get_permalink($post->ID),
      'description'=>'<h2>'.$post->post_title.'</h2>'.$post->post_content,
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
