<?php

class Model_Class extends ORM {
    
    protected $_table_name  = 'dg_clsss';
    
    protected $_has_many    = array(
        'students' => array('model' => 'student', 'foreign_key' => 'class_id')
    );

    protected $_belongs_to  = array(
        'tclass'  => array('model' => 'class_template', 'foreign_key' => 'tclass_id')
    );
}