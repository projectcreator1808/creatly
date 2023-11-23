<?php 

class OrderCronManager extends OrderManager
{
    public function overdue_detected()
    {
        global $config,$lang;
            
        $orders = ORM::for_table($config['db']['pre'] . 'orders')
            ->where_lt('execute_expire_at', date('Y-m-d H:i:s', time()))
            ->whereIn('status', ['progress', 'revision'])
            ->find_many(); 

        foreach ($orders as $order) {
            $post = $this->getPostOrder($order);
            
            $employer_id = $order['user_id'];
            $freelancer_id = $post['user_id'];
    
            $order->set('status', 'overdue');
            $order->save();

            $this->pushNotify($employer_id, $freelancer_id, $post['id'], $post['title'], 'order_overdue', '');
            $this->pushNotify($freelancer_id, $employer_id, $post['id'], $post['title'], 'order_overdue', '');
        }
    }
}