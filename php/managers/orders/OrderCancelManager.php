<?php 

class OrderCancelManager extends OrderManager
{
    public function request_cancel()
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
            $cancel_reason = $_POST['reason'] ?? '';
    
            $order->set('status', 'request_cancel');
            $order->set('cancel_reason', $cancel_reason);
            $order->save();

            $this->pushNotify($employer_id, $freelancer_id, $post['id'], $post['title'], 'order_request_cancel', $cancel_reason);

            $this->retSuccess('Order requested to cancel');
    }

    public function request_cancel_accept()
    {
            global $config,$lang;

            if (!checkloggedin() || !isset($_POST['id']) || $_SESSION['user']['user_type'] != 'user') {
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
            $cancel_reason = $_POST['reason'] ?? '';

            $order_amount = $order['amount'];
            $seller_id = $order['seller_id'];
            $buyer_id = $order['user_id'];
            $post_id = $order['post_id'];

            add_balance($buyer_id, $order_amount, "Order cancelled");

            //Update Amount in Admin balance table
            $balance = ORM::for_table($config['db']['pre'].'balance')->find_one(1);
            $current_amount=$balance['current_balance'];
            $total_earning=$balance['total_earning'];

            $updated_amount = ($current_amount - $order_amount);
            $total_earning =  ($total_earning - $order_amount);

            $balance->current_balance = $updated_amount;
            $balance->total_earning = $total_earning;
            $balance->save();
    
            $order->set('status', 'cancelled');
            $order->save();

            $this->pushNotify($freelancer_id, $employer_id, $post['id'], $post['title'], 'order_request_cancel_accept', $cancel_reason);

            $this->retSuccess('Order requested to cancel accepted');
    }

    public function request_cancel_deny()
    {
            global $config,$lang;

            if (!checkloggedin() || !isset($_POST['id']) || $_SESSION['user']['user_type'] != 'user') {
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
            $order->save();

            $this->pushNotify($freelancer_id, $employer_id, $post['id'], $post['title'], 'order_request_cancel_deny', '');

            $this->retSuccess('Order requested to cancel denied');
    }
}