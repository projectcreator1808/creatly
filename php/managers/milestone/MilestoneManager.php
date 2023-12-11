<?php 

class MilestoneManager extends Manager
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

        if (isset($data['status'])) {
            $milestone->set('last_status_updated_at', date('Y-m-d H:i:s'));
        }

        $milestone->save();
    }
}