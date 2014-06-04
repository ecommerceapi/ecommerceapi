<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : '';

global $wpdb;

if (empty($post_id)) {
    header('Content-type: text/json');
    echo json_encode(array("status" => "error", "message" => "Required fields are missing.."));
    exit();
}

$comments = get_comments(array(
			'post_id' => $post_id,
			//'status' => 'approve' //Change this to the type of comments to be displayed
		));
$data = array();
$c = count($comments);
foreach($comments as $comment) :

    $data[] = array(
        'comment_author'=>  $comment->comment_author,
        'comment_author_email'=>  $comment->comment_author_email,
        //'comment_date'=>  $comment->comment_date,
	'comment_date_gmt' => $comment->comment_date_gmt,
        'comment_author_IP'=>  $comment->comment_author_IP,
        'comment_content'=>  $comment->comment_content,
    );
endforeach;

header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "success",
            "message" => "",
            'count'=>$c,
            'data'=>$data,
            ));

exit();