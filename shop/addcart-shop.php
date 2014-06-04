<<<<<<< HEAD
<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;
//
$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
if (empty($token)) {
    echo json_encode(array("status" => "error", "message" => "User must login"));
    exit();
}
global $wpdb;
$login_token_table = $wpdb->prefix . 'login_token';
$users_table = $wpdb->prefix . 'users';
$login_token = $wpdb->get_results("select * from   $users_table u INNER JOIN $login_token_table ltt ON ltt.user_id = u.ID WHERE token = '$token'");

if (count($login_token) == 0) {
    echo json_encode(array("status" => "error", "message" => "Login faild"));
    exit();
}
//var_dump($login_token);
$user_id = $login_token[0]->ID;

$bill_first_name = isset($_REQUEST['b_f_name']) ? $_REQUEST['b_f_name'] : 'fq_test';
$bill_last_name = isset($_REQUEST['b_l_name']) ? $_REQUEST['b_l_name'] : 'lq_test';
$bill_address = isset($_REQUEST['b_address']) ? $_REQUEST['b_address'] : 'aq_test';
$bill_city = isset($_REQUEST['b_city']) ? $_REQUEST['b_city'] : 'cq_test';
$bill_zipcode = isset($_REQUEST['b_zip']) ? $_REQUEST['b_zip'] : 'zq_test';
$bill_country = isset($_REQUEST['b_country']) ? $_REQUEST['b_country'] : 232;
$bill_phone = isset($_REQUEST['b_phone']) ? $_REQUEST['b_phone'] : 'pq_test';
$bill_fax = isset($_REQUEST['b_fax']) ? $_REQUEST['b_fax'] : 'fq_test';

$sub_total = isset($_REQUEST['sub_total']) ? $_REQUEST['sub_total'] : 170;
$tax_rate = isset($_REQUEST['tax_rate']) ? $_REQUEST['tax_rate'] : 30;
$total = isset($_REQUEST['total']) ? $_REQUEST['total'] : 200;
$comment = isset($_REQUEST['cmt']) ? $_REQUEST['cmt'] : '';

//$items = isset($_REQUEST['items']) ? $_REQUEST['items'] : '';
$items = isset($_REQUEST['items']) ? $_REQUEST['items'] : '';
if (empty($items)) {
    echo json_encode(array("status" => "error", "message" => "Required fields are missing.."));
    exit();
}
//var_dump($items);die;
//echo $items;die;
/*$arr = array(
    array(
        'order_id' => 1,
        'product_id' => 95,
        'product_name' => 'pro duct',
        'product_sku' => 'sku',
        'product_price' => 35,
        'product_qty' => 12,
        'tax_total'=>'0.05',
    ),
    array(
        'order_id' => 2,
        'product_id' => 96,
        'product_name' => 'pro duct2',
        'product_sku' => 'sdf',
        'product_price' => '45',
        'product_qty' => 121,
        'tax_total'=>'0.07',
    )
);
$items = json_encode($arr);
*/
if(count($items)==0){
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "error",
            'message'=>'Items is invalid',
        ));
    exit();
}
$bill_array = json_encode(array(
    'first_name' => $bill_first_name,
    'last_name' => $bill_last_name,
    'address' => $bill_address,
    'city' => $bill_city,
    'zip' => $bill_zipcode,
    'country'=>$bill_country,
    'phone' => $bill_phone,
    'fax' => $bill_fax,
        ));
$toe_orders_items = $wpdb->prefix . 'toe_orders_items';
$toe_orders = $wpdb->prefix . 'toe_orders';
// Start Transaction
$result1 = $result2 = TRUE;
//@mysql_query("BEGIN", $wpdb->dbh);
mysql_query('START TRANSACTION');
//save in to order table
$result1 = $wpdb->insert($toe_orders, array(
    'shipping_address' => $bill_array,
    'billing_address' => $bill_array,
    'sub_total'=>$sub_total,
    'tax_rate'=>$tax_rate,
    'total' => $total,
    'status' => 'pending',
    'user_id' => $user_id,
    'comments' => $comment,
    'date_created' => time(),
        ));
$order_id = $wpdb->insert_id;
foreach ($items as $item) {
    $result2 = $wpdb->insert($toe_orders_items, array(
        'order_id' => $order_id,
        'product_id' => $item['product_id'],
        'product_name' => $item['product_name'],
        'product_sku' => $item['product_sku'],
        'product_price' => $item['product_price'],
        'product_qty' => $item['product_qty'],
        'tax_total'=>$item['tax_total'],
            ));
}
/*if (!$error) {
    // Error occured, don't save any changes
    @mysql_query("ROLLBACK", $wpdb->dbh);
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "error",
            'message'=>'Cannot save data now',
        ));
} else {
    // All ok, save the changes
    @mysql_query("COMMIT", $wpdb->dbh);
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "success",
            'message'=>'Checkout success',
        ));
}
exit();*/

if($result1 && $result2){
    mysql_query('COMMIT');
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "success",
            'message'=>'Checkout success',
        ));
}else{
    mysql_query('ROLLBACK');
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "error",
            'message'=>'Cannot save data now',
        ));
}
exit();

=======
<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;
//
$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
if (empty($token)) {
    echo json_encode(array("status" => "error", "message" => "User must login"));
    exit();
}
global $wpdb;
$login_token_table = $wpdb->prefix . 'login_token';
$users_table = $wpdb->prefix . 'users';
$login_token = $wpdb->get_results("select * from   $users_table u INNER JOIN $login_token_table ltt ON ltt.user_id = u.ID WHERE token = '$token'");

if (count($login_token) == 0) {
    echo json_encode(array("status" => "error", "message" => "Login faild"));
    exit();
}
//var_dump($login_token);
$user_id = $login_token[0]->ID;

$bill_first_name = isset($_REQUEST['b_f_name']) ? $_REQUEST['b_f_name'] : 'fq_test';
$bill_last_name = isset($_REQUEST['b_l_name']) ? $_REQUEST['b_l_name'] : 'lq_test';
$bill_address = isset($_REQUEST['b_address']) ? $_REQUEST['b_address'] : 'aq_test';
$bill_city = isset($_REQUEST['b_city']) ? $_REQUEST['b_city'] : 'cq_test';
$bill_zipcode = isset($_REQUEST['b_zip']) ? $_REQUEST['b_zip'] : 'zq_test';
$bill_country = isset($_REQUEST['b_country']) ? $_REQUEST['b_country'] : 232;
$bill_phone = isset($_REQUEST['b_phone']) ? $_REQUEST['b_phone'] : 'pq_test';
$bill_fax = isset($_REQUEST['b_fax']) ? $_REQUEST['b_fax'] : 'fq_test';

$sub_total = isset($_REQUEST['sub_total']) ? $_REQUEST['sub_total'] : 170;
$tax_rate = isset($_REQUEST['tax_rate']) ? $_REQUEST['tax_rate'] : 30;
$total = isset($_REQUEST['total']) ? $_REQUEST['total'] : 200;
$comment = isset($_REQUEST['cmt']) ? $_REQUEST['cmt'] : '';

//$items = isset($_REQUEST['items']) ? $_REQUEST['items'] : '';
$items = isset($_REQUEST['items']) ? $_REQUEST['items'] : '';
if (empty($items)) {
    echo json_encode(array("status" => "error", "message" => "Required fields are missing.."));
    exit();
}
//var_dump($items);die;
//echo $items;die;
/*$arr = array(
    array(
        'order_id' => 1,
        'product_id' => 95,
        'product_name' => 'pro duct',
        'product_sku' => 'sku',
        'product_price' => 35,
        'product_qty' => 12,
        'tax_total'=>'0.05',
    ),
    array(
        'order_id' => 2,
        'product_id' => 96,
        'product_name' => 'pro duct2',
        'product_sku' => 'sdf',
        'product_price' => '45',
        'product_qty' => 121,
        'tax_total'=>'0.07',
    )
);
$items = json_encode($arr);
*/
if(count($items)==0){
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "error",
            'message'=>'Items is invalid',
        ));
    exit();
}
$bill_array = json_encode(array(
    'first_name' => $bill_first_name,
    'last_name' => $bill_last_name,
    'address' => $bill_address,
    'city' => $bill_city,
    'zip' => $bill_zipcode,
    'country'=>$bill_country,
    'phone' => $bill_phone,
    'fax' => $bill_fax,
        ));
$toe_orders_items = $wpdb->prefix . 'toe_orders_items';
$toe_orders = $wpdb->prefix . 'toe_orders';
// Start Transaction
$result1 = $result2 = TRUE;
//@mysql_query("BEGIN", $wpdb->dbh);
mysql_query('START TRANSACTION');
//save in to order table
$result1 = $wpdb->insert($toe_orders, array(
    'shipping_address' => $bill_array,
    'billing_address' => $bill_array,
    'sub_total'=>$sub_total,
    'tax_rate'=>$tax_rate,
    'total' => $total,
    'status' => 'pending',
    'user_id' => $user_id,
    'comments' => $comment,
    'date_created' => time(),
        ));
$order_id = $wpdb->insert_id;
foreach ($items as $item) {
    $result2 = $wpdb->insert($toe_orders_items, array(
        'order_id' => $order_id,
        'product_id' => $item['product_id'],
        'product_name' => $item['product_name'],
        'product_sku' => $item['product_sku'],
        'product_price' => $item['product_price'],
        'product_qty' => $item['product_qty'],
        'tax_total'=>$item['tax_total'],
            ));
}
/*if (!$error) {
    // Error occured, don't save any changes
    @mysql_query("ROLLBACK", $wpdb->dbh);
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "error",
            'message'=>'Cannot save data now',
        ));
} else {
    // All ok, save the changes
    @mysql_query("COMMIT", $wpdb->dbh);
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "success",
            'message'=>'Checkout success',
        ));
}
exit();*/

if($result1 && $result2){
    mysql_query('COMMIT');
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "success",
            'message'=>'Checkout success',
        ));
}else{
    mysql_query('ROLLBACK');
    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "error",
            'message'=>'Cannot save data now',
        ));
}
exit();

>>>>>>> 866a2a89f634068fa942e1ff7981c15ced361c1e
