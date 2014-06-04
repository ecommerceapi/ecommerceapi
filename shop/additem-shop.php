<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$product_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$country_code = isset($_REQUEST['ct']) ? $_REQUEST['ct'] : 'VN';

//get list tax
global $wpdb;
$tax_total = 0;
$tax_table = $wpdb->prefix . 'toe_taxes';
$country_table = $wpdb->prefix . 'toe_countries';
$taxes = $wpdb->get_results("select * from  $tax_table");

//get country
$this_country = $wpdb->get_results("select * from  $country_table WHERE iso_code_2 = '$country_code'");
$this_country_id = $this_country[0]->id;
//get categories
$args = array(
    'post_type' => 'product',
    'p' => $product_id
);
$categories_list = $product_categories = array();
$myPosts = new WP_Query();
$myPosts->query($args);
while ($myPosts->have_posts()) : $myPosts->the_post();
    //the_title();
    $categories_list = (get_the_product_category());
endwhile;
//var_dump($categories_list);
foreach ($categories_list as $item) {
    $product_categories[] = $item->term_id;
}
foreach ($taxes as $item) {
    $arr = json_decode($item->data);
    $rate = $arr->rate;
    $country = $arr->country;
    $categories = $arr->categories;
    if (in_array($this_country_id, $country)) {
        $have_tax = FALSE;
        foreach ($product_categories as $item) {
            if (in_array($item, $categories)) {
                $have_tax = TRUE;
                break;
            }
        }
        if ($have_tax)
            $tax_total += $rate; //echo $tax_total,'<br/>';
    }
}
header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "ok",
            'product_id' => $product_id,
            'tax' => $tax_total,
));
exit();
