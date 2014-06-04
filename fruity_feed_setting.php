<<<<<<< HEAD
<?php
/*
  Plugin Name: Shopping Setting
  Description: This plugin for feed setting
  Version: 1.0
 */


register_deactivation_hook(__FILE__, 'fruity_feed_deactive');

function fruity_feed_deactive() {
    //do something
    delete_option('fruity_feed_option');
}

//phan admin
add_action('admin_menu', 'create_feed_setting');

function create_feed_setting() {
    //add option feed
    update_option('fruity_feed_option', 1);
    //add menu
    add_menu_page('Shopping Platform API', 'Shopping Setting', 4, 'fruity-feed/setting.php', '', plugins_url('/feed.png', __FILE__));
    //add_submenu_page('fruity-feed/setting.php', 'Q Setting', 'Setting', 4, 'setting/setting.php', '');
    //add product custom post type
    //register_product();
}

add_action('admin_head-edit-tags.php', 'wpse_58799_remove_parent_category');

function wpse_58799_remove_parent_category() {
    // don't run in the Tags screen
    if ('category' != $_GET['taxonomy'])
        return;

    // Screenshot_1 = New Category
    // http://example.com/wp-admin/edit-tags.php?taxonomy=category
    $parent = 'parent()';

    // Screenshot_2 = Edit Category
    // http://example.com/wp-admin/edit-tags.php?action=edit&taxonomy=category&tag_ID=17&post_type=post
    if (isset($_GET['action']))
        $parent = 'parent().parent()';
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($)
        {     
            $('label[for=parent]').<?php echo $parent; ?>.remove();       
        });
    </script>
    <?php
}







function register_fruity_banner() {
    $labels = array(
        'name' => __('Banner'),
        'singular_name' => __('fruity_banner'),
        'add_new' => _x('Add New Banner', 'Banner'),
        'add_new_item' => __('Add New Banner'),
        'edit_item' => __('Edit Banner'),
        'new_item' => __('New Banner'),
        'view_item' => __('View Banner'),
        'search_items' => __('Search Banner'),
        'not_found' => __('No Banner Found'),
        'not_found_in_trash' => __('No Banner found in trash'),
        'parent_item_colon' => '',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => __('fruity_banner')),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        //'menu_position' => 7,
        'menu_icon' => get_stylesheet_directory_uri() . '/images/slides.png',
        'supports' => array('title', 'thumbnail', 'editor')
    );
    register_post_type(__('fruity_banner'), $args);
}

add_action('init', 'register_fruity_banner');



function include_attribute_category() {
    //require_once('category/fields-category.php');
    require_once('meta-box/inc/classes/meta-box.php');
    require_once('meta-box/meta-box.php');

     $prefix = 'fruity_feed_';
    
    $meta_feed[] = array(
        'id' => 'hire-options',
        'title' => 'Shop Options',
        'pages' => array('product'),
        'desc' => '',
        'context' => 'normal',
        'fields' => array(
            //kind of select
            array(
                'name' => 'Promotion Price',
                'id' => $prefix . 'price',
                'type' => 'text', // select box
                'desc' => 'Type a price for promotion product.',
                'std' => '0', //default value
            ),
            /*array(
                'name' => 'No promotion',
                'id' => $prefix . 'no_promotion',
                'type' => 'checkbox', // select box
                'desc' => 'Check it for remove promotion.',
                'std' => 0,
            ),*/
        )
    );
    $meta_feed[] = array(
        'id' => 'hire-options',
        'title' => 'Banner Options',
        'pages' => array('fruity_banner'),
        'desc' => '',
        'context' => 'normal',
        'fields' => array(
            //kind of select
            array(
                'name' => 'Price',
                'id' => $prefix . 'price_banner',
                'type' => 'text', // select box
                'desc' => 'Type a price for this textbox.',
                'std' => '0', //default value
            ),
		
	    array(
                'name' => 'Promotion Price',
                'id' => $prefix . 'promotion_price_banner',
                'type' => 'text', // select box
                'desc' => 'Type a promotion price for this textbox.',
                'std' => '0', //default value
            ),

            array(
                'name' => 'Product ID',
                'id' => $prefix . 'id_banner',
                'type' => 'text', // select box
                'desc' => 'Type a post ID for this textbox.',
                'std' => '0', //default value
            ),
        )
    );
    $meta_feed[] = array(
        'id' => 'banner-options',
        'title' => 'Banner Options',
        'pages' => array('fruity_banner'),
        'desc' => '',
        'context' => 'normal',
        'fields' => array(
            //kind of select
            array(
                'name' => 'Image',
                'id' => $prefix . 'image_banner',
                'type' => 'image', // select box
                'desc' => 'Select a image for banner.',
                //'std' => '100', //default value
            ),
        )
    );
    foreach ($meta_feed as $post) {
        $my_hire_box = new RW_meta_box($post);
    }
}

add_action('init', 'include_attribute_category');

function check_promotion( ) {
    if(isset($_REQUEST['action'])){

        if(isset($_REQUEST['fruity_feed_no_promotion'])){
            //remove post meta data
        }
    }
}
add_action( 'save_post', 'check_promotion' );

function register_fruity_product() {
    $labels = array(
        'name' => __('Product'),
        'singular_name' => __('fruity_product'),
        'add_new' => _x('Add New Product', 'Product'),
        'add_new_item' => __('Add New Product'),
        'edit_item' => __('Edit Product'),
        'new_item' => __('New Product'),
        'view_item' => __('View Product'),
        'search_items' => __('Search Product'),
        'not_found' => __('No Product Found'),
        'not_found_in_trash' => __('No Product found in trash'),
        'parent_item_colon' => '',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => __('fruity_product')),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        //'menu_position' => 7,
        'menu_icon' => get_stylesheet_directory_uri() . '/images/slides.png',
        'supports' => array('title', 'thumbnail', 'editor')
    );
    register_post_type(__('fruity_product'), $args);
}
//add_action('init', 'register_fruity_product');



function register_fruity_product_category_taxonomy() {

    $labels = array('name' => _x('Category', 'taxonomy general name'),
        'singular_name' => _x('vehicle_categories', 'taxonomy singular name'),
        'search_items' => __('Search Category'),
        'all_items' => __('All Views'),
        'parent_item' => __('Parent Category'),
        'parent_item_colon' => __('Parent Category:'),
        'edit_item' => __('Edit Category'),
        'update_item' => __('Update Category'),
        'add_new_item' => __('Add New Category'),
        'new_item_name' => __('New Category Name'),
    );

    register_taxonomy('fruity_product_categories', array('fruity_product'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'fruity_product_categories'),
    ));
}

//add_action('init', 'register_fruity_product_category_taxonomy', 0);




function create_login_token_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'login_token';
    $sql = "CREATE TABLE IF NOT EXISTS `$table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);

    $toe_orders_items = $wpdb->prefix . 'toe_orders_items';
    $sql2 = "ALTER TABLE  `$toe_orders_items` ADD  `tax_total` FLOAT NULL AFTER  `product_params`";
    //dbDelta($sql2);
    $wpdb->query($sql2);
}
add_action('init', 'create_login_token_table', 0);


function get_the_product_category( $id = false ) {
	$categories = get_the_terms( $id, 'products_categories' );
	if ( ! $categories || is_wp_error( $categories ) )
		$categories = array();

	$categories = array_values( $categories );

	foreach ( array_keys( $categories ) as $key ) {
		_make_cat_compat( $categories[$key] );
	}

	// Filter name is plural because we return alot of categories (possibly more than #13237) not just one
	return apply_filters( 'get_the_categories', $categories );
}

function custom_register_new_user( $user_login, $user_email, $password ) {
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.' ) );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
	}

	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
		return $errors;

	//$user_pass = wp_generate_password( 12, false);
        $user_pass = $password;
	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you&hellip; please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

	wp_new_user_notification( $user_id, $user_pass );

	return $user_id;
}
=======
<?php
/*
  Plugin Name: Shopping Setting
  Description: This plugin for feed setting
  Version: 1.0
 */


register_deactivation_hook(__FILE__, 'fruity_feed_deactive');

function fruity_feed_deactive() {
    //do something
    delete_option('fruity_feed_option');
}

//phan admin
add_action('admin_menu', 'create_feed_setting');

function create_feed_setting() {
    //add option feed
    update_option('fruity_feed_option', 1);
    //add menu
    add_menu_page('Shopping Platform API', 'Shopping Setting', 4, 'fruity-feed/setting.php', '', plugins_url('/feed.png', __FILE__));
    //add_submenu_page('fruity-feed/setting.php', 'Q Setting', 'Setting', 4, 'setting/setting.php', '');
    //add product custom post type
    //register_product();
}

add_action('admin_head-edit-tags.php', 'wpse_58799_remove_parent_category');

function wpse_58799_remove_parent_category() {
    // don't run in the Tags screen
    if ('category' != $_GET['taxonomy'])
        return;

    // Screenshot_1 = New Category
    // http://example.com/wp-admin/edit-tags.php?taxonomy=category
    $parent = 'parent()';

    // Screenshot_2 = Edit Category
    // http://example.com/wp-admin/edit-tags.php?action=edit&taxonomy=category&tag_ID=17&post_type=post
    if (isset($_GET['action']))
        $parent = 'parent().parent()';
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($)
        {     
            $('label[for=parent]').<?php echo $parent; ?>.remove();       
        });
    </script>
    <?php
}







function register_fruity_banner() {
    $labels = array(
        'name' => __('Banner'),
        'singular_name' => __('fruity_banner'),
        'add_new' => _x('Add New Banner', 'Banner'),
        'add_new_item' => __('Add New Banner'),
        'edit_item' => __('Edit Banner'),
        'new_item' => __('New Banner'),
        'view_item' => __('View Banner'),
        'search_items' => __('Search Banner'),
        'not_found' => __('No Banner Found'),
        'not_found_in_trash' => __('No Banner found in trash'),
        'parent_item_colon' => '',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => __('fruity_banner')),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        //'menu_position' => 7,
        'menu_icon' => get_stylesheet_directory_uri() . '/images/slides.png',
        'supports' => array('title', 'thumbnail', 'editor')
    );
    register_post_type(__('fruity_banner'), $args);
}

add_action('init', 'register_fruity_banner');



function include_attribute_category() {
    //require_once('category/fields-category.php');
    require_once('meta-box/inc/classes/meta-box.php');
    require_once('meta-box/meta-box.php');

     $prefix = 'fruity_feed_';
    
    $meta_feed[] = array(
        'id' => 'hire-options',
        'title' => 'Shop Options',
        'pages' => array('product'),
        'desc' => '',
        'context' => 'normal',
        'fields' => array(
            //kind of select
            array(
                'name' => 'Promotion Price',
                'id' => $prefix . 'price',
                'type' => 'text', // select box
                'desc' => 'Type a price for promotion product.',
                'std' => '0', //default value
            ),
            /*array(
                'name' => 'No promotion',
                'id' => $prefix . 'no_promotion',
                'type' => 'checkbox', // select box
                'desc' => 'Check it for remove promotion.',
                'std' => 0,
            ),*/
        )
    );
    $meta_feed[] = array(
        'id' => 'hire-options',
        'title' => 'Banner Options',
        'pages' => array('fruity_banner'),
        'desc' => '',
        'context' => 'normal',
        'fields' => array(
            //kind of select
            array(
                'name' => 'Price',
                'id' => $prefix . 'price_banner',
                'type' => 'text', // select box
                'desc' => 'Type a price for this textbox.',
                'std' => '0', //default value
            ),
		
	    array(
                'name' => 'Promotion Price',
                'id' => $prefix . 'promotion_price_banner',
                'type' => 'text', // select box
                'desc' => 'Type a promotion price for this textbox.',
                'std' => '0', //default value
            ),

            array(
                'name' => 'Product ID',
                'id' => $prefix . 'id_banner',
                'type' => 'text', // select box
                'desc' => 'Type a post ID for this textbox.',
                'std' => '0', //default value
            ),
        )
    );
    $meta_feed[] = array(
        'id' => 'banner-options',
        'title' => 'Banner Options',
        'pages' => array('fruity_banner'),
        'desc' => '',
        'context' => 'normal',
        'fields' => array(
            //kind of select
            array(
                'name' => 'Image',
                'id' => $prefix . 'image_banner',
                'type' => 'image', // select box
                'desc' => 'Select a image for banner.',
                //'std' => '100', //default value
            ),
        )
    );
    foreach ($meta_feed as $post) {
        $my_hire_box = new RW_meta_box($post);
    }
}

add_action('init', 'include_attribute_category');

function check_promotion( ) {
    if(isset($_REQUEST['action'])){

        if(isset($_REQUEST['fruity_feed_no_promotion'])){
            //remove post meta data
        }
    }
}
add_action( 'save_post', 'check_promotion' );

function register_fruity_product() {
    $labels = array(
        'name' => __('Product'),
        'singular_name' => __('fruity_product'),
        'add_new' => _x('Add New Product', 'Product'),
        'add_new_item' => __('Add New Product'),
        'edit_item' => __('Edit Product'),
        'new_item' => __('New Product'),
        'view_item' => __('View Product'),
        'search_items' => __('Search Product'),
        'not_found' => __('No Product Found'),
        'not_found_in_trash' => __('No Product found in trash'),
        'parent_item_colon' => '',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => __('fruity_product')),
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        //'menu_position' => 7,
        'menu_icon' => get_stylesheet_directory_uri() . '/images/slides.png',
        'supports' => array('title', 'thumbnail', 'editor')
    );
    register_post_type(__('fruity_product'), $args);
}
//add_action('init', 'register_fruity_product');



function register_fruity_product_category_taxonomy() {

    $labels = array('name' => _x('Category', 'taxonomy general name'),
        'singular_name' => _x('vehicle_categories', 'taxonomy singular name'),
        'search_items' => __('Search Category'),
        'all_items' => __('All Views'),
        'parent_item' => __('Parent Category'),
        'parent_item_colon' => __('Parent Category:'),
        'edit_item' => __('Edit Category'),
        'update_item' => __('Update Category'),
        'add_new_item' => __('Add New Category'),
        'new_item_name' => __('New Category Name'),
    );

    register_taxonomy('fruity_product_categories', array('fruity_product'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'fruity_product_categories'),
    ));
}

//add_action('init', 'register_fruity_product_category_taxonomy', 0);




function create_login_token_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'login_token';
    $sql = "CREATE TABLE IF NOT EXISTS `$table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);

    $toe_orders_items = $wpdb->prefix . 'toe_orders_items';
    $sql2 = "ALTER TABLE  `$toe_orders_items` ADD  `tax_total` FLOAT NULL AFTER  `product_params`";
    //dbDelta($sql2);
    $wpdb->query($sql2);
}
add_action('init', 'create_login_token_table', 0);


function get_the_product_category( $id = false ) {
	$categories = get_the_terms( $id, 'products_categories' );
	if ( ! $categories || is_wp_error( $categories ) )
		$categories = array();

	$categories = array_values( $categories );

	foreach ( array_keys( $categories ) as $key ) {
		_make_cat_compat( $categories[$key] );
	}

	// Filter name is plural because we return alot of categories (possibly more than #13237) not just one
	return apply_filters( 'get_the_categories', $categories );
}

function custom_register_new_user( $user_login, $user_email, $password ) {
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.' ) );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
	}

	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
		return $errors;

	//$user_pass = wp_generate_password( 12, false);
        $user_pass = $password;
	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you&hellip; please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

	wp_new_user_notification( $user_id, $user_pass );

	return $user_id;
}
>>>>>>> 866a2a89f634068fa942e1ff7981c15ced361c1e
?>