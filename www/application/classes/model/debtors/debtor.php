<?php

class Model_Debtors_Debtor extends ORM {
    
    public function get_current_period()
    {
        $current_pariod;
        $current_pariod_order;
        $dates = Model::factory('academicdates')->get_dates();
        $current_date = time();
        foreach ($dates as $date) 
        {
            if($date->to < $current_date)
            {
                $current_pariod = Model::factory('period_academics')
                    ->get_period_by_id($date->period_id);
                $current_pariod_order = $date->order;
            }       
        }
        if(Valid::not_empty($current_pariod))
        {
            $result['current'] = $current_pariod;
            $result['order'] = $current_pariod_order;
            return $result;
        }
        else
            return false;
    }
}
