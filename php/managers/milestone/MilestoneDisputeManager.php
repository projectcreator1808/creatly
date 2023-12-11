<?php 

class MilestoneDisputeManager extends MilestoneManager
{
    public function dispute()
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
    
                $milestone->set('status', 'dispute');
                $milestone->set('last_status_updated_at', date('Y-m-d H:i:s'));
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
                        $update_project->set('status', 'dispute');
                        $update_project->set('last_status_updated_at', date('Y-m-d H:i:s'));
                        $update_project->save();

                $project_title = $update_project['product_name'];
    
                $this->pushNotify($employer_id, $freelancer_id, $project_id, $project_title, 'milestone_dispute', '');
    
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

    function request_dispute(){
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
    
                $milestone->set('status', 'dispute');
                $milestone->set('last_status_updated_at', date('Y-m-d H:i:s'));
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
                        $update_project->set('status', 'dispute');
                        $update_project->set('last_status_updated_at', date('Y-m-d H:i:s'));
                        $update_project->save();
    
                $project_title = $update_project['product_name'];

                $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_request_dispute', '');
    
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

    function request_deliver(){
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
                $milestone->set('status', 'deliver');
                $milestone->set('last_status_updated_at', date('Y-m-d H:i:s'));
                $milestone->save();
    
                $freelancer_id = $milestone['freelancer_id'];
                $employer_id = $milestone['employer_id'];
                $project_id = $milestone['project_id'];
                $milestone_amount = $milestone['amount'];
                $milestone_title = $milestone['title'];
    
                $update_project = ORM::for_table($config['db']['pre'].'project')
                            ->where(array(
                                'id' => $project_id,
                                'user_id' => $employer_id,
                                'freelancer_id' => $freelancer_id
                            ))
                            ->find_one();
                        $update_project->set('status', 'deliver');
                        $update_project->set('last_status_updated_at', date('Y-m-d H:i:s'));
                        $update_project->save();
                
                $project_title = $update_project['product_name'];
    
                $this->pushNotify($freelancer_id, $employer_id, $project_id, $project_title, 'milestone_deliver', '');
    
                $result['success'] = true;
                $result['message'] = __("The milestone has been delivered.");
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