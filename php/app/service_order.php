<?php
if(checkloggedin()) {
    update_lastactive();

    $ses_userdata = get_user_data($_SESSION['user']['username']);

    if($ses_userdata['user_type'] == 'user'){
        $where_array = array('p.user_id' => $_SESSION['user']['id']);
    }else{
        $where_array = array('o.user_id' => $_SESSION['user']['id']);
    }

    if (isset($_GET['id'])) {
        $where_array['o.post_id'] = $_GET['id'];
    }

    if (isset($_GET['status']) && $_GET['status'] != "all") {
        $where_array['o.status'] = $_GET['status'];
    }

    if (!isset($_GET['page']))
        $_GET['page'] = 1;

    $limit = 10;
    $page = $_GET['page'];
    $offset = ($page - 1) * $limit;
    $items = array();

    $orders = ORM::for_table($config['db']['pre'] . 'orders')
        ->table_alias('o')
        ->select_many_expr('o.*', 'p.id post_id', 'p.title post_title', 'u.username', 'u.name')
        ->where($where_array)
        ->join($config['db']['pre'] . 'post', array('o.post_id', '=', 'p.id'), 'p')
        ->left_outer_join($config['db']['pre'] . 'user', array('o.user_id', '=', 'u.id'), 'u')
        ->limit($limit)->offset($offset)
        ->find_many();

    $total = count($orders);
    if (!empty($orders)) {

        foreach($orders as $info){
            $items[$info['id']]['id'] = $info['id'];
            $items[$info['id']]['status'] = $info['status'];
            $items[$info['id']]['amount'] = price_format($info['amount']);
            $items[$info['id']]['buyer_id'] = $info['user_id'];
            $items[$info['id']]['buyer_name'] = $info['name'];
            $items[$info['id']]['buyer_username'] = $info['username'];
            $items[$info['id']]['post_id'] = $info['post_id'];
            $items[$info['id']]['title'] = $info['post_title'];
            $items[$info['id']]['plan_id'] = $info['plan_id'];
            $items[$info['id']]['cancel_reason'] = $info['cancel_reason'];
            $items[$info['id']]['created_at'] = date('d-M-Y', strtotime($info['created_at']));

            if($info['status'] == "completed"){
                if(rating_exist($info['id'],'gig')){
                    $rate = 0;
                }else{
                    $rate = 1;
                }
            }else{
                $rate = 0;
            }

            $items[$info['id']]['rated'] = $rate;
            if($rate == 0){
                if($_SESSION['user']['user_type'] == 'employer'){
                    $array = array('employer_id' => $_SESSION['user']['id'], 'rated_by' => 'user');
                }else{
                    $array = array('freelancer_id' => $_SESSION['user']['id'], 'rated_by' => 'employer');
                }
                $order_rating_count = ORM::for_table($config['db']['pre'].'reviews')
                    ->where(array(
                        'order_id' => $info['id'],
                        'post_type' =>'gig',
                    ))
                    ->where($array)
                    ->count();
                if($order_rating_count){
                    $order_rating = ORM::for_table($config['db']['pre'].'reviews')
                        ->where(array(
                            'order_id' => $info['id'],
                            'post_type' =>'gig',
                        ))
                        ->where($array)
                        ->find_one();
                    $items[$info['id']]['rating'] = number_format($order_rating['rating'],1);
                    $items[$info['id']]['comments'] = $order_rating['comments'];
                }else{
                    $items[$info['id']]['rating'] = '0';
                    $items[$info['id']]['comments'] = '';
                }

            }else{
                $items[$info['id']]['rating'] = '0';
                $items[$info['id']]['comments'] = '';
            }
            $images = explode(',', get_post_option($info['post_id'],'images'));
            $items[$info['id']]['image'] = $images[0];

            if($info['plan_id'] == "basic"){
                $plan_json = json_decode(get_post_option($info['post_id'], 'basic_pricing_plan'),true);
            }elseif($info['plan_id'] == "standard"){
                $plan_json = json_decode(get_post_option($info['post_id'], 'standard_pricing_plan'),true);
            }elseif($info['plan_id'] == "premium"){
                $plan_json = json_decode(get_post_option($info['post_id'], 'premium_pricing_plan'),true);
            }
            $items[$info['id']]['plan_name'] = $plan_json['name'];
            $delivery_time = $plan_json['delivery_time'];
            $items[$info['id']]['end_date'] = date('d-M-Y', strtotime($info['created_at']. ' + '.$delivery_time.' days'));

            $pro_url = create_slug($info['post_title']);
            $items[$info['id']]['link'] = $link['SERVICE'].'/' . $info['post_id'] . '/'.$pro_url;
        }

        $Pagelink = "";
        if(count($_GET) >= 1){
            $get = http_build_query($_GET);
            $Pagelink .= "?".$get;

            $pagging = pagenav($total,$page,$limit,$link['SERVICE_ORDERS'].$Pagelink,1);
        }else{
            $pagging = pagenav($total,$page,$limit,$link['SERVICE_ORDERS']);
        }

        //Print Template
        HtmlTemplate::display('service_order', array(
            'items' => $items,
            'pages' => $pagging,
            'totalitem' => $total
        ));
        exit;
    }
}
error(__("Page Not Found"), __LINE__, __FILE__, 1);
exit();