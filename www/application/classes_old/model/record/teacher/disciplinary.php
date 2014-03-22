<?php

class Model_Record_Teacher_Disciplinary extends ORM {

    protected $_table_name  = 'dg_dscplnrrcrds_tchrs';
    
    public function rules()
    {
            return array(
                    'record' => array(
                            array('not_empty')),
                    'notes'  => array(
                            array('not_empty')),
                    'action' => array(
                            array('not_empty')                        
                    )
            );
    }
}