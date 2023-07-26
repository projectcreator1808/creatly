<?php
if(!isset($_GET['page']))
    $_GET['page'] = 1;

$limit = 4;

if(checkloggedin()) {
    $transactions = array();
    $count = 0;

    $rows = ORM::for_table($config['db']['pre'].'transaction')
        ->where('user_id',$_SESSION['user']['id'])
        ->order_by_desc('id')
        ->find_many();
    $total_item = count($rows);
    foreach ($rows as $row)
    {
        $transactions[$count]['id'] = $row['id'];
        $transactions[$count]['product_id'] = $row['product_id'];
        $transactions[$count]['product_name'] = $row['product_name'];
        $transactions[$count]['amount'] = $config['currency_sign'].$row['amount'];
        $transactions[$count]['payment_by'] = $row['transaction_gatway'];
        $transactions[$count]['time'] = date('d M Y h:i A', $row['transaction_time']);

        $pro_url = create_slug($row['product_name']);
        $product_link = $link['POST-DETAIL'].'/' . $row['product_id'] . '/'.$pro_url;
        $transactions[$count]['product_link'] = $product_link;

        $premium = '';
        if($row['transaction_method'] == 'membership'){
            $premium = '<span class="dashboard-status-button green">'.__("Membership").'</span>';
        }
        else if($row['transaction_method'] == 'order_service'){
            $premium = '<span class="dashboard-status-button pink">'.__("Order Service").'</span>';
        }
        else if($row['transaction_method'] == 'order_completed'){
            $premium = '<span class="dashboard-status-button pink">'.__("Order Completed").'</span>';
        }
        else if($row['transaction_method'] == 'project_fee'){
            $premium = '<span class="dashboard-status-button purple">'.__("Project Fee").'</span>';
        }
        else if($row['transaction_method'] == 'deposit'){
            $premium = '<span class="dashboard-status-button dark">'.__("Deposit").'</span>';
        }
        else if($row['transaction_method'] == 'milestone_created' || $row['transaction_method'] == 'milestone_released'){
            $premium = '<span class="dashboard-status-button orange">'.__("Milestone").'</span>';
        }else if($row['transaction_method'] == 'banner_advertise'){
            $premium = '<span class="dashboard-status-button dark">'.__("Banner advertise").'</span>';
        }
        else{
            $featured = $row['featured'];
            $urgent = $row['urgent'];
            $highlight = $row['highlight'];


            if ($featured == "1") {
                $premium = $premium . '<span class="dashboard-status-button blue">'.__("Featured").'</span>';
            }

            if ($urgent == "1") {
                $premium = $premium . '<span class="dashboard-status-button yellow">'.__("Urgent").'</span>';
            }

            if ($highlight == "1") {
                $premium = $premium . '<span class="dashboard-status-button red">'.__("Highlight").'</span>';
            }
        }


        $t_status = $row['status'];
        $status = '';
        if ($t_status == "success") {
            $status = '<span class="dashboard-status-button green">'.__("Success").'</span>';
        } elseif ($t_status == "pending") {
            $status = '<span class="dashboard-status-button blue">'.__("Pending").'</span>';
        } elseif ($t_status == "failed") {
            $status = '<span class="dashboard-status-button red">'.__("Failed").'</span>';
        }else{
            $status = '<span class="dashboard-status-button yellow">'.__("Cancel").'</span>';
        }

        $transactions[$count]['premium'] = $premium;
        $transactions[$count]['status'] = $status;
        $transactions[$count]['invoice'] = $t_status == "success" ? $link['INVOICE'].'/'.$row['id']:'';
        $count++;
    }

    //Print Template
    HtmlTemplate::display('global/transaction', array(
        'transactions' => $transactions,
        'pages' => pagenav($total_item,$_GET['page'],20,$link['TRANSACTION'] ,0),
        'total_item' => $total_item
    ));
    exit;
}
else{
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit();
}
?>
