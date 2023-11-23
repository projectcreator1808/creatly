<?php 

class OrderPlusTimeManager extends OrderManager
{
    public function request_plus_time()
    {
        global $config,$lang;
        
        if (!checkloggedin() || !isset($_POST['id']) || !isset($_POST['plus_time_days']) || $_SESSION['user']['user_type'] != 'user') {
            $this->retError(__("Error: Please try again."));
        }
        
        $order_id = validate_input($_POST['id']);
        $order = ORM::for_table($config['db']['pre'] . 'orders')
            ->where(array(
                'id'=> $order_id,
            ))
            ->find_one();
            
        if (empty($order)) {
            $this->retError(__("Order does not belong to you"));
        }
        
        $post = $this->getPostOrder($order);
            
        if (empty($post)) {
            $this->retError(__("Order does not belong to you"));
        }
                
        $employer_id = $order['user_id'];
        $freelancer_id = $post['user_id'];
        $plus_time_days = validate_input($_POST['plus_time_days']);

        $order->set('status', 'request_plus_time');
        $order->set('count_plus_days_requested', $plus_time_days);
        $order->save();

        $this->pushNotify($freelancer_id, $employer_id, $post['id'], $post['title'], 'order_request_plus_time', '');

        $this->retSuccess('Order requested plus time');
    }

    public function request_plus_accept()
    {
        global $config,$lang;
        
        if (!checkloggedin() || !isset($_POST['id']) || $_SESSION['user']['user_type'] != 'employer') {
            $this->retError(__("Error: Please try again."));
        }
        
        $order_id = validate_input($_POST['id']);
        $order = ORM::for_table($config['db']['pre'] . 'orders')
            ->where(array(
                'id'=> $order_id,
            ))
            ->find_one();
            
        if (empty($order)) {
            $this->retError(__("Order does not belong to you"));
        }
        
        $post = $this->getPostOrder($order);
            
        if (empty($post)) {
            $this->retError(__("Order does not belong to you"));
        }
                
        $employer_id = $order['user_id'];
        $freelancer_id = $post['user_id'];

        $order->set('status', 'progress');
        $order->set('execute_expire_at', date('Y-m-d H:i:s', time() + 86400 * $order['count_plus_days_requested']));
        $order->save();

        $this->pushNotify($employer_id, $freelancer_id, $post['id'], $post['title'], 'order_request_plus_time_accept', '');

        $this->retSuccess('Order request plus time accept');
    }

    public function request_plus_deny()
    {
        global $config,$lang;
        
        if (!checkloggedin() || !isset($_POST['id']) || $_SESSION['user']['user_type'] != 'employer') {
            $this->retError(__("Error: Please try again."));
        }
        
        $order_id = validate_input($_POST['id']);
        $order = ORM::for_table($config['db']['pre'] . 'orders')
            ->where(array(
                'id'=> $order_id,
            ))
            ->find_one();
            
        if (empty($order)) {
            $this->retError(__("Order does not belong to you"));
        }
        
        $post = $this->getPostOrder($order);
            
        if (empty($post)) {
            $this->retError(__("Order does not belong to you"));
        }
                
        $employer_id = $order['user_id'];
        $freelancer_id = $post['user_id'];

        $order->set('status', 'overdue');
        $order->save();

        $this->pushNotify($employer_id, $freelancer_id, $post['id'], $post['title'], 'order_request_plus_time_deny', '');

        $this->retSuccess('Order request plus time deny');
    }
}