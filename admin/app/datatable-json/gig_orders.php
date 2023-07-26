<?php
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
define("APPPATH", ROOTPATH."/php/");
require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
admin_session_start();
$pdo = ORM::get_db();

// initilize all variable
$params = $columns = $order = $totalRecords = $data = array();
$params = $_REQUEST;
if($params['draw'] == 1)
    $params['order'][0]['dir'] = "desc";
//define index of column
$columns = array(
    0 =>'o.id',
    1 =>'p.title',
    2 =>'u.username',
    5 =>'o.created_at',
    6 =>'o.status'
);

$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ){
    if(isset($_GET['status'])) {
        $where .=" WHERE ";
        $where .=" ( p.title LIKE '%".$params['search']['value']."%' ";
        $where .=" OR u.username LIKE '%".$params['search']['value']."%' ";
        $where .=" OR o.code LIKE '".$params['search']['value']."%' ) ";

        $where .=" AND ( o.status = '".$_GET['status']."' )";
    }
    else{
        $where .=" WHERE ";
        $where .=" ( p.title LIKE '%".$params['search']['value']."%' ";
        $where .=" OR u.username LIKE '%".$params['search']['value']."%' ";
        $where .=" OR o.code LIKE '".$params['search']['value']."%' ) ";
    }
}

// getting total number records without any search
$sql = "SELECT o.*, p.id as post_id, p.title as title, u.username as username
FROM `".$config['db']['pre']."orders` as o
INNER JOIN `".$config['db']['pre']."user` as u ON u.id = o.user_id
INNER JOIN `".$config['db']['pre']."post` as p ON p.id = o.post_id ";
$sqlTot .= $sql;
$sqlRec .= $sql;
//concatenate search sql if value exist
if(isset($where) && $where != '') {
    $sqlTot .= $where;
    $sqlRec .= $where;
}else{
    if(isset($_GET['status'])){
        $where .=" Where ( o.status = '".$_GET['status']."' )";
        $sqlTot .= $where;
        $sqlRec .= $where;
    }
}

$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]." ".$params['order'][0]['dir']." LIMIT ".$params['start']." ,".$params['length']." ";

$queryTot = $pdo->query($sqlTot);
$totalRecords = $queryTot->rowCount();
$queryRecords = $pdo->query($sqlRec);

//iterate on results row and create new index array of data
foreach ($queryRecords as $row) {
    $id = $row['id'];
    $username = $row['username'];
    $title = htmlspecialchars($row['title']);
    $created_at  = date('d-M-Y', strtotime($row['created_at']));
    $code = $row['purchase_code'];
    $amount = price_format($row['amount']);
    $ad_status    = $row['status'];

    if($row['plan_id'] == "basic"){
        $plan_json = json_decode(get_post_option($row['post_id'], 'basic_pricing_plan'),true);
    }elseif($row['plan_id'] == "standard"){
        $plan_json = json_decode(get_post_option($row['post_id'], 'standard_pricing_plan'),true);
    }elseif($row['plan_id'] == "premium"){
        $plan_json = json_decode(get_post_option($row['post_id'], 'premium_pricing_plan'),true);
    }
    $plan_name = $plan_json['name'];
    $delivery_time = $plan_json['delivery_time'];
    $end_date = date('d-M-Y', strtotime($row['created_at']. ' + '.$delivery_time.' days'));

    $pro_url = create_slug($row['title']);
    $url = $link['SERVICE'].'/' . $row['post_id'] . '/'.$pro_url;
    
    $status = '';
    if ($ad_status == "progress"){
        $status = '<span class="label label-success">Progress</span>';
    }
    elseif($ad_status == "cancelled")
    {
        $status = '<span class="label label-warning">Cancelled</span>';
    }
    elseif($ad_status == "completed")
    {
        $status = '<span class="label label-info">Completed</span>';
    }

    $row0 = '<td class="text-center">
                <p class="font-500 m-b-0"><a href="'.$url.'" target="_blank">'.$title.'</a></p>
                <p class="text-muted m-b-0">ID : '.$code.'</p>
            </td>';
    $row1 = '<td class="hidden-xs">'.$username.'</td>';
    $row2 = '<td class="hidden-xs">'.$amount.'</td>';
    $row3 = '<td class="hidden-xs">'.$plan_name.'</td>';
    $row4 = '<td class="hidden-xs">'.$created_at.'</td>';
    $row5 = '<td class="hidden-xs hidden-sm">'.$end_date.'</td>';
    $row6 = '<td class="hidden-xs hidden-sm">'.$status.'</td>';
    $value = array(
        "DT_RowId" => $id,
        0 => $row0,
        1 => $row1,
        2 => $row2,
        3 => $row3,
        4 => $row4,
        5 => $row5,
        6 => $row6
    );
    $data[] = $value;

}

$json_data = array(
    "draw"            => intval( $params['draw'] ),
    "recordsTotal"    => intval( $totalRecords ),
    "recordsFiltered" => intval($totalRecords),
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
?>
