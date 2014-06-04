<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;
$server_key = 'jd32te876dnsim98dhyweyou';
$key = isset($_REQUEST['key']) ? $_REQUEST['key'] : '';
$username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';

$f_name = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
$l_name = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';
$address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
//$phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
if($key != $server_key)die;
if (empty($username) or empty($email)) {
    echo json_encode(array("status" => "error", "message" => "Required fields are missing. Params[username, email]."));
    exit();
}

global $wpdb;
$users_table = $wpdb->prefix . 'users';
$user = $wpdb->get_row("select * from $users_table WHERE user_login = '$username'");
//var_dump($user);die;
if($user){
    $login_data = array();
    $login_data['user_login'] = $username;
    $login_data['user_password'] = $email;
    $user_verify = wp_signon($login_data, false);
    if (is_wp_error($user_verify)) {
        echo json_encode(
            array(
                "status" => "error",
                "message" => "Invalid username or password!"));
        exit();
    } else {
        $token = md5($username . time());
        $posts = $wpdb->get_row("select * from $users_table WHERE user_login = '$username'");
        if($posts == null){
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Invalid username or password!"));
            exit();
        }
        $table_login_token = $wpdb->prefix . 'login_token';
        $data = array(
            'user_id' => $posts->ID,
            'token' => $token,
            'time' => date('Y-m-d H:i:s', time()),
        );
        $wpdb->insert($table_login_token, $data);
        $user_ID = $posts->ID;
        $data = array(
            'user_id' => $posts->ID,
            'email'=>$posts->user_email,
            'token' => $token,
            'first_name'=>get_user_meta($user_ID,'first_name',TRUE),
            'last_name'=>get_user_meta($user_ID,'last_name',TRUE),
            'address'=>get_user_meta($user_ID,'address',TRUE),
            //'phone'=>get_user_meta($user_ID,'phone',TRUE),
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
}else{
    //register new user
    $errors = custom_register_new_user($username, $email, $email);
    if (!is_wp_error($errors)) {
        $meta = array(
            'first_name'=>$f_name,
            'last_name'=>$l_name,
            'address'=>$address,
            //'phone'=>$phone,
        );
        $login = $wpdb->get_results("select ID from $users_table  WHERE user_login = '$username'");
        if(count($login)>0){
            $user_id = $login[0]->ID;
            foreach($meta as $key =>$item){
                update_user_meta( $user_id, $key, $item);
            }
        }
        header('Content-type: text/json');
        echo json_encode(
            array(
                "status" => "ok",
                'message' => 'Register success',
                'data'=>array(
                    'username'=>$username,
                    'email'=>$email,
		    'token' => $token,
                    'first_name'=>$f_name,
                    'last_name'=>$l_name,
                    'address'=>$address,
                    //'phone'=>$phone,
                )
            ));
        exit();
    }else{
        $my_errors = $errors->errors;
        $data = array();
        foreach ($my_errors as $key => $item) {
            $data[] = $key;
        }
        header('Content-type: text/json');
        echo json_encode(
            array(
                "status" => "error",
                'message' => 'Register fail',
                'data' => $data,
            ));
        exit();
    }
}