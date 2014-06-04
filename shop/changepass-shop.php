<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$username = isset($_REQUEST['log']) ? $_REQUEST['log'] : '';
$password = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';
$new_password = isset($_REQUEST['npwd']) ? $_REQUEST['npwd'] : '';

if (empty($password) or empty($username) or empty($new_password)) {
    echo json_encode(array("status" => "error", "message" => "Required fields are missing. Params[username, password]."));
    exit();
}

$login_data = array();
$login_data['user_login'] = $username;
$login_data['user_password'] = $password;
$user_verify = wp_signon($login_data, false);

//$user_verify = wp_signon('', false);
header('Content-type: text/json');
if (is_wp_error($user_verify)) {
    echo json_encode(
            array(
                "status" => "error",
                "message" => "Invalid username or password!"));
    exit();
} else {
    //change password here
    global $wpdb;
    $users_table = $wpdb->prefix . 'users';
    $users = $wpdb->get_results("select * from $users_table WHERE user_login = '$username'");
    if(count($users)==1){
        $user_id = $users[0]->ID;
        wp_set_password($new_password,$user_id);
        echo json_encode(
            array(
                "status" => "success",
                "message" => "Change password success"));
        exit();
    }
    echo json_encode(
        array(
            "status" => "error",
            "message" => "Change password error"));
    exit();
}

