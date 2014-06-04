<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

$f_name = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
$l_name = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';
$address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
$phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';

if (empty($password) or empty($username) or empty($email)) {
    echo json_encode(array("status" => "error", "message" => "Required fields are missing. Params[username, password, email]."));
    exit();
}

$errors = custom_register_new_user($username, $email, $password);
if (!is_wp_error($errors)) {

    $meta = array(
      'first_name'=>$f_name,
      'last_name'=>$l_name,
      'address'=>$address,
      'phone'=>$phone,
    );
    global $wpdb;
    $users_table = $wpdb->prefix . 'users';
    $login = $wpdb->get_results("select * from $users_table ORDER BY ID DESC LIMIT 1");
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
                    'first_name'=>$f_name,
                    'last_name'=>$l_name,
                    'address'=>$address,
                    'phone'=>$phone,
                )
    ));
    exit();
} else {
    $my_errors = $errors->errors;
    /*echo '<pre>';
    var_dump($my_errors);
    echo '</pre>';die;*/
    $data = array();
    $message = '';
    foreach ($my_errors as $key => $item) {
        //$data[] = $item[0];
        //$message .= $key;
        switch($key){
            case 'username_exists':
                $message .= 'This username is already registered, please choose another one. ';
                break;
            case 'email_exists':
                $message .= 'This email is already registered, please choose another one. ';
                break;
            case 'invalid_email':
                $message .= 'The email address isn’t correct. ';
                break;
        }
    }

    header('Content-type: text/json');
    echo json_encode(
        array(
            "status" => "error",
            'message' => 'Register fail. '.$message,
            //'data' => $data,
        ));
    exit();
}