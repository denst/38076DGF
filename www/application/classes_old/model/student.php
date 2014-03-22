<?php

class Model_Student extends ORM {
    protected $_table_name  = 'dg_stdnts';
    protected $_primary_key = 'student_id';
    protected $_belongs_to  = array(
        'class' => array('model' => 'class_template', 'foreign_key' => 'class_id'),
        'level' => array('model' => 'level', 'foreign_key' => 'academic_year'),
        'user'  => array('model' => 'auth_user', 'foreign_key' => 'student_id')
        );
    
}