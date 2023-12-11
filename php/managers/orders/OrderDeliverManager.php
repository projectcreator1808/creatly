<?php 

class OrderDeliverManager extends OrderManager
{
    public function deliver()
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
    
            $order->set('status', 'delivered');
            $order->set('last_status_updated_at', date('Y-m-d H:i:s'));
            $order->save();

            $this->pushNotify($freelancer_id, $employer_id, $post['id'], $post['title'], 'order_delivered', '');

            $this->retSuccess('Order success to delivered');
    }
}