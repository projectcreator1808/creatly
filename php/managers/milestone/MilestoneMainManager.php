<?php 

class MilestoneMainManager extends MilestoneManager
{
    public function create()
    {
        global $config,$lang,$link;
    
        if(!checkloggedin()) {
            $this->retError("Error: Please try again.");
        }
    
        if (empty($_POST["title"])) {
            $this->retError("Milestone title required.");
        }
    
        if (empty($_POST["amount"])) {
            $this->retError("Milestone amount required.");
        }
    
        if(!is_numeric($_POST["amount"])) {
            $this->retError("Amount, must be numeric.");
        }
    
        if(isset($_POST['id']))
        {
            $project_id = (int) validate_input($_POST['id']);
    
            if($_SESSION['user']['user_type'] == 'employer'){
                $project = ORM::for_table($config['db']['pre'] . 'project')
                    ->select_many('product_name','user_id','freelancer_id')
                    ->where('id', $project_id)
                    ->where('user_id', $_SESSION['user']['id'])
                    ->find_one();
            }else{
                // $project = ORM::for_table($config['db']['pre'] . 'project')
                //     ->select_many('product_name','user_id','freelancer_id')
                //     ->where('id', $project_id)
                //     ->where('freelancer_id', $_SESSION['user']['id'])
                //     ->find_one();
                $project = null;
            }
            if(!empty($project)){
                $project_title = $project['product_name'];
                $employer_id = $project['user_id'];
                $freelancer_id = $project['freelancer_id'];
            } else {
                $this->retError("Project does not belong to you");
            }
    
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where([
                    'project_id'=> $project_id,
                    'employer_id'=> validate_input($_SESSION['user']['id']),
                ])
                ->whereNotEqual('status', 'rejected')
                ->find_one();
    
            if ($milestone) {
                $this->retError("Milestone exists");
            }
    
            // Get membership details
            $group_info = get_user_membership_settings();
    
            if($_SESSION['user']['user_type'] == 'employer'){
                $user_data = get_user_data(null,$_SESSION['user']['id']);
                $employer_balance = $user_data['balance'];
                $employer_name = $user_data['name'];
                $amount = validate_input($_POST['amount']);
                $employer_commission = $group_info['employer_commission'];
    
                if($employer_commission != 0){
                    $comission = (($amount/100)*$employer_commission);
                }else{
                    $comission = 0;
                }
                $t_amount = $_POST['amount'] + $comission;
                if($employer_balance < $t_amount)
                {
                    $result['success'] = false;
                    $result['message'] = __("Wallet balance must be grater than").' '.$config['currency_sign'].$t_amount.'.';
                    die(json_encode($result));
                }
                else
                {
                    $deducted = $employer_balance - $_POST['amount'];
                    //Minus From Employer Account
    
                    $now = date("Y-m-d H:i:s");
                    $user_update = ORM::for_table($config['db']['pre'] . 'user')->find_one($_SESSION['user']['id']);
                    $user_update->set('balance', $deducted);
                    $user_update->save();
    
                    if($employer_commission != 0){
                        $comission = (($amount/100)*$employer_commission);
                        minus_balance($employer_id,$comission);
                    }
    
                    if($comission > 0){
                        //Update Amount in Admin balance table
                        $balance = ORM::for_table($config['db']['pre'].'balance')->find_one(1);
                        $current_amount=$balance['current_balance'];
                        $total_earning=$balance['total_earning'];
    
                        $updated_amount=($comission+$current_amount);
                        $total_earning=($comission+$total_earning);
    
                        $balance->current_balance = $updated_amount;
                        $balance->total_earning = $total_earning;
                        $balance->save();
                    }
    
                    $now = date("Y-m-d H:i:s");
                    $milestone_title = validate_input($_POST['title']);
                    $milestone_amount = validate_input($_POST['amount']);
                    $create_milestone = ORM::for_table($config['db']['pre'].'milestone')->create();
                    $create_milestone->title = $milestone_title;
                    $create_milestone->amount = $milestone_amount;
                    $create_milestone->status = 'funded';
                    $create_milestone->created_by = $_SESSION['user']['user_type'];
                    $create_milestone->project_id = $project_id;
                    $create_milestone->employer_id = $employer_id;
                    $create_milestone->freelancer_id = $freelancer_id;
                    $create_milestone->start_date = $now;
                    $create_milestone->save();
    
                    $milestone_id = $create_milestone->id();
    
                    $SenderName = ucfirst($employer_name);
                    $SenderId = $_SESSION['user']['id'];
                    $OwnerName = '';
                    $OwnerId = $freelancer_id;
                    $productId = $project_id;
                    $productTitle = $project_title;
                    $type = 'milestone_created';
                    $message = $milestone_amount." ".$config['currency_code'];
                    add_firebase_notification($SenderName,$SenderId,$OwnerName,$OwnerId,$productId,$productTitle,$type,$message);
    
                    $ip = encode_ip($_SERVER, $_ENV);
                    $trans_insert = ORM::for_table($config['db']['pre'].'transaction')->create();
                    $trans_insert->product_name = $productTitle;
                    $trans_insert->product_id = $project_id;
                    $trans_insert->user_id = $SenderId;
                    $trans_insert->status = 'success';
                    $trans_insert->amount = $milestone_amount;
                    $trans_insert->transaction_gatway = 'Wallet';
                    $trans_insert->transaction_ip = $ip;
                    $trans_insert->transaction_time = time();
                    $trans_insert->transaction_description = 'milestone_created';
                    $trans_insert->transaction_method = 'milestone_created';
                    $trans_insert->save();
    
                    /*EMAIL-13: Freelancer : Milestone Created*/
                    $html = $config['email_sub_milestone_created'];
                    $html = str_replace ('{SITE_TITLE}', $config['site_title'], $html);
                    $html = str_replace ('{SITE_URL}', $config['site_url'], $html);
                    $html = str_replace ('{PROJECT_TITLE}', $project_title, $html);
                    $html = str_replace ('{PROJECT_LINK}', $link['PROJECT']."/".$project_id, $html);
                    $html = str_replace ('{MILESTONE_TITLE}', $milestone_title, $html);
                    $html = str_replace ('{MILESTONE_AMOUNT}', $milestone_amount, $html);
                    $email_subject = $html;
    
                    $html = $config['emailHTML_milestone_created'];
                    $html = str_replace ('{SITE_TITLE}', $config['site_title'], $html);
                    $html = str_replace ('{SITE_URL}', $config['site_url'], $html);
                    $html = str_replace ('{PROJECT_TITLE}', $project_title, $html);
                    $html = str_replace ('{PROJECT_LINK}', $link['PROJECT']."/".$project_id, $html);
                    $html = str_replace ('{MILESTONE_TITLE}', $milestone_title, $html);
                    $html = str_replace ('{MILESTONE_AMOUNT}', $milestone_amount, $html);
                    $email_body = $html;
    
                    //Get Freelancer Data
                    $info = ORM::for_table($config['db']['pre'] . 'user')
                        ->select_many('email','name')
                        ->where('id', $freelancer_id)
                        ->findOne();
    
                    if(!empty($info)){
                        $freelancer_email = $info['email'];
                        $freelancer_name = $info['name'];
                    }
    
                    email($freelancer_email,$freelancer_name,$email_subject,$email_body);
                    /*EMAIL-13: Freelancer : Milestone Created*/
    
    
                    $result['success'] = true;
                    $result['message'] = __("The money has been moved into an escrow payment");
                }
            }
        }else {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
        }
    
        die(json_encode($result));
    }

    public function release() 
    {
        global $config,$lang,$link;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'employer') {
            $milestone_id = $_POST['id'];
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'employer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                $this->change($milestone, [
                    'status' => 'paid',
                    'request' => '2',
                    'end_date' => $now,
                ]);
    
                $user_data = get_user_data(null,$_SESSION['user']['id']);
                $employer_balance = $user_data['balance'];
                $employer_name = $user_data['name'];
    
                $freelancer_id = $milestone['freelancer_id'];
                $employer_id = $milestone['employer_id'];
                $project_id = $milestone['project_id'];
                $amount = $milestone['amount'];
                $milestone_title = $milestone['title'];
                $milestone_amount = $milestone['amount'];
    
                $check_paid = ORM::for_table($config['db']['pre'] . 'milestone')
                    ->select('amount')
                    ->where(array(
                        'status'=> 'paid',
                        'project_id'=> $project_id,
                        'employer_id'=> validate_input($_SESSION['user']['id'])
                    ))
                    ->find_many();
                if (!empty($check_paid)) {
                    $epaid = 0;
                    foreach ($check_paid as $info) {
                        $epaid = $epaid + $info['amount'];
                    }
    
                    $bid = ORM::for_table($config['db']['pre'] . 'bids')
                        ->select('amount')
                        ->where(array(
                            'project_id'=> $project_id,
                            'user_id'=> $freelancer_id
                        ))
                        ->findOne();
    
                    $project_amount = $bid['amount'];
    
                    // if($epaid >= $project_amount){
                        $update_project = ORM::for_table($config['db']['pre'].'project')
                            ->where(array(
                                'id' => $project_id,
                                'user_id' => $employer_id,
                                'freelancer_id' => $freelancer_id
                            ))
                            ->find_one();
                        $update_project->set('status', 'completed');
                        $update_project->save();
                    // }
                }
    
    
                /*$deducted = $employer_balance - $amount;
                $now = date("Y-m-d H:i:s");
                $user_update = ORM::for_table($config['db']['pre'] . 'user')->find_one($_SESSION['user']['id']);
                $user_update->set('balance', $deducted);
                $user_update->save();*/
                //Minus From Freelancer Account
                $group_info = get_user_membership_settings();
                $freelancer_commission = $group_info['freelancer_commission'];
                if($freelancer_commission != 0){
                    $comission = (($amount/100)*$freelancer_commission);
                    minus_balance($freelancer_id,$comission);
                }
    
                if($comission > 0){
                    //Update Amount in Admin balance table
                    $balance = ORM::for_table($config['db']['pre'].'balance')->find_one(1);
                    $current_amount=$balance['current_balance'];
                    $total_earning=$balance['total_earning'];
    
                    $updated_amount=($comission+$current_amount);
                    $total_earning=($comission+$total_earning);
    
                    $balance->current_balance = $updated_amount;
                    $balance->total_earning = $total_earning;
                    $balance->save();
                }
    
                $update_balance = ORM::for_table($config['db']['pre'].'user')
                    ->where('id' , $freelancer_id)
                    ->find_one();
                $update_balance->set_expr('balance', 'balance+'.$amount);
                $update_balance->save();
    
                $project = ORM::for_table($config['db']['pre'].'project')
                    ->select('product_name')
                    ->where('id' , $project_id)
                    ->find_one();
                $project_title = $project['product_name'];
                $ip = encode_ip($_SERVER, $_ENV);
                $trans_insert = ORM::for_table($config['db']['pre'].'transaction')->create();
                $trans_insert->product_name = $project_title;
                $trans_insert->product_id = $project_id;
                $trans_insert->user_id = $employer_id;
                $trans_insert->status = 'success';
                $trans_insert->amount = $amount;
                $trans_insert->transaction_gatway = 'Wallet';
                $trans_insert->transaction_ip = $ip;
                $trans_insert->transaction_time = time();
                $trans_insert->transaction_description = "Milestone Released";
                $trans_insert->transaction_method = 'milestone_released';
                $trans_insert->save();
    
                $SenderName = ucfirst($employer_name);
                $SenderId = $_SESSION['user']['id'];
                $OwnerName = '';
                $OwnerId = $freelancer_id;
                $productId = $project_id;
                $productTitle = $project_title;
                $type = 'milestone_released';
                $message = $milestone_amount." ".$config['currency_code'];
                add_firebase_notification($SenderName,$SenderId,$OwnerName,$OwnerId,$productId,$productTitle,$type,$message);
    
                /*EMAIL-14: Freelancer : Milestone Release*/
                $html = $config['email_sub_milestone_released'];
                $html = str_replace ('{SITE_TITLE}', $config['site_title'], $html);
                $html = str_replace ('{SITE_URL}', $config['site_url'], $html);
                $html = str_replace ('{PROJECT_TITLE}', $project_title, $html);
                $html = str_replace ('{PROJECT_LINK}', $link['PROJECT']."/".$project_id, $html);
                $html = str_replace ('{MILESTONE_TITLE}', $milestone_title, $html);
                $html = str_replace ('{MILESTONE_AMOUNT}', $milestone_amount, $html);
                $email_subject = $html;
    
                $html = $config['emailHTML_milestone_released'];
                $html = str_replace ('{SITE_TITLE}', $config['site_title'], $html);
                $html = str_replace ('{SITE_URL}', $config['site_url'], $html);
                $html = str_replace ('{PROJECT_TITLE}', $project_title, $html);
                $html = str_replace ('{PROJECT_LINK}', $link['PROJECT']."/".$project_id, $html);
                $html = str_replace ('{MILESTONE_TITLE}', $milestone_title, $html);
                $html = str_replace ('{MILESTONE_AMOUNT}', $milestone_amount, $html);
                $email_body = $html;
    
                //Get Freelancer Data
                $info = ORM::for_table($config['db']['pre'] . 'user')
                    ->select_many('email','name')
                    ->where('id', $freelancer_id)
                    ->findOne();
    
                if(!empty($info)){
                    $freelancer_email = $info['email'];
                    $freelancer_name = $info['name'];
                }
    
                email($freelancer_email,$freelancer_name,$email_subject,$email_body);
                /*EMAIL-14: Freelancer : Milestone Release*/
    
                $result['success'] = true;
                $result['message'] = __("The milestone fund has been realesed.");
            }else{
                $result['success'] = false;
                $result['message'] = __("Project does not belong to you");
            }
        }else {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
        }
        die(json_encode($result));
    }

    function cancel(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'user') {
            $milestone_id = validate_input($_POST['id']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'freelancer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                $milestone->set('status', 'cancel');
                $milestone->set('request', '2');
                $milestone->set('end_date', $now);
                $milestone->save();
    
                $freelancer_id = $milestone['freelancer_id'];
                $employer_id = $milestone['employer_id'];
                $project_id = $milestone['project_id'];
                $amount = $milestone['amount'];
    
                $employer = ORM::for_table($config['db']['pre'].'user')
                    ->where('id' , $employer_id)
                    ->find_one();
                $employer->set_expr('balance', 'balance+'.$amount);
                $employer->save();
    
                $project = ORM::for_table($config['db']['pre'].'project')
                    ->select('product_name')
                    ->where('id' , $project_id)
                    ->find_one();
    
                $ip = encode_ip($_SERVER, $_ENV);
                $trans_insert = ORM::for_table($config['db']['pre'].'transaction')->create();
                $trans_insert->product_name = $project['product_name'];
                $trans_insert->product_id = $project_id;
                $trans_insert->user_id = $employer_id;
                $trans_insert->status = 'success';
                $trans_insert->amount = $amount;
                $trans_insert->transaction_gatway = 'Wallet';
                $trans_insert->transaction_ip = $ip;
                $trans_insert->transaction_time = time();
                $trans_insert->transaction_description = "Milestone Calceled";
                $trans_insert->transaction_method = 'milestone_cancel';
                $trans_insert->save();
    
                $result['success'] = true;
                $result['message'] = __("The milestone fund has been canceled.");
            }else{
                $result['success'] = false;
                $result['message'] = __("Project does not belong to you");
            }
        }else {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
        }
        die(json_encode($result));
    }

    function request_release(){
        global $config,$lang,$link;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'user') {
            $milestone_id = validate_input($_POST['id']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'freelancer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
                $milestone->set('status', 'request');
                $milestone->set('request', '1');
                $milestone->set('end_date', $now);
                $milestone->save();
    
                $freelancer_id = $milestone['freelancer_id'];
                $employer_id = $milestone['employer_id'];
                $project_id = $milestone['project_id'];
                $milestone_amount = $milestone['amount'];
                $milestone_title = $milestone['title'];
    
                $employer = ORM::for_table($config['db']['pre'].'user')
                    ->select_many('email','name')
                    ->find_one($employer_id);
                $project = ORM::for_table($config['db']['pre'].'project')
                    ->select('product_name')
                    ->find_one($project_id);
                $project_title = $project['product_name'];
                $employer_name = ucfirst($employer['name']);
                $employer_email = $employer['email'];
                $SenderName = ucfirst($employer['name']);
                $SenderId = $_SESSION['user']['id'];
                $OwnerName = '';
                $OwnerId = $employer_id;
                $productId = $project_id;
                $productTitle = $project_title;
                $type = 'milestone_request_release';
                $message = $milestone_amount." ".$config['currency_code'];
                add_firebase_notification($SenderName,$SenderId,$OwnerName,$OwnerId,$productId,$productTitle,$type,$message);
    
                /*EMAIL-15: Employer : Milestone Request to Release*/
                $html = $config['email_sub_milestone_request_to_release'];
                $html = str_replace ('{SITE_TITLE}', $config['site_title'], $html);
                $html = str_replace ('{SITE_URL}', $config['site_url'], $html);
                $html = str_replace ('{PROJECT_TITLE}', $project_title, $html);
                $html = str_replace ('{PROJECT_LINK}', $link['PROJECT']."/".$project_id, $html);
                $html = str_replace ('{MILESTONE_TITLE}', $milestone_title, $html);
                $html = str_replace ('{MILESTONE_AMOUNT}', $milestone_amount, $html);
                $email_subject = $html;
    
                $html = $config['emailHTML_milestone_request_to_release'];
                $html = str_replace ('{SITE_TITLE}', $config['site_title'], $html);
                $html = str_replace ('{SITE_URL}', $config['site_url'], $html);
                $html = str_replace ('{PROJECT_TITLE}', $project_title, $html);
                $html = str_replace ('{PROJECT_LINK}', $link['PROJECT']."/".$project_id, $html);
                $html = str_replace ('{MILESTONE_TITLE}', $milestone_title, $html);
                $html = str_replace ('{MILESTONE_AMOUNT}', $milestone_amount, $html);
                $email_body = $html;
    
                email($employer_email,$employer_name,$email_subject,$email_body);
                /*EMAIL-15: Employer : Milestone Request to Release*/
    
                $result['success'] = true;
                $result['message'] = __("The milestone fund has been realesed.");
            }else{
                $result['success'] = false;
                $result['message'] = __("Project does not belong to you");
            }
        }else {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
        }
        die(json_encode($result));
    }
}