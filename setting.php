<?php 
    $error_str = '';$fruity_error = FALSE;
    if(isset($_POST['submit'])){
        $number_post = $_POST['number_post'];
        $order_type = $_POST['order_type'];
//        $feed_title = $_POST['feed_title'];
//        $feed_link = $_POST['feed_link'];
//        $feed_email = $_POST['feed_email'];
//        $feed_desciption = $_POST['feed_description'];
        if(!is_numeric($number_post) || strlen($number_post)==0){
            $error_str = 'Number post is invalid';
            $fruity_error = TRUE;
        }
        if(!$fruity_error){
            update_option('fruity_feed_post_number', $number_post);
            update_option('fruity_feed_order_type', $order_type);
//            update_option('fruity_feed_title', $feed_title);
//            update_option('fruity_feed_link', $feed_link);
//            update_option('fruity_feed_email', $feed_email);
//            update_option('fruity_feed_desciption', $feed_desciption);
            $error_str = 'Settings saved';
        }
    }
    $number_post_show = get_option('fruity_feed_post_number');
    $order_type_show = get_option('fruity_feed_order_type');
//    $feed_title_show = get_option('fruity_feed_title');
//    $feed_link_show = get_option('fruity_feed_link');
//    $feed_email_show = get_option('fruity_feed_email');
//    $feed_desciption_show = get_option('fruity_feed_desciption');
?>
<div class="wrap">
    <div id="icon-themes" class="icon32"></div>  
    <h2>Shopping Platform API for Mobile Application</h2><hr>   
    
    <?php if(!empty($error_str)){?>
    <div class="updated settings-error" id="setting-error-settings_updated"> 
        <p><strong><?php echo $error_str?></strong></p>
    </div>
    <?php } ?>

    <table class="widefat">   
        <thead>
            <tr>
                <th>Name</th>
                <th>Link</th>
            </tr>
        </thead>

        <tr class="quynh_tr">
            <td>Post feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('feed.php', __FILE__) ?>"><?php echo plugins_url('feed.php', __FILE__) ?></a></td>
        </tr>

        <tr class="quynh_tr">
            <td>Categories feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('categories-feed.php', __FILE__) ?>"><?php echo plugins_url('categories-feed.php', __FILE__) ?></a></td>
        </tr>
        
        <tr class="quynh_tr">
            <td>Hot feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('hot-feed.php', __FILE__) ?>"><?php echo plugins_url('hot-feed.php', __FILE__) ?></a></td>
        </tr>
    
        <tr class="quynh_tr">
           <td>Shop-Add cart feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/addcart-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/addcart-shop.php', __FILE__) ?></a></td>
        </tr>
 
        <tr class="quynh_tr">
		<td>Shop-Add item feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/additem-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/additem-shop.php', __FILE__) ?></a></td>
        </tr>
    
 <tr class="quynh_tr">
            <td>Shop-Banner feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/banner-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/banner-shop.php', __FILE__) ?></a></td>
        </tr>

        <tr class="quynh_tr">
            <td>Shop-Category feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/categories-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/categories-shop.php', __FILE__) ?></a></td>
        </tr>

    <tr class="quynh_tr">
            <td>Shop-Change password feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/changepass-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/changepass-shop.php', __FILE__) ?></a></td>
        </tr>
        
        
        <tr class="quynh_tr">
            <td>Shop-Comment feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/comment-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/comment-shop.php', __FILE__) ?></a></td>
        </tr>
		
		 <tr class="quynh_tr">
            <td>Shop-Country feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/country-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/country-shop.php', __FILE__) ?></a></td>
			</tr>

 <tr class="quynh_tr">
            <td>Shop-Facebook feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/facebook-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/facebook-shop.php', __FILE__) ?></a></td>
			</tr>

			 <tr class="quynh_tr">
            <td>Shop-Forgot password feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/forgot-pass.php', __FILE__) ?>"><?php echo plugins_url('/shop/forgot-pass.php', __FILE__) ?></a></td>

			</tr>

 <tr class="quynh_tr">
            <td>Shop-History feed</td>
            <td><a target="_blank" href="<?php echo plugins_url('/shop/history-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/history-shop.php', __FILE__) ?></a></td>
			</tr>


		 <tr class="quynh_tr">
		 <td>Shop-Comment list feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/list-comment-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/list-comment-shop.php', __FILE__) ?></a></td>
				 </tr>
		 <tr class="quynh_tr">
		 <td>Shop-List feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/list-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/list-shop.php', __FILE__) ?></a></td>
				 </tr>
		 <tr class="quynh_tr">
		 <td>Shop-Login feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/login-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/login-shop.php', __FILE__) ?></a></td>
				 </tr>
		 <tr class="quynh_tr">
		 <td>Shop-Other feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/other-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/other-shop.php', __FILE__) ?></a></td>
				 </tr>
		 <tr class="quynh_tr">
		 <td>Shop-Product feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/product-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/product-shop.php', __FILE__) ?></a></td>
				 </tr>
		 <tr class="quynh_tr">
		 <td>Shop-Register feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/register-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/register-shop.php', __FILE__) ?></a></td>
				</tr>
		 <tr class="quynh_tr">
		 <td>Shop-Search feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/search-shop.php', __FILE__) ?>"><?php echo plugins_url('/shop/search-shop.php', __FILE__) ?></a></td>
        </tr>
 <tr class="quynh_tr">
 <td>Shop-Update profile feed</td>
			     <td><a target="_blank" href="<?php echo plugins_url('/shop/update-profile.php', __FILE__) ?>"><?php echo plugins_url('/shop/update-profile.php', __FILE__) ?></a></td>
				 </tr>
    </table>

    <div class='icon32' id='icon-options-general'></div>  
    <h2>Display Setting</h2><hr> 
    <form action="" method="POST" name="frm">
        <table class="widefat">   
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Setting</th>
                </tr>
            </thead>
            <tr class="quynh_tr">
                <td width="25%">Number post:</td>
                <td><input type="text" maxlength="30" name="number_post" value="<?php echo ($number_post_show)?$number_post_show:20?>"></td>
            </tr>

            <tr class="quynh_tr">
                <td>Order type</td>
                <td>
                    <select name="order_type" style="width: 135px">
                        <option value="DESC">DESC</option>
                        <option <?php if($order_type_show == 'ASC')echo 'selected="selected"';?> value="ASC">ASC</option>
                    </select>
                </td>
            </tr>
            
<!--            <tr class="quynh_tr">
                <td>Feed title</td>
                <td><input class="regular-text ltr" type="text" maxlength="100" name="feed_title" value="<?php echo ($feed_title_show)?$feed_title_show:'Fruity'?>"></td>

            </tr>
            
            <tr class="quynh_tr">
                <td>Feed link</td>
                <td><input class="regular-text ltr" type="text" maxlength="200" name="feed_link" value="<?php echo ($feed_link_show)?$feed_link_show:'phattrienungdung.com'?>"></td>
            </tr>
            
            <tr class="quynh_tr">
                <td>Feed email</td>
                <td><input class="regular-text ltr" type="text" maxlength="200" name="feed_email" value="<?php echo ($feed_email_show)?$feed_email_show:'example@gmail.com'?>"></td>
            </tr>
            
            <tr class="quynh_tr">
                <td>Feed description</td>
                <td><input class="regular-text ltr" type="text" maxlength="200" name="feed_description" value="<?php echo ($feed_desciption_show)?$feed_desciption_show:'developed by phattrienungdung.com'?>"></td>
            </tr>-->

            <tr class="quynh_tr">
                <td><input  type="submit" value="Save changes" class="button button-primary" id="submit" name="submit">
                </td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
