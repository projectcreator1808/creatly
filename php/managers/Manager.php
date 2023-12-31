<?php 

class Manager
{
    protected function ret($success, $message)
    {
        $result = [
            'success' => $success,
            'message' => $message,
        ];
        die(json_encode($result));
    }

    protected function retError($message, $toLang = true)
    {
        if ($toLang) {
            $message = __($message);
        }
        $this->ret(false, $message);
    }

    protected function retSuccess($message, $toLang = true)
    {
        if ($toLang) {
            $message = __($message);
        }
        $this->ret(true, $message);
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

    protected function saveTransaction($project_title, $project_id, $user_id, $amount, $description, $method)
    {
        global $config;

        $ip = encode_ip($_SERVER, $_ENV);
        $trans_insert = ORM::for_table($config['db']['pre'].'transaction')->create();
        $trans_insert->product_name = $project_title;
        $trans_insert->product_id = $project_id;
        $trans_insert->user_id = $user_id;
        $trans_insert->status = 'success';
        $trans_insert->amount = $amount;
        $trans_insert->transaction_gatway = 'Wallet';
        $trans_insert->transaction_ip = $ip;
        $trans_insert->transaction_time = time();
        $trans_insert->transaction_description = $description;
        $trans_insert->transaction_method = $method;
        $trans_insert->save();
    }
}