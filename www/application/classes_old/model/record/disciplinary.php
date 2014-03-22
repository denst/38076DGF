<?php

class Model_Record_Disciplinary extends ORM {

    protected $_table_name  = 'dg_dscplnrrcrds';
    
    public function rules()
    {
            return array(
                    'record' => array(
                            array('not_empty')),
//                    'notes'  => array(
//                            array('not_empty')),
                    'action' => array(
                            array('not_empty')                        
                    )
            );
    }
}