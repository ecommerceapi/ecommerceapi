<?php

require('../../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;
$post_per_page = 25;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : '';
$promotion = isset($_GET['prom']) ? $_GET['prom'] : '';
$post_start = ($page - 1) * $post_per_page;
$slug = $type_sql = $promotion_sql1 = $promotion_sql2 = '';

global $wpdb;
$table_posts = $wpdb->prefix . 'posts';
$table_toe_product = $wpdb->prefix . 'toe_products';
$table_post_meta = $wpdb->prefix . 'postmeta';
$table_toe_currency = $wpdb->prefix . 'toe_currency';

if (isset($_GET['slug']))
    $slug = $_GET['slug'];
//var_dump($arg);die;
if(!empty($type)){
    switch ($type){
        case 'featured':
            $type_sql = ' AND tp.featured = 1 ';
            break;
        default :
            $type_sql = '';
    }
}

if(!empty($promotion)){
    switch ($promotion){
        case 1:
            $promotion_sql1 = " INNER JOIN $table_post_meta pmt ON pmt.post_id = p.ID ";
            $promotion_sql2 = " pmt.meta_key = 'fruity_feed_price' AND ";
            break;
        default :
            $type_sql = '';
    }
}

//get result
if (empty($slug))
    $posts = $wpdb->get_results("select * from   $table_posts p INNER JOIN $table_toe_product tp ON tp.post_id = p.ID $promotion_sql1 WHERE $promotion_sql2 post_type = 'product' $type_sql ORDER BY p.ID DESC LIMIT $post_start,$post_per_page");
	
else{
    $table_term = $wpdb->prefix . 'terms';
    $table_term_relationships = $wpdb->prefix . 'term_relationships';
    $posts = $wpdb->get_results("select * from   $table_posts p INNER JOIN $table_toe_product tp ON tp.post_id = p.ID  INNER JOIN $table_term_relationships rl ON rl.object_id = p.ID INNER JOIN $table_term t ON t.term_id = rl.term_taxonomy_id $promotion_sql1 WHERE $promotion_sql2 t.slug='$slug' AND post_type = 'product' $type_sql ORDER BY p.ID DESC LIMIT $post_start,$post_per_page");
    //$posts = $wpdb->get_results("select * from   $table_posts p INNER JOIN $table_term_relationships rl ON rl.object_id = p.ID INNER JOIN $table_term t ON t.term_id = rl.term_taxonomy_id WHERE t.slug = $slug");

}

$currency = $wpdb->get_results("SELECT * FROM  wp_toe_currency WHERE use_as_default = 1");
$value = $currency[0]->value;
$symbol = $currency[0]->symbol;


$data = array();
$i = 0;



foreach ($posts as $post) {
    $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
    	//$promotion = $wpdb->get_results("SELECT * FROM  wp_postmeta WHERE post_id = $post->ID and meta_key = 'fruity_feed_price'");
	//$prom_price = $promotion[0]->meta_value;

	//$promotion_price = isset($post->meta_value)?$post->meta_value:'';
	$promotion = get_post_meta($post->ID,'fruity_feed_price',TRUE);
	$promotion_price = $promotion*$value;
	$price = ($post->price)*$value;
    
	
    $arr = array(
        'id' => $post->ID,
        //'slug'=>$category->slug,
        'title' => get_the_title(),
        'description' => get_the_content(),
        'excerpt' => get_the_excerpt(),
        'price' => $price,
	'currency' => $symbol,
        'weight' => $post->weight,
        'sku' => $post->sku,
        'quantity' => $post->quantity,
        'featured' => $post->featured,
        'mark_as_new' => $post->mark_as_new,
        'width' => $post->width,
        'height' => $post->height,
        'length' => $post->length,
        'sort_order' => $post->sort_order,
        'promotion_price'=>$promotion_price,
        'thumbnail' => $image_url[0],
        'category_slug'=>$post->slug,
        'categories'=>get_the_product_category(),//get_the_category(),
        'post_date' => $post->post_date,
    );
    $data[] = $arr;
    $i++;
}

header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "ok",
            'count' => $i,
            "data" => $data,
));
exit();

/*
$arg = array(
    'post_type'=>'fruity_product',    
);
$slug = '';
if(isset($_GET['slug'])){
    $slug = $_GET['slug'];
    $arg['fruity_product_categories'] = $slug;
}
//var_dump($arg);die;

$data = array();
//$number = count($categories);
$i = 0;
$array1 = array('type'=>'text');
query_posts($arg);
if (have_posts()) : while (have_posts()) : the_post();
    $arr = array(
        'id'=>get_the_ID(),
        //'slug'=>$category->slug,
        'title'=>get_the_title(),
        'description'=>get_the_content(),
        'price'=> rwmb_meta('fruity_feed_price',$array1),
    );
    $data[] = $arr;
    $i++;
endwhile; 
endif;

header('Content-type: text/json');
echo json_encode(
        array(
            "status" => "ok",
            'count' => $i,
            "data" => $data,
));
exit();
 */