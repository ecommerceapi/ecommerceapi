<?php
require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

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
$user_id = $login_token[0]->ID;

$f_name = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
$l_name = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';

$address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
$phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';


if (isset( $_REQUEST['email'])) {
    // check if user is really updating the value
    if ($user_email != $_REQUEST['email']) {       
        // check if email is free to use
        if (email_exists( $_REQUEST['email'] )){
            // Email exists, do not update value.
            // Maybe output a warning.
        } else {
            $args = array(
                'ID'         => $user_id,
                'user_email' => esc_attr( $_REQUEST['email'] )
            );            
        wp_update_user( $args );
       }   
   }
}     

$meta = array(
    'first_name'=>$f_name,
    'last_name'=>$l_name,
    'address'=>$address,
    'phone'=>$phone,
);


foreach($meta as $key =>$item){

	
    update_user_meta( $user_id, $key, $item);
}
header('Content-type: text/json');
echo json_encode(
    array(
        "status" => "success",
        'message'=>'Update success',
    ));