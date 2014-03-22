<?php

class Model_Period_Academics extends ORM {
    protected $_table_name  = 'dg_academic_periods';
    
    public function get_periods()
    {
        $periods = ORM::factory('period_academics')->find_all();
        return $periods;
    }
    
    public function get_period_by_id($id)
    {
        $period = ORM::factory('period_academics', $id);
        return $period;
    }
}