<?php

class Model_Class_Template extends ORM {
    
    protected $_table_name  = 'dg_tmpl_clsss';
    
    protected $_has_many    = array(
        'students' => array('model' => 'student', 'foreign_key' => 'class_id')
    );
    
    protected $_belongs_to  = array(
        'level'  => array('model' => 'level', 'foreign_key' => 'level_id'),
        'teacher'  => array('model' => 'teacher', 'foreign_key' => 'teacher_id')
    );
}