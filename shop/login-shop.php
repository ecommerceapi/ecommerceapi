<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;
$username = isset($_REQUEST['log']) ? $_REQUEST['log'] : '';

$password = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';


if (empty($password) or empty($username)) {
    echo json_encode(array("status" => "error", "message" => "Required fields are missing. Params[username, password]."));
    exit();
}
global $wpdb;
$users_table = $wpdb->prefix . 'users';
$user = FALSE;
$login_success = TRUE;
$login_data = array();
$login_data['user_login'] = $username;
$login_data['user_password'] = $password;
$user_verify = wp_signon($login_data, false);

//$user_verify = wp_signon('', false);
header('Content-type: text/json');

if (is_wp_error($user_verify)) {
    $new_pass_option = get_option($username.'_forgotpass');
    $user = $wpdb->get_row("select * from $users_table WHERE user_login = '$username'");

    if($new_pass_option && md5($password)==$new_pass_option && $user!=null){
        $user_ID = $user->ID;
        //login with new pass success
        //1. change password in here
        wp_set_password($password,$user_ID);
        //2. delete option_forgot

    }else{
        $login_success = FALSE;//echo md5($password);
        echo json_encode(
            array(
                "status" => "error",
                "message" => "Invalid username or password1!"));
        exit();
    }

}
//delete option_forgot
delete_option($username.'_forgotpass');
if($login_success){
    $token = md5($username . time());
    //save token in database;

    global $current_user;
    global $user_ID;

    if(!$user)
        $user = $wpdb->get_row("select * from $users_table WHERE user_login = '$username'");
    if($user == null){
        echo json_encode(
            array(
                "status" => "error",
                "message" => "Invalid username or password!"));
        exit();
    }
    $table_login_token = $wpdb->prefix . 'login_token';
    $data = array(
        'user_id' => $user->ID,
        'token' => $token,
        'time' => date('Y-m-d H:i:s', time()),
    );
    $wpdb->insert($table_login_token, $data);
    //show on screen
    $user_ID = $user->ID;
    $data = array(
        'user_id' => $user->ID,
        'email'=>$user->user_email,
        'token' => $token,
        'first_name'=>get_user_meta($user_ID,'first_name',TRUE),
        'last_name'=>get_user_meta($user_ID,'last_name',TRUE),
        'address'=>get_user_meta($user_ID,'address',TRUE),
        'phone'=>get_user_meta($user_ID,'phone',TRUE),
        'created_time' => date('Y-m-d H:i:s', time()),
    );
    echo json_encode(
        array(
            "status" => "ok",
            "token" => $token,
            'data'=>$data,
        ));
    exit();
}



