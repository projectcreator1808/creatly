<?php 

class OrderManager extends Manager
{
    public function __construct()
    {
        //
    }

    protected function getPostOrder($order)
    {
        global $config;

        $post = ORM::for_table($config['db']['pre'] . 'post')
            ->where([
                'id'=> $order['post_id'],
                'post_type' => 'gig'
            ])
            ->find_one();

        return $post;
    }
}