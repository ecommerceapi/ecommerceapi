<<<<<<< HEAD
<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;
$data = array();
$arg = array('post_type' => 'fruity_banner', 'showposts' => 5);
$array1 = array('type'=>'text');
$array = array('type' => 'image');
query_posts($arg);

global $wpdb;
$table_toe_currency = $wpdb->prefix . 'toe_currency';


if (have_posts()) : while (have_posts()) : the_post();

    $id = rwmb_meta('fruity_feed_id_banner',$array1);
    $price = rwmb_meta('fruity_feed_price_banner',$array1);
    
    $promotion_price = rwmb_meta('fruity_feed_promotion_price_banner',$array1);

    $images = rwmb_meta('fruity_feed_image_banner', $array);
    $full_url = '';
    foreach ($images as $image) {
        $full_url = $image['full_url'];
    }

$currency = $wpdb->get_results("SELECT * FROM  wp_toe_currency WHERE use_as_default = 1");
$value = $currency[0]->value;
$symbol = $currency[0]->symbol;
    $data[]= array(
        'id'=>$id,
        'title'=>get_the_title(),
        'content'=>get_the_content(),
        'image'=>$full_url,
        'price' =>$price*$value,
	'promotion_price' =>$promotion_price*$value,
	'currency' => $symbol,
    );
   endwhile;
endif;

header('Content-type: text/json');
echo json_encode(
    array(
        "status" => "ok",
        'count' => $number,
        "data" => $data,
    ));
=======
<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;
$data = array();
$arg = array('post_type' => 'fruity_banner', 'showposts' => 5);
$array1 = array('type'=>'text');
$array = array('type' => 'image');
query_posts($arg);

global $wpdb;
$table_toe_currency = $wpdb->prefix . 'toe_currency';


if (have_posts()) : while (have_posts()) : the_post();

    $id = rwmb_meta('fruity_feed_id_banner',$array1);
    $price = rwmb_meta('fruity_feed_price_banner',$array1);
    
    $promotion_price = rwmb_meta('fruity_feed_promotion_price_banner',$array1);

    $images = rwmb_meta('fruity_feed_image_banner', $array);
    $full_url = '';
    foreach ($images as $image) {
        $full_url = $image['full_url'];
    }

$currency = $wpdb->get_results("SELECT * FROM  wp_toe_currency WHERE use_as_default = 1");
$value = $currency[0]->value;
$symbol = $currency[0]->symbol;
    $data[]= array(
        'id'=>$id,
        'title'=>get_the_title(),
        'content'=>get_the_content(),
        'image'=>$full_url,
        'price' =>$price*$value,
	'promotion_price' =>$promotion_price*$value,
	'currency' => $symbol,
    );
   endwhile;
endif;

header('Content-type: text/json');
echo json_encode(
    array(
        "status" => "ok",
        'count' => $number,
        "data" => $data,
    ));
>>>>>>> 866a2a89f634068fa942e1ff7981c15ced361c1e
exit();