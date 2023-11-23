<?php 

class OrderRevisionManager extends OrderManager
{
    public function revision()
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
    
            $order->set('status', 'revision');
            $order->set('count_revisions', $order['count_revisions'] + 1);
            $order->save();

            $this->pushNotify($employer_id, $freelancer_id, $post['id'], $post['title'], 'order_revision', '');

            $this->retSuccess('Order send to revision');
    }
}