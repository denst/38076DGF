<?php

class Model_Academicyear extends ORM {
    protected $_table_name  = 'dg_acdmcyrs';
    
    public function get_end_year()
    {
        $end_year = ORM::factory('academicyear')
                ->where('name', '=', Helper_Main::getCurrentYear())
                ->find()->id;
        return $end_year;
    }
    
    public function get_academic_year_by_id($year_id)
    {
        $academic_year = ORM::factory('academicyear', $year_id);
        return $academic_year;
    }
}