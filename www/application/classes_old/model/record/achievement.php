<?php

class Model_Record_Achievement extends ORM {

    protected $_table_name  = 'dg_achvmntrcrds';
    
    public function rules()
    {
            return array(
                    'achievement' => array(
                            array('not_empty')),
//                    'notes' => array(
//                            array('not_empty')                        
//                    ),
            );
    }
}