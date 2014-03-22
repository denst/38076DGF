<?php

class Model_Record_Teacher_Achievement extends ORM {

    protected $_table_name  = 'dg_achvmntrcrds_tchrs';
    
    public function rules()
    {
            return array(
                    'achievement' => array(
                            array('not_empty')),
                    'notes' => array(
                            array('not_empty')                        
                    ),
            );
    }
}