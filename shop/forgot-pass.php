<?php
require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

function generatePassword($length = 8)
{
    // start with a blank password
    $password = "";
    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
        $length = $maxlength;
    }
    // set up a counter for how many characters are in the password so far
    $i = 0;
    // add random characters to $password until $length is reached
    while ($i < $length) {
        // pick a random character from the possible ones
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
        // have we already used this character in $password?
        if (!strstr($password, $char)) {
            // no, so it's OK to add it onto the end of whatever we've already got...
            $password .= $char;
            // ... and increase the counter by one
            $i++;
        }
    }
    // done!
    return $password;
}

if (!get_option('fruity_feed_option'))
    die;
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
if (empty($email)) {
    echo json_encode(array("status" => "error", "message" => "Required fields are missing. Params[email]."));
    exit();
}
global $wpdb;
$users_table = $wpdb->prefix . 'users';
$user = $wpdb->get_row("select * from $users_table WHERE user_email = '$email'");
if($user == null){
    echo json_encode(
        array(
            "status" => "error",
            "message" => "Email in not exist"));
    exit();
}
$username = $user->user_login;
$option_name = $username.'_forgotpass';
//set new option in here
$new_pass = generatePassword();

//delete_option($option_name);die;

if(add_option($option_name,md5($new_pass)))
    //send email in here
    mail( $email, 'New password', $new_pass, 'Your new password is:' );
echo json_encode(
    array(
        "status" => "success",
        "message" => "Please check email ( maybe you should also check in spam box)",
        //'pass'=>$new_pass,
    ));
exit();
