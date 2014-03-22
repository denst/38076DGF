<?php

class Model_Teacher extends ORM {
    
    protected $_table_name  = 'dg_tchrs';
    
    protected $_primary_key = 'teacher_id';
    
    protected $_belongs_to  = array(
            'user'  => array('model' => 'auth_user', 'foreign_key' => 'teacher_id'),        
        );
    
    protected $_has_many = array(
            'subjects' => array('model' => 'subject', 'through' => 'dg_tchrs_sbjcts'),
       	);
}