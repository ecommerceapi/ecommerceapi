<<<<<<< HEAD
<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'list';
$order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
if (empty($token)) {
    echo json_encode(array("status" => "error", "message" => "User must login"));
    exit();
}
global $wpdb;

$login_token_table = $wpdb->prefix . 'login_token';
$users_table = $wpdb->prefix . 'users';
$table_toe_currency = $wpdb->prefix . 'toe_currency';
$login_token = $wpdb->get_results("select * from   $users_table u INNER JOIN $login_token_table ltt ON ltt.user_id = u.ID WHERE token = '$token'");

if (count($login_token) == 0) {
    echo json_encode(array("status" => "error", "message" => "Login faild"));
    exit();
}
$user_id = $login_token[0]->ID;


//get list order history
$toe_orders_items = $wpdb->prefix . 'toe_orders_items';
$toe_orders = $wpdb->prefix . 'toe_orders';

$currency = $wpdb->get_results("SELECT * FROM  wp_toe_currency WHERE use_as_default = 1");
$value = $currency[0]->value;
$symbol = $currency[0]->symbol;

$data = array();
$i = 0;



if($type =='detail'){
    if (empty($order_id)) {
        echo json_encode(array("status" => "error", "message" => "Order ID missing"));
        exit();
    }
    //$order_item = $wpdb->get_row("select * from $toe_orders WHERE id = $order_id");

    $table_posts = $wpdb->prefix . 'posts';
    $table_toe_product = $wpdb->prefix . 'toe_products';

    $order = $wpdb->get_row("select status from $toe_orders WHERE id = $order_id");
    $status = $order->status;
    $order_item_list = $wpdb->get_results("select * from $toe_orders_items toi INNER JOIN $table_posts tp ON tp.ID = toi.product_id INNER JOIN $table_toe_product ttp ON tp.ID= ttp.post_id  WHERE post_type='product' AND  toi.order_id = $order_id");
    //echo count($order_item_list);
	
    foreach ($order_item_list as $item) {
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($item->product_id));
        $promotion = get_post_meta($item->product_id, 'fruity_feed_price',TRUE);
	$promotion_price = $promotion*$value;
	$price = ($item->price)*$value;
	
    //discount
	//$discount = ($price-$promotion_price);
	//$total_discount += $discount;
	
        $arr = array(
            'status'=>$status,
            'product_id'=>$item->product_id,
            'product_name' => $item->product_name,
            'product_sku' => $item->product_sku,
            //'product_price' => $item->product_price,
            'product_qty' => $item->product_qty,
            'product_tax' => $item->tax_total,

            'title' => $item->post_title,
            'content' => $item->post_content,
            'excerpt' => $item->post_excerpt,
            'price' => $price,
	    'currency' => $symbol,
            'weight' => $item->weight,
            'sku' => $item->sku,
            'quantity' => $item->quantity,
            'featured' => $item->featured,
            'mark_as_new' => $item->mark_as_new,
            'width' => $item->width,
            'height' => $item->height,
            'length' => $item->length,
            'sort_order' => $item->sort_order,
            'promotion_price'=>$promotion_price,
            'thumbnail' => $image_url[0],
        );
        $data[] = $arr;
        $i++;
    }
}else{
    $order_list = $wpdb->get_results("select * from $toe_orders WHERE user_id = $user_id ORDER BY id DESC");
    foreach ($order_list as $item) {
        //$currency = json_decode($item->currency);
	$total_before = $item->total;
	//$total = $total_before*$value + $total_discount;
	$total = $total_before*$value;
	
	
        $arr = array(
            'id'=>$item->id,
            'sub_total'=>$item->sub_total,
            'tax_rate'=>$item->tax_rate,
            'total' => $total,
       	    'currency' => $symbol,
            'comments' => $item->comments,
            'date_created' => $item->date_created,
            'status'=>$item->status,
        );
        $data[] = $arr;
        $i++;
    }
}

//$wpdb->delete($toe_orders, array('id'=>19));
header('Content-type: text/json');
echo json_encode(
    array(
        "status" => "ok",
        'count' => $i,
        "data" => $data,
    ));
=======
<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'list';
$order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
if (empty($token)) {
    echo json_encode(array("status" => "error", "message" => "User must login"));
    exit();
}
global $wpdb;

$login_token_table = $wpdb->prefix . 'login_token';
$users_table = $wpdb->prefix . 'users';
$table_toe_currency = $wpdb->prefix . 'toe_currency';
$login_token = $wpdb->get_results("select * from   $users_table u INNER JOIN $login_token_table ltt ON ltt.user_id = u.ID WHERE token = '$token'");

if (count($login_token) == 0) {
    echo json_encode(array("status" => "error", "message" => "Login faild"));
    exit();
}
$user_id = $login_token[0]->ID;


//get list order history
$toe_orders_items = $wpdb->prefix . 'toe_orders_items';
$toe_orders = $wpdb->prefix . 'toe_orders';

$currency = $wpdb->get_results("SELECT * FROM  wp_toe_currency WHERE use_as_default = 1");
$value = $currency[0]->value;
$symbol = $currency[0]->symbol;

$data = array();
$i = 0;



if($type =='detail'){
    if (empty($order_id)) {
        echo json_encode(array("status" => "error", "message" => "Order ID missing"));
        exit();
    }
    //$order_item = $wpdb->get_row("select * from $toe_orders WHERE id = $order_id");

    $table_posts = $wpdb->prefix . 'posts';
    $table_toe_product = $wpdb->prefix . 'toe_products';

    $order = $wpdb->get_row("select status from $toe_orders WHERE id = $order_id");
    $status = $order->status;
    $order_item_list = $wpdb->get_results("select * from $toe_orders_items toi INNER JOIN $table_posts tp ON tp.ID = toi.product_id INNER JOIN $table_toe_product ttp ON tp.ID= ttp.post_id  WHERE post_type='product' AND  toi.order_id = $order_id");
    //echo count($order_item_list);
	
    foreach ($order_item_list as $item) {
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($item->product_id));
        $promotion = get_post_meta($item->product_id, 'fruity_feed_price',TRUE);
	$promotion_price = $promotion*$value;
	$price = ($item->price)*$value;
	
    //discount
	//$discount = ($price-$promotion_price);
	//$total_discount += $discount;
	
        $arr = array(
            'status'=>$status,
            'product_id'=>$item->product_id,
            'product_name' => $item->product_name,
            'product_sku' => $item->product_sku,
            //'product_price' => $item->product_price,
            'product_qty' => $item->product_qty,
            'product_tax' => $item->tax_total,

            'title' => $item->post_title,
            'content' => $item->post_content,
            'excerpt' => $item->post_excerpt,
            'price' => $price,
	    'currency' => $symbol,
            'weight' => $item->weight,
            'sku' => $item->sku,
            'quantity' => $item->quantity,
            'featured' => $item->featured,
            'mark_as_new' => $item->mark_as_new,
            'width' => $item->width,
            'height' => $item->height,
            'length' => $item->length,
            'sort_order' => $item->sort_order,
            'promotion_price'=>$promotion_price,
            'thumbnail' => $image_url[0],
        );
        $data[] = $arr;
        $i++;
    }
}else{
    $order_list = $wpdb->get_results("select * from $toe_orders WHERE user_id = $user_id ORDER BY id DESC");
    foreach ($order_list as $item) {
        //$currency = json_decode($item->currency);
	$total_before = $item->total;
	//$total = $total_before*$value + $total_discount;
	$total = $total_before*$value;
	
	
        $arr = array(
            'id'=>$item->id,
            'sub_total'=>$item->sub_total,
            'tax_rate'=>$item->tax_rate,
            'total' => $total,
       	    'currency' => $symbol,
            'comments' => $item->comments,
            'date_created' => $item->date_created,
            'status'=>$item->status,
        );
        $data[] = $arr;
        $i++;
    }
}

//$wpdb->delete($toe_orders, array('id'=>19));
header('Content-type: text/json');
echo json_encode(
    array(
        "status" => "ok",
        'count' => $i,
        "data" => $data,
    ));
>>>>>>> 866a2a89f634068fa942e1ff7981c15ced361c1e
exit();