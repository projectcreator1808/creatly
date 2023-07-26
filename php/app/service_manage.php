<?php
if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}

if(isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 6;
}

if(isset($_GET['status']) && !empty($_GET['status'])){
    $status = $_GET['status'];
}else{
    $status = '';
}


if(!isset($_GET['order']))
    $order = "DESC";
else{
    if($_GET['order'] == ""){
        $order = "DESC";
    }else{
        $order = $_GET['order'];
    }
}

if(!isset($_GET['sort']))
    $sort = "p.id";
elseif($_GET['sort'] == "title")
    $sort = "title";
elseif($_GET['sort'] == "price")
    $sort = "price";
elseif($_GET['sort'] == "date")
    $sort = "created_at";
else
    $sort = "p.id";

$sorting = isset($_GET['sort']) ? $_GET['sort'] : "Newest";

if(checkloggedin()) {

    $keywords = isset($_GET['keywords']) ? str_replace("-"," ",$_GET['keywords']) : "";


    $where = '';
    if(isset($_GET['keywords']) && !empty($_GET['keywords'])){
        $where.= "AND (p.title LIKE '%$keywords%' or p.tag LIKE '%$keywords%') ";
    }

    if($status){
        $where.= "AND (p.status = '".$status."') ";
    }

    $sql = "SELECT p.* FROM `".$config['db']['pre']."post` p WHERE p.user_id = '".$_SESSION['user']['id']."' ";

    $total = mysqli_num_rows(mysqli_query($mysqli, "SELECT 1 FROM ".$config['db']['pre']."post as p 
        WHERE p.user_id = '".$_SESSION['user']['id']."' $where"));

    $query = "$sql $where ORDER BY $sort DESC LIMIT ".($page-1)*$limit.",$limit";

    $result = ORM::for_table($config['db']['pre'].'product')->raw_query($query)->find_many();
    $item = array();
    if ($result) {
        foreach ($result as $info)
        {
            $item[$info['id']]['id'] = $info['id'];
            $item[$info['id']]['status'] = $info['status'];
            $item[$info['id']]['title'] = $info['title'];
            $item[$info['id']]['price'] = price_format($info['price']);
            $item[$info['id']]['description'] = strlimiter(strip_tags($info['description']),80);
            $item[$info['id']]['cat_id'] = $info['category'];
            $item[$info['id']]['sub_cat_id'] = $info['sub_category'];
            $item[$info['id']]['tag'] = $info['tag'];
            $item[$info['id']]['views'] = thousandsCurrencyFormat(get_post_option($info['id'],'views'));
            $item[$info['id']]['created_at'] = date('d F, Y', strtotime($info['created_at']));
            $images = get_post_option($info['id'],'images');
            $images = explode(',', $images);
            $item[$info['id']]['image'] = $images[0];
            $item[$info['id']]['username'] = $info['username'];
            $item[$info['id']]['fullname'] = $info['fullname'];
            $item[$info['id']]['user_image'] = $info['user_image'];

            $item[$info['id']]['all_order'] = ORM::for_table($config['db']['pre'].'orders')
                ->where(array('post_id' => $info['id']))
                ->count();
            $item[$info['id']]['pending_order'] = ORM::for_table($config['db']['pre'].'orders')
                ->where(array('post_id' => $info['id'],'status' => 'progress'))
                ->count();

            $pro_url = create_slug($info['title']);
            $item[$info['id']]['link'] = $link['SERVICE'].'/' . $info['id'] . '/'.$pro_url;
        }
    }

    $Pagelink = "";
    if(count($_GET) >= 1){
        $get = http_build_query($_GET);
        $Pagelink .= "?".$get;

        $pagging = pagenav($total,$page,$limit,$link['MYSERVICES'].$Pagelink,1);
    }else{
        $pagging = pagenav($total,$page,$limit,$link['MYSERVICES']);
    }

    //Print Template
    HtmlTemplate::display('service_manage', array(
        'items' => $item,
        'pages' => $pagging,
        'limit' => $limit,
        'sort' => $sorting,
        'order' => $order,
        'keywords' => $keywords,
        'totalitem' => $total
    ));
    exit;
}
else{
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit();
}
?>
