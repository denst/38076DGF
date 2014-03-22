<?php

class Model_Subject extends ORM {
    
    protected $_table_name  = 'dg_sbjcts';

    protected $_has_many = array(
        'teachers' => array('model' => 'teacher','through' => 'dg_tchrs_sbjcts'),
    );
    
    public function rules()
    {
            return array(
                    'name' => array(
                            array('not_empty'),
                            array(array($this, 'unique'), array('name', ':value'))
                    ),
            );
    }
}