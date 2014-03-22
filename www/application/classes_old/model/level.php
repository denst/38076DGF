<?php

class Model_Level extends ORM {

    protected $_table_name  = 'dg_lvls';
    protected $_has_many = array(
        'template_classes' => array('model' => 'class_template',   'foreign_key' => 'level_id'),
        'students'       => array('model' => 'student', 'foreign_key' => 'academic_year'),
    );
    
    public function rules()
    {
            return array(
                    'name' => array(
                            array('not_empty'),
                            array(array($this, 'unique'), array('name', ':value'))
                    ),
                    'annual' => array(
                        array('numeric')
                    ),
                    'early_repayment' => array(
                        array('numeric')
                    ),
            );
    }
    
    public static function get_min_max_student_year()
    {
        return DB::select(array('MAX("end_year")', 'max_year'),array('MIN("end_year")', 'min_year'))
            ->from('dg_stdnts')
            ->as_object()
            ->execute()
            ->as_array();
    }
    
    public function get_level_list()
    {
        $level_list = array("pre-school","kindergarten","preparatory","1","2","3","4","5","6","7","8","9","10","11","12");
        return $level_list;
    }
}