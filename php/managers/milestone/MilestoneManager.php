<?php 

class MilestoneManager 
{
    public function __construct()
    {
        //
    }

    protected function change($milestone, $data)
    {
        foreach ($data as $key => $value) {
            $milestone->set($key, $value);
        }

        $milestone->save();
    }

    protected function retError($message)
    {
        $result['success'] = false;
        $result['message'] = __($message);
        die(json_encode($result));
    }

    protected function pushNotify($user_id, $owner_id, $project_id, $project_title, $type, $message)
    {
        $user_data = get_user_data(null, $user_id);
        $SenderName = ucfirst($user_data['name']);
        $SenderId = $user_id;
        $OwnerName = '';
        $OwnerId = $owner_id;
        $productId = $project_id;
        $productTitle = $project_title;
        add_firebase_notification($SenderName,$SenderId,$OwnerName,$OwnerId,$productId,$productTitle,$type,$message);
    }
}