<?php

class Model_Academicdates extends ORM {
    
    protected $_table_name  = 'dg_academic_dates';
    
    public function get_dates()
    {
        $dates = ORM::factory('academicdates')->find_all();
        return $dates;
    }
}