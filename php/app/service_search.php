<?php
if(!isset($_GET['page']))
    $page_number = 1;
else{
    $page_number = $_GET['page'];
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
    $sort = "id";
elseif($_GET['sort'] == "title")
    $sort = "title";
elseif($_GET['sort'] == "price")
    $sort = "price";
elseif($_GET['sort'] == "date")
    $sort = "created_at";
else
    $sort = "id";

$limit = isset($_GET['limit']) ? $_GET['limit'] : 9;
$filter = isset($_GET['filter']) ? $_GET['filter'] : "";
$sorting = isset($_GET['sort']) ? $_GET['sort'] : "Newest";
$budget = isset($_GET['budget']) ? $_GET['budget'] : "";
$keywords = isset($_GET['keywords']) ? str_replace("-"," ",$_GET['keywords']) : "";

$category = "";
$subcat = "";

if(isset($_GET['subcat']) && !empty($_GET['subcat'])){

    if(is_numeric($_GET['subcat'])){
        if(check_sub_category_exists($_GET['subcat'])){
            $subcat = $_GET['subcat'];
        }
    }else{
        $subcat = get_subcategory_id_by_slug($_GET['subcat']);
    }
}
if(isset($_GET['cat']) && !empty($_GET['cat'])){
    if(is_numeric($_GET['cat'])){
        if(check_category_exists($_GET['cat'])){
            $category = $_GET['cat'];
        }
    }else{
        $category = get_category_id_by_slug($_GET['cat']);
    }
}

if($subcat != ''){
    $custom_fields = get_customFields_by_catid('default', '',$subcat,false);
}else if($category != ''){
    $custom_fields = get_customFields_by_catid('default', $category,'',false);
}else{
    $custom_fields = get_customFields_by_catid('default', '','',false);
}

$custom = array();
if(isset($_GET['custom']) && !empty($_GET['custom'])){
    $custom = $_GET['custom'];
}

$total = 0;

$where = '';
$order_by_keyword = '';
if(isset($_GET['keywords']) && !empty($_GET['keywords'])){
    $where.= "AND (p.title LIKE '%$keywords%' or p.tag LIKE '%$keywords%') ";
    $order_by_keyword = "(CASE
    WHEN p.title = '$keywords' THEN 1
    WHEN p.title LIKE '$keywords%' THEN 2
    WHEN p.title LIKE '%$keywords%' THEN 3
    WHEN p.tag = '$keywords' THEN 4
    WHEN p.tag LIKE '$keywords%' THEN 5
    WHEN p.tag LIKE '%$keywords%' THEN 6
    ELSE 7
  END),";
}
$order_by = $order_by_keyword." $sort $order";

if(isset($category) && !empty($category)){
    $where.= "AND (p.category = '$category') ";
}

if(isset($_GET['subcat']) && !empty($_GET['subcat'])){
    $where.= "AND (p.sub_category = '$subcat') ";
}

if (isset($_GET['range1']) && $_GET['range1'] != '') {
    $range1 = str_replace('.', '', $_GET['range1']);
    $range2 = str_replace('.', '', $_GET['range2']);
    $where.= ' AND (p.price BETWEEN '.$range1.' AND '.$range2.')';
} else {
    $range1 = "";
    $range2 = "";
}

if(isset($_GET['custom'])) {
    $whr_count = 1;
    $custom_where = "";
    $custom_join = "";
    foreach ($_GET['custom'] as $key => $value) {
        if (empty($value)) {
            unset($_GET['custom'][$key]);
        }
        if (!empty($_GET['custom'])) {
            // custom value is not empty.

            if ($key != "" && $value != "") {
                $c_as = "c".$whr_count;
                $custom_join .= " JOIN `".$config['db']['pre']."custom_data` AS $c_as ON $c_as.product_id = p.id AND `$c_as`.`field_id` = '$key' ";

                if (is_array($value)) {
                    $custom_where = " AND ( ";
                    $cond_count = 0;
                    foreach ($value as $val) {
                        if ($cond_count == 0) {
                            $custom_where .= " find_in_set('$val',$c_as.field_data) <> 0 ";
                        } else {
                            $custom_where .= " AND find_in_set('$val',$c_as.field_data) <> 0 ";
                        }
                        $cond_count++;
                    }
                    $custom_where .= " )";
                }else{
                    $custom_where .= " AND `$c_as`.`field_data` = '$value' ";
                }

                $whr_count++;
            }
        }
    }
    if($custom_where != "")
        $where .= $custom_where;

    if (!empty($_GET['custom'])) {
        $sql = "SELECT DISTINCT p.*
FROM `".$config['db']['pre']."post` AS p
$custom_join
 WHERE status = 'active' ";
    }else{
        $sql = "SELECT DISTINCT p.*
FROM `".$config['db']['pre']."post` AS p
 WHERE status = 'active' ";
    }
    $q = "$sql $where";
    $totalWithoutFilter = mysqli_num_rows(mysqli_query($mysqli, $q));
}
else{
    $totalWithoutFilter = mysqli_num_rows(mysqli_query($mysqli, "SELECT 1 FROM ".$config['db']['pre']."post as p where p.status = 'active' $where"));
}

if(isset($_GET['custom']))
{
    if (!empty($_GET['custom'])) {
        $sql = "SELECT DISTINCT p.*
FROM `".$config['db']['pre']."post` AS p
$custom_join
 WHERE p.status = 'active' ";
    }else{
        $sql = "SELECT DISTINCT p.*
FROM `".$config['db']['pre']."post` AS p
 WHERE p.status = 'active' ";
    }

    $query =  $sql . " $where ORDER BY $sort $order LIMIT ".($page_number-1)*$limit.",$limit";
    $total = mysqli_num_rows(mysqli_query($mysqli, "$sql $where"));

}
else{
    $total = mysqli_num_rows(mysqli_query($mysqli,
        "SELECT 1 FROM ".$config['db']['pre']."post as p where (status = 'active') $where"));

    $query = "SELECT p.*,u.username,u.name as fullname ,u.image as user_image FROM `".$config['db']['pre']."post` as p
    INNER JOIN `".$config['db']['pre']."user` as u ON u.id = p.user_id
     where (p.status = 'active') $where ORDER BY $order_by LIMIT ".($page_number-1)*$limit.",$limit";

}
$count = 0;
$noresult_id = "";
$item = array();
$result = $mysqli->query($query);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($info = mysqli_fetch_assoc($result)) {
        $item[$info['id']]['id'] = $info['id'];
        $item[$info['id']]['status'] = $info['status'];
        $item[$info['id']]['title'] = $info['title'];
        $item[$info['id']]['price'] = price_format($info['price']);
        $item[$info['id']]['description'] = strlimiter(strip_tags($info['description']),80);
        $item[$info['id']]['cat_id'] = $info['category'];
        $item[$info['id']]['sub_cat_id'] = $info['sub_category'];
        $item[$info['id']]['tag'] = $info['tag'];
        $images = get_post_option($info['id'],'images');
        $images = explode(',', $images);
        $item[$info['id']]['image'] = $images[0];
        $item[$info['id']]['username'] = $info['username'];
        $item[$info['id']]['fullname'] = $info['fullname'];
        $item[$info['id']]['user_image'] = $info['user_image'];
        $item[$info['id']]['favorite'] = check_product_favorite($info['id'],'gig');
        $item[$info['id']]['rating'] = gig_averageRating($info['id']);
        $pro_url = create_slug($info['title']);
        $item[$info['id']]['link'] = $link['SERVICE'].'/' . $info['id'] . '/'.$pro_url;
    }
}
else
{

}

$selected = "";
if(isset($_GET['cat']) && !empty($_GET['cat'])){
    $selected = $_GET['cat'];
}
// Check Settings For quotes
$GetCategory = get_maincategory('default',$selected);
$cat_dropdown = get_categories_dropdown('gig');
if(isset($_GET['cat']) && !empty($_GET['cat'])){
    $maincatname = get_maincat_by_id($category);
    $maincatname = $maincatname['cat_name'];
    $mainCategory = $maincatname;
}else{
    $maincatname = "";
    $mainCategory = "";
}
if(isset($_GET['subcat']) && !empty($_GET['subcat'])){
    $subcatname = get_subcat_by_id($subcat);
    $subcatname = $subcatname['sub_cat_name'];
    $subCategory = $subcatname;
}else{
    $subcatname = "";
    $subCategory = "";
}

if(isset($category) && !empty($category)){
    $Pagetitle = $mainCategory;
}
elseif(isset($subcat) && !empty($subcat)){
    $Pagetitle = $subCategory;
}
elseif(!empty($keywords)){
    $Pagetitle = ucfirst($keywords);
}
else{
    $Pagetitle = __("Services");
}


if(isset($category) && !empty($category)) {
    $SubCatList = get_subcat_of_maincat( $category);
}else{
    $SubCatList = get_maincategory('gig');
}

$Pagelink = "";
if(count($_GET) >= 1){
    $get = http_build_query($_GET);
    $Pagelink .= "?".$get;
    $pagging = pagenav($total,$page_number,$limit,$link['SEARCH_SERVICES'].$Pagelink,1);
}else{
    $pagging = pagenav($total,$page_number,$limit,$link['SEARCH_SERVICES']);
}

HtmlTemplate::display('service_search', array(
    'pages' => $pagging,
    'pagetitle' => $Pagetitle,
    'subcatlist' => $SubCatList,
    'items' => $item,
    'category' => $GetCategory,
    'cat_dropdown' => $cat_dropdown,
    'serkey' => $keywords,
    'maincat' => $category,
    'subcat' => $subcat,
    'maincategory' => $mainCategory,
    'subcategory' => $subCategory,
    'budget' => $budget,
    'keywords' => $keywords,
    'range1' => $range1,
    'range2' => $range2,
    'adsfound' => $total,
    'totaladsfound' => $totalWithoutFilter,
    'limit' => $limit,
    'filter' => $filter,
    'sort' => $sorting,
    'order' => $order,
    'no_result_id' => $noresult_id,
    'customfields' => $custom_fields,
    'showcustomfield' => (count($custom_fields) > 0) ? 1 : 0
));
exit;
