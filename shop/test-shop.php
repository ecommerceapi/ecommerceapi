<<<<<<< HEAD
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<!--<form method="post" action="http://localhost/wponline/wp-content/plugins/fruity-feed/shop/addcart-shop.php?token=f7de8b9fe7cd7e1f5a6b4816deb54c33">-
-->
<form method="post" action="http://lorge.info/lorena/wp-content/plugins/fruity-feed/shop/addcart-shop.php?token=9293bd3c8734f6f6cf1dc2d7ab357f53">
   <input type="hidden" name="items[0][product_id]" value="132">
    <input type="hidden" name="items[0][product_name]" value="san pham 1">
    <input type="hidden" name="items[0][product_sku]" value="98">
    <input type="hidden" name="items[0][product_price]" value="98">
    <input type="hidden" name="items[0][product_qty]" value="2">
    <input type="hidden" name="items[0][tax_total]" value="0.23">

    <input type="hidden" name="items[1][product_id]" value="159">
    <input type="hidden" name="items[1][product_name]" value="san pham 2">
    <input type="hidden" name="items[1][product_sku]" value="98">
    <input type="hidden" name="items[1][product_price]" value="98">
    <input type="hidden" name="items[1][product_qty]" value="2">
    <input type="hidden" name="items[1][tax_total]" value="0.23">
    <input type="submit" value="submit">
</form>

</body>
</html>

<?php
//die;
require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

global $wpdb;
$table_posts = $wpdb->prefix . 'posts';
$comment_table = $wpdb->prefix . 'login_token';
$toe_orders = $wpdb->prefix . 'toe_orders';
$toe_orders_items = $wpdb->prefix . 'toe_orders_items';

//$wpdb->query("TRUNCATE  TABLE $toe_orders");
//$wpdb->query("TRUNCATE  TABLE $toe_orders_items");

$posts = $wpdb->get_results("select * from $toe_orders_items");
//var_dump($posts);die;
$data = array();
$i = 0;

foreach ($posts as $post) {
    $arr= array(
        'order'=>$post->order_id,
        'product_id'=>$post->product_id,
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


=======
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<!--<form method="post" action="http://localhost/wponline/wp-content/plugins/fruity-feed/shop/addcart-shop.php?token=f7de8b9fe7cd7e1f5a6b4816deb54c33">-
-->
<form method="post" action="http://lorge.info/lorena/wp-content/plugins/fruity-feed/shop/addcart-shop.php?token=9293bd3c8734f6f6cf1dc2d7ab357f53">
   <input type="hidden" name="items[0][product_id]" value="132">
    <input type="hidden" name="items[0][product_name]" value="san pham 1">
    <input type="hidden" name="items[0][product_sku]" value="98">
    <input type="hidden" name="items[0][product_price]" value="98">
    <input type="hidden" name="items[0][product_qty]" value="2">
    <input type="hidden" name="items[0][tax_total]" value="0.23">

    <input type="hidden" name="items[1][product_id]" value="159">
    <input type="hidden" name="items[1][product_name]" value="san pham 2">
    <input type="hidden" name="items[1][product_sku]" value="98">
    <input type="hidden" name="items[1][product_price]" value="98">
    <input type="hidden" name="items[1][product_qty]" value="2">
    <input type="hidden" name="items[1][tax_total]" value="0.23">
    <input type="submit" value="submit">
</form>

</body>
</html>

<?php
//die;
require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

global $wpdb;
$table_posts = $wpdb->prefix . 'posts';
$comment_table = $wpdb->prefix . 'login_token';
$toe_orders = $wpdb->prefix . 'toe_orders';
$toe_orders_items = $wpdb->prefix . 'toe_orders_items';

//$wpdb->query("TRUNCATE  TABLE $toe_orders");
//$wpdb->query("TRUNCATE  TABLE $toe_orders_items");

$posts = $wpdb->get_results("select * from $toe_orders_items");
//var_dump($posts);die;
$data = array();
$i = 0;

foreach ($posts as $post) {
    $arr= array(
        'order'=>$post->order_id,
        'product_id'=>$post->product_id,
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


>>>>>>> 866a2a89f634068fa942e1ff7981c15ced361c1e
