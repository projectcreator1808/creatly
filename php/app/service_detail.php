<?php
global $match;
if (!isset($match['params']['id'])) {
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit;
}

$post_id = $match['params']['id'];
update_serviceview($post_id);

$num_rows = ORM::for_table($config['db']['pre'] . 'post')
    ->where('id', $post_id)
    ->count();
$item_custom = array();
$item_custom_textarea = array();
$item_checkbox = array();

if ($num_rows > 0) {
    $info = ORM::for_table($config['db']['pre'] . 'post')
        ->table_alias('p')
        ->select('p.*')
        ->select('u.name', 'user_name')
        ->select('u.username', 'username')
        ->select('u.image', 'user_image')
        ->select('u.tagline', 'user_tagline')
        ->select('u.created_at', 'user_joined')
        ->inner_join($config['db']['pre'] . 'user', array('p.user_id', '=', 'u.id'), 'u')
        ->where('p.id', $post_id)
        ->find_one();

    $post_id = $info['id'];
    $item_title = $info['title'];
    $item_status = $info['status'];
    $item_description = $info['description'];
    $item_image = get_post_option($post_id,'images');
    $item_created_at = timeAgo($info['created_at']);
    $item_updated_at = timeago($info['updated_at']);
    $gig_average_rating = gig_averageRating($post_id);

    $item_user_id = $info['user_id'];
    $user_name = $info['username'];
    $user_fullname = $info['user_name'];
    $user_image = $info['user_image'];
    $user_tagline = $info['user_tagline'];
    $user_joined = date("d-M-Y",strtotime($info['user_joined']));
    $user_link = $link['PROFILE'] . '/' . $info['username'];

    $pro_url = create_slug($item_title);
    $item_link = $link['SERVICE'] . '/' . $post_id . '/' . $pro_url;

    $item_catid = $info['category'];
    $get_main = get_maincat_by_id($info['category']);
    $item_category = $get_main['cat_name'];
    $item_catlink = $link['SEARCH_SERVICES'] . '/' . $get_main['slug'];

    $get_sub = $item_sub_category = $item_subcatlink = null;
    if (!empty($info['sub_category'])) {
        $get_sub = get_subcat_by_id($info['sub_category']);
        $item_sub_category = $get_sub['sub_cat_name'];
        $item_subcatlink = $link['SEARCH_SERVICES'] . '/' . $get_main['slug'] . '/' . $get_sub['slug'];
    }

    if ($info['tag'] != "") {
        $item_tag = explode(',', $info['tag']);
        $show_tag = 1;
    } else {
        $item_tag = "";
        $show_tag = 0;
    }

    $order_in_queue = ORM::for_table($config['db']['pre'].'orders')
        ->where(array('post_id' => $post_id, 'status' => 'progress'))
        ->count();

    $basic_plan_json = json_decode(get_post_option($post_id, 'basic_pricing_plan'),true);
    $standard_plan_json = json_decode(get_post_option($post_id, 'standard_pricing_plan'),true);
    $premium_plan_json = json_decode(get_post_option($post_id, 'premium_pricing_plan'),true);

    if(isset($_POST['order_service'])){
        /*These details save in session and get on payment sucecess*/
        if($_POST['order_service'] == "basic"){
            $plan_json = json_decode(get_post_option($post_id, 'basic_pricing_plan'),true);
        }elseif($_POST['order_service'] == "standard"){
            $plan_json = json_decode(get_post_option($post_id, 'standard_pricing_plan'),true);
        }elseif($_POST['order_service'] == "premium"){
            $plan_json = json_decode(get_post_option($post_id, 'premium_pricing_plan'),true);
        }else{
            error(__("Page Not Found"), __LINE__, __FILE__, 1);
            exit;
        }
        $title = $item_title;
        $trans_desc = "Order Service";
        $plan_id = $plan_json['id'];
        $amount = $plan_json['price'];
        $payment_type = "order_service";
        $access_token = uniqid();

        $_SESSION['quickad'][$access_token]['name'] = $title;
        $_SESSION['quickad'][$access_token]['amount'] = $amount;
        $_SESSION['quickad'][$access_token]['payment_type'] = $payment_type;
        $_SESSION['quickad'][$access_token]['trans_desc'] = $trans_desc;
        $_SESSION['quickad'][$access_token]['product_id'] = $post_id;
        $_SESSION['quickad'][$access_token]['plan_id'] = $plan_id;
        /*End These details save in session and get on payment sucecess*/

        $url = $link['PAYMENT']."/" . $access_token;
        header("Location: ".$url);
        exit;

    }
}else {
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit;
}

//Recommended Gigs
$result = ORM::for_table($config['db']['pre'] . 'post')
    ->table_alias('p')
    ->select_many_expr('p.*', 'u.username', 'u.name as fullname', 'u.image as user_image')
    ->where(array(
        'p.status' => 'active'
    ))
    ->inner_join($config['db']['pre'] . 'user', array('p.user_id', '=', 'u.id'), 'u')
    ->where_not_equal('p.id',$post_id)
    ->order_by_desc('p.id')
    ->limit(6)
    ->find_many();


$item = array();
if (count($result) > 0) {
    // output data of each row
    foreach ($result as $info1 ) {
        $item[$info1['id']]['id'] = $info1['id'];
        $item[$info1['id']]['status'] = $info1['status'];
        $item[$info1['id']]['title'] = $info1['title'];
        $item[$info1['id']]['price'] = price_format($info1['price']);
        $item[$info1['id']]['description'] = strlimiter(strip_tags($info1['description']),80);
        $item[$info1['id']]['cat_id'] = $info1['category'];
        $item[$info1['id']]['sub_cat_id'] = $info1['sub_category'];
        $item[$info1['id']]['tag'] = $info1['tag'];
        $images = get_post_option($info1['id'],'images');
        $images = explode(',', $images);
        $item[$info1['id']]['image'] = $images[0];
        $item[$info1['id']]['username'] = $info1['username'];
        $item[$info1['id']]['fullname'] = $info1['fullname'];
        $item[$info1['id']]['user_image'] = $info1['user_image'];
        $item[$info1['id']]['favorite'] = check_product_favorite($info1['id'],'gig');
        $item[$info1['id']]['rating'] = gig_averageRating($info1['id']);
        $pro_url = create_slug($info1['title']);
        $item[$info1['id']]['link'] = $link['SERVICE'].'/' . $info1['id'] . '/'.$pro_url;
    }
}
else
{
    //echo "0 results";
}
//Recommended Gigs
$postid = base64_url_encode($post_id);
$qcuserid = base64_url_encode($item_user_id);
$quickchat_url = $link['MESSAGE']."/?postid=$postid&posttype=gig&userid=$qcuserid";
HtmlTemplate::display('service_detail', array(
    'items' => $item,
    'item_id' => $post_id,
    'item_link' => $item_link,
    'item_title' => $item_title,
    'item_desc' => $item_description,
    'item_images' => explode(',',$item_image),
    'item_category' => $item_category,
    'item_sub_category' => $item_sub_category,
    'item_catlink' => $item_catlink,
    'item_subcatlink' => $item_subcatlink,
    'item_created' => $item_created_at,
    'item_updated' => $item_updated_at,
    'item_tag' => $item_tag,
    'show_tag' => $show_tag,
    'item_uid' => $item_user_id,
    'item_favorite' => check_product_favorite($post_id,'gig'),
    'item_ufullname' => $user_fullname,
    'item_username' => $user_name,
    'item_uimage' => $user_image,
    'item_utagline' => $user_tagline,
    'item_ujoined' => $user_joined,
    'item_ulink' => $user_link,
    'seller_rating' => averageRating($item_user_id,'user'),
    'gig_average_rating' => $gig_average_rating,
    'order_in_queue' => $order_in_queue,
    'basic_plan' => $basic_plan_json,
    'standard_plan' => $standard_plan_json,
    'premium_plan' => $premium_plan_json,
    'currency_sign' => $config['currency_sign'],
    'quickchat_url' => $quickchat_url,
    'language_direction' => get_current_lang_direction()
));
exit;
?>