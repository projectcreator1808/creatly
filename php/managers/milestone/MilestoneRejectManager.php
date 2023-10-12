<?php 

class MilestoneRejectManager extends MilestoneManager
{
    private function changeBalanceForAccept($milestone)
    {
        global $config;

        $employer_id = $milestone['employer_id'];
        $user_data = get_user_data(null, $employer_id);
        $employer_balance = $user_data['balance'];
        $amount = $milestone['amount'];

        $project_id = $milestone['project_id'];
        $project = ORM::for_table($config['db']['pre'].'project')
            ->select('product_name')
            ->where('id' , $project_id)
            ->find_one();

        $deducted = $employer_balance + $amount;
        //Plus Employer Account
        $user_update = ORM::for_table($config['db']['pre'] . 'user')->find_one($employer_id);
        $user_update->set('balance', $deducted);
        $user_update->save();

        $this->saveTransaction($project['product_name'], $project_id, $employer_id, $amount, "Milestone Rejected", 'milestone_reject');
    }

    function reject(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'employer') {
            $milestone_id = validate_input($_POST['id']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'employer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                $milestone->set('status', 'reject_employer');
                $milestone->set('request', '1');
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
                        $update_project->set('status', 'reject_request');
                        $update_project->save();

                    $project_title = $update_project['product_name'];

                    $this->pushNotify($employer_id, $freelancer_id, $project_id, $project_title, 'milestone_reject', '');
    
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

    function request_reject(){
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
    
                $milestone->set('status', 'reject_freelancer');
                $milestone->set('request', '1');
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
                        $update_project->set('status', 'reject_request');
                        $update_project->save();

                $project_title = $update_project['product_name'];

                $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_request_reject', '');
    
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

    function request_accept_reject(){
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
    
                $milestone->set('status', 'rejected');
                $milestone->set('request', '2');
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
                        $update_project->set('status', 'rejected');
                        $update_project->save();

                $this->changeBalanceForAccept($milestone);
    
                $project_title = $update_project['product_name'];

                $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_request_accept_reject', '');
    
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

    function request_deny_reject(){
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
    
                $milestone->set('status', 'request');
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

                $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_request_deny_reject', '');
    
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

    function accept_reject(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'employer') {
            $milestone_id = validate_input($_POST['id']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'employer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                $milestone->set('status', 'rejected');
                $milestone->set('request', '2');
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
                        $update_project->set('status', 'rejected');
                        $update_project->save();
    
                $this->changeBalanceForAccept($milestone);

                $project_title = $update_project['product_name'];

                $this->pushNotify($employer_id, $freelancer_id, $project_id, $project_title, 'milestone_accept_reject', '');
    
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
    
    function deny_reject(){
        global $config,$lang;
    
        if(!checkloggedin()) {
            $result['success'] = false;
            $result['message'] = __("Error: Please try again.");
            die(json_encode($result));
        }
    
        if(isset($_POST['id']) && checkloggedin() && $_SESSION['user']['user_type'] == 'employer') {
            $milestone_id = validate_input($_POST['id']);
            $now = date("Y-m-d H:i:s");
            $milestone = ORM::for_table($config['db']['pre'] . 'milestone')
                ->where(array(
                    'id'=> validate_input($milestone_id),
                    'employer_id'=> validate_input($_SESSION['user']['id'])
                ))
                ->find_one();
    
            if (!empty($milestone)) {
    
                $milestone->set('status', 'request');
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

                $this->pushNotify($employer_id, $freelancer_id, $project_id, $project_title, 'milestone_deny_reject', '');
    
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