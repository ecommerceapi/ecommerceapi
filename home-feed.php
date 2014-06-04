<?php
require('../../../wp-blog-header.php');
header("HTTP/1.1 200 OK");

if (!get_option('fruity_feed_option'))
    die;

$number_post_show = get_option('fruity_feed_post_number');
$numposts = $number_post_show?$number_post_show:20;

$order_type_show = get_option('fruity_feed_order_type');
$order = $order_type_show?$order_type_show:'DESC';

$title_show = get_option('fruity_feed_title');
$title = $title_show?$title_show:'Fruity';

$link_show = get_option('fruity_feed_link');
$link = $link_show?$link_show:'projectemplate.com';

$email_show = get_option('fruity_feed_email');
$email = $email_show?$email_show:'example@gmail.com';

$description_show = get_option('fruity_feed_desciption');
$description = $description_show?$description_show:'developed by projectemplate.com';

function fruity_rss_date($timestamp = null) {
    $timestamp = ($timestamp == null) ? time() : $timestamp;
    echo date(DATE_RSS, $timestamp);
}

function fruity_rss_text_limit($string, $length, $replacer = '...') {
    $string = strip_tags($string);
    if (strlen($string) > $length)
        return (preg_match('/^(.*)\W.*$/', substr($string, 0, $length + 1), $matches) ? $matches[1] : substr($string, 0, $length)) . $replacer;
    return $string;
}
$arg = array(
    'order'=>$order,
    'showposts'=>$numposts,
);
$posts = query_posts($arg);

header("Content-Type: application/rss+xml; charset=UTF-8");
echo '<?xml version="1.0"?>';
?>
<rss version="2.0">
    <channel>
        <title><?php echo $title?></title>
        <link>http://<?php echo $link ?></link>
        <description>Home - <?php echo $description?></description>  
        <language>en-us</language>
        <pubDate><?php fruity_rss_date(); ?></pubDate>
        <lastBuildDate><?php fruity_rss_date(); ?></lastBuildDate>
        <managingEditor><?php echo $email?></managingEditor>
<?php foreach ($posts as $post) { ?>
            <item>
                <title><?php the_title_rss(); ?></title>
                <link><?php echo get_permalink($post->ID); ?></link>
                <image><?php
                if (has_post_thumbnail()) {
                    $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
                    echo $image_url[0];}
                ?></image>
                <description><?php echo '<![CDATA[' . $post->post_content. ']]>'; ?></description>
                <pubDate><?php fruity_rss_date(strtotime($post->post_date_gmt)); ?></pubDate>
                <guid><?php echo get_permalink($post->ID); ?></guid>
            </item>
<?php } ?>
    </channel>
</rss>