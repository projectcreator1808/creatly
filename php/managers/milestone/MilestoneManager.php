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

        $milestone->save();
    }
}