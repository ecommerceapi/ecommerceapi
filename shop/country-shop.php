<<<<<<< HEAD
<?php
require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if(!get_option('fruity_feed_option')) die;

global $wpdb;
$country_table = $wpdb->prefix . 'toe_countries';
$countries = $wpdb->get_results("select * from  $country_table");


$data = array();
$number = count($countries);

foreach ($countries as $country) {
    $arr = array(
        'id'=>$country->id,
        'name'=>$country->name,
        'code'=>$country->iso_code_2,
    );
    $data[] = $arr;
}

header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "ok",
            'count' => $number,
            "countries" => $data,
));
exit();
=======
<?php
require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if(!get_option('fruity_feed_option')) die;

global $wpdb;
$country_table = $wpdb->prefix . 'toe_countries';
$countries = $wpdb->get_results("select * from  $country_table");


$data = array();
$number = count($countries);

foreach ($countries as $country) {
    $arr = array(
        'id'=>$country->id,
        'name'=>$country->name,
        'code'=>$country->iso_code_2,
    );
    $data[] = $arr;
}

header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "ok",
            'count' => $number,
            "countries" => $data,
));
exit();
>>>>>>> 866a2a89f634068fa942e1ff7981c15ced361c1e
