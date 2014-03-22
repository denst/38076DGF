<?php

class Model_Setting extends ORM {
    
    protected $_table_name  = 'dg_sttngs';
    protected $_primary_key = 'key';
    
    public function get_value($key)
    {
        $value = ORM::factory('setting', $key)->value;
        return $value;
    }
}