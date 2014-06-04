<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
//$token = '3bde4c58c7b75f7f10bc06f14b194e6b';
$comment_content = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
//$comment_content = 'Cui';
$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : '';
//$post_id = 221;

if (empty($token)) {
    header('Content-type: text/json');
    echo json_encode(array("status" => "error", "message" => "User must login"));
    exit();
}
global $wpdb;
$login_token_table = $wpdb->prefix . 'login_token';
$users_table = $wpdb->prefix . 'users';
$login_token = $wpdb->get_results("select * from $users_table u INNER JOIN $login_token_table ltt ON ltt.user_id = u.ID WHERE token = '$token'");

if (count($login_token) == 0) {
    header('Content-type: text/json');
    echo json_encode(array("status" => "error", "message" => "Login faild"));
    exit();
}
//var_dump($login_token);
$ctime = time();
$user_id = $login_token[0]->ID;
$comment_author = $login_token[0]->user_login;
$comment_author_email = $login_token[0]->user_email;
$comment_date = date('Y-m-d H:i:s');
$comment_date_gmt = date('Y-m-d H:i:s', $ctime + 7*3600);
$comment_parent = 0;
$comment_approved = 0;
$comment_author_IP = $_SERVER['REMOTE_ADDR'];

if (empty($post_id) || empty($comment_content)) {
    header('Content-type: text/json');
    echo json_encode(array("status" => "error", "message" => "Required fields are missing.."));
    exit();
}

$comment_table = $wpdb->prefix . 'comments';
$result = $wpdb->insert($comment_table, array(
    'user_id' => $user_id,
    'comment_post_ID' => $post_id,
    'comment_author' => $comment_author,
    'comment_author_email' => $comment_author_email,
    'comment_date' => $comment_date,
    'comment_date_gmt' => $comment_date_gmt,
    'comment_content' => $comment_content,
    'comment_parent' => $comment_parent,
    'comment_approved' => $comment_approved,
    'comment_author_IP'=>$comment_author_IP,
        ));
header('Content-type: text/json');
if ($result) {
    echo json_encode(
            array(
                "status" => "success",
                "message" => "Comment success!"));

} else {
    $wpdb->show_errors = true;
    $wpdb->print_error();
    echo json_encode(
            array(
                "status" => "error",
                "message" => "Comment fail!"));    
}
exit();