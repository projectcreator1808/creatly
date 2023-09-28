<?php 

class MilestoneSplitManager extends MilestoneManager
{
    private function changeBalanceForAccept($milestone)
    {
        global $config;

        $freelancer_id = $milestone['freelancer_id'];
        $amount = $milestone['amount'] * ($milestone['split_percent'] / 100);

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
    }

    private function revertBalanceForAccept($milestone)
    {
        global $config;

        
        $employer_id = $milestone['employer_id'];
        $user_data = get_user_data(null, $employer_id);
        $employer_balance = $user_data['balance'];
        $amount = $milestone['amount'] * ((100 - $milestone['split_percent']) / 100);

        $deducted = $employer_balance + $amount;
        //Plus Employer Account
        $user_update = ORM::for_table($config['db']['pre'] . 'user')->find_one($employer_id);
        $user_update->set('balance', $deducted);
        $user_update->save();
    }

    function split(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'employer') {
            $milestone_id = validate_input($_POST['id']);
            $split_percent = validate_input($_POST['split_percent']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'employer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                if ($split_percent >= 10 || $split_percent <= 99) {
    
                    $milestone->set('status', 'split_employer');
                    $milestone->set('split_percent', $split_percent);
                    $milestone->save();
        
                    $freelancer_id = $milestone['freelancer_id'];
                    $employer_id = $milestone['employer_id'];
                    $project_id = $milestone['project_id'];
        
                    $update_project = ORM::for_table($config['db']['pre'].'project')
                                ->where(array(
                                    'id' => $project_id,
                                    'user_id' => $employer_id,
                                    'freelancer_id' => $freelancer_id
                                ))
                                ->find_one();
                            $update_project->set('status', 'split_request');
                            $update_project->save();
        
                    $project_title = $update_project['product_name'];
                    $this->pushNotify($employer_id, $freelancer_id, $project_id, $project_title, 'milestone_split', $milestone['split_percent']);
        
                    $result['success'] = true;
                    $result['message'] = __("The milestone fund has been reject request.");
                }
                else {
                    $result['success'] = false;
                    $result['message'] = __("Split percent not in range 10 and 99");
                }
    
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
    
    function request_split(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'user') {
            $milestone_id = validate_input($_POST['id']);
            $split_percent = validate_input($_POST['split_percent']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'freelancer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                if ($split_percent >= 10 || $split_percent <= 99) {
    
                    $milestone->set('status', 'split_freelancer');
                    $milestone->set('split_percent', $split_percent);
                    $milestone->save();
        
                    $freelancer_id = $milestone['freelancer_id'];
                    $employer_id = $milestone['employer_id'];
                    $project_id = $milestone['project_id'];
        
                    $update_project = ORM::for_table($config['db']['pre'].'project')
                                ->where(array(
                                    'id' => $project_id,
                                    'user_id' => $employer_id,
                                    'freelancer_id' => $freelancer_id
                                ))
                                ->find_one();
                            $update_project->set('status', 'split_request');
                            $update_project->save();
        
                    $project_title = $update_project['product_name'];
                    $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_request_split', $milestone['split_percent']);
        
                    $result['success'] = true;
                    $result['message'] = __("The milestone fund has been reject request.");
                }
                else {
                    $result['success'] = false;
                    $result['message'] = __("Split percent not in range 10 and 99");
                }
    
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
    
    function accept_split(){
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
        
                    $milestone->set('status', 'paid_splited');
                    $milestone->set('request', '2');
                    $milestone->set('end_date', $now);
                    $milestone->save();
        
                    $user_data = get_user_data(null,$_SESSION['user']['id']);
                    $employer_balance = $user_data['balance'];
                    $employer_name = $user_data['name'];
        
                    $freelancer_id = $milestone['freelancer_id'];
                    $employer_id = $milestone['employer_id'];
                    $project_id = $milestone['project_id'];
                    $amount = $milestone['amount'] * $milestone['split_percent'] / 100;
                    $milestone_title = $milestone['title'];
                    $milestone_amount = $milestone['amount'];
        
                    $check_paid = ORM::for_table($config['db']['pre'] . 'milestone')
                        ->select('amount')
                        ->where(array(
                            'status'=> ['paid', 'paid_splited'],
                            'project_id'=> $project_id,
                            'employer_id'=> validate_input($_SESSION['user']['id'])
                        ))
                        ->find_many();
                    if (!empty($check_paid)) {
                        $epaid = 0;
                        foreach ($check_paid as $info) {
                            $amount_paid = $info['amount'];
                            if ($info['status'] == 'paid_splited') {
                                $amount_paid = $amount_paid * $info['split_percent'] / 100;
                            }
                            $epaid = $epaid + $amount_paid;
                        }
        
                        $bid = ORM::for_table($config['db']['pre'] . 'bids')
                            ->select('amount')
                            ->where(array(
                                'project_id'=> $project_id,
                                'user_id'=> $freelancer_id
                            ))
                            ->findOne();
        
                        $project_amount = $bid['amount'];
        
                        $update_project = ORM::for_table($config['db']['pre'].'project')
                            ->where(array(
                                'id' => $project_id,
                                'user_id' => $employer_id,
                                'freelancer_id' => $freelancer_id
                            ))
                            ->find_one();
                        // if ($epaid >= $project_amount){
                            $update_project->set('status', 'completed');
                        // }
                        // else {
                            // $update_project->set('status', 'under_development');
                        // }
                        $update_project->save();

                        $project_title = $update_project['product_name'];
                        $this->pushNotify($employer_id, $freelancer_id, $project_id, $project_title, 'milestone_accept_split', $milestone['split_percent']);
                    }

                    $this->changeBalanceForAccept($milestone);  
                    $this->revertBalanceForAccept($milestone);        
        
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

    function deny_split(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'employer') {
            $milestone_id = validate_input($_POST['id']);
            $split_percent = validate_input($_POST['split_percent']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'employer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
                    $milestone->set('status', 'funded');
                    $milestone->set('split_percent', null);
                    $milestone->save();
        
                    $freelancer_id = $milestone['freelancer_id'];
                    $employer_id = $milestone['employer_id'];
                    $project_id = $milestone['project_id'];
        
                    $update_project = ORM::for_table($config['db']['pre'].'project')
                                ->where(array(
                                    'id' => $project_id,
                                    'user_id' => $employer_id,
                                    'freelancer_id' => $freelancer_id
                                ))
                                ->find_one();
                            $update_project->set('status', 'under_development');
                            $update_project->save();
        
                    $project_title = $update_project['product_name'];
                    $this->pushNotify($employer_id, $freelancer_id, $project_id, $project_title, 'milestone_deny_split', $milestone['split_percent']);
        
                    $result['success'] = true;
                    $result['message'] = __("The milestone fund has been reject request.");
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

    function request_accept_split(){
        global $config,$lang,$link;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'user') {
            $milestone_id = $_POST['id'];
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'freelancer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                $milestone->set('status', 'paid_splited');
                $milestone->set('request', '2');
                $milestone->set('end_date', $now);
                $milestone->save();
    
                $user_data = get_user_data(null,$_SESSION['user']['id']);
                $employer_balance = $user_data['balance'];
                $employer_name = $user_data['name'];
    
                $freelancer_id = $milestone['freelancer_id'];
                $employer_id = $milestone['employer_id'];
                $project_id = $milestone['project_id'];
                $amount = $milestone['amount'] * $milestone['split_percent'] / 100;
                $milestone_title = $milestone['title'];
                $milestone_amount = $milestone['amount'];
    
                $check_paid = ORM::for_table($config['db']['pre'] . 'milestone')
                        ->select('amount')
                        ->where(array(
                            'status'=> ['paid', 'paid_splited'],
                            'project_id'=> $project_id,
                            'employer_id'=> validate_input($_SESSION['user']['id'])
                        ))
                        ->find_many();
                    if (!empty($check_paid)) {
                        $epaid = 0;
                        foreach ($check_paid as $info) {
                            $amount_paid = $info['amount'];
                            if ($info['status'] == 'paid_splited') {
                                $amount_paid = $amount_paid * $info['split_percent'] / 100;
                            }
                            $epaid = $epaid + $amount_paid;
                        }
        
                        $bid = ORM::for_table($config['db']['pre'] . 'bids')
                            ->select('amount')
                            ->where(array(
                                'project_id'=> $project_id,
                                'user_id'=> $freelancer_id
                            ))
                            ->findOne();
        
                        $project_amount = $bid['amount'];
        
                        $update_project = ORM::for_table($config['db']['pre'].'project')
                            ->where(array(
                                'id' => $project_id,
                                'user_id' => $employer_id,
                                'freelancer_id' => $freelancer_id
                            ))
                            ->find_one();
                        // if ($epaid >= $project_amount){
                            $update_project->set('status', 'completed');
                        // }
                        // else {
                            // $update_project->set('status', 'under_development');
                        // }
                        $update_project->save();

                        $project_title = $update_project['product_name'];
                        $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_request_accept_split', $milestone['split_percent']);
                    }

                    $this->changeBalanceForAccept($milestone);  
                    $this->revertBalanceForAccept($milestone);  
    
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

    function request_deny_split(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'user') {
            $milestone_id = validate_input($_POST['id']);
            $split_percent = validate_input($_POST['split_percent']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'freelancer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
                    $milestone->set('status', 'funded');
                    $milestone->set('split_percent', null);
                    $milestone->save();
        
                    $freelancer_id = $milestone['freelancer_id'];
                    $employer_id = $milestone['employer_id'];
                    $project_id = $milestone['project_id'];
        
                    $update_project = ORM::for_table($config['db']['pre'].'project')
                                ->where(array(
                                    'id' => $project_id,
                                    'user_id' => $employer_id,
                                    'freelancer_id' => $freelancer_id
                                ))
                                ->find_one();
                            $update_project->set('status', 'under_development');
                            $update_project->save();
        
                    $project_title = $update_project['product_name'];
                    $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_request_deny_split', $milestone['split_percent']);
        
                    $result['success'] = true;
                    $result['message'] = __("The milestone fund has been reject request.");
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