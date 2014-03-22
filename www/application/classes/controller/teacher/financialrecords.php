<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Financialrecords extends Controller_Teacher_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['financialrecords']->set_records_breadcrumb('financialrecords', 'students',
                'Financial Records');
    }
    
    public function action_list()
    {
        $this->objects['financialrecords']->action_list();
    }
}