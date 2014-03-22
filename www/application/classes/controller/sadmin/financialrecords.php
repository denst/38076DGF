<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Financialrecords extends Controller_Sadmin_App {
    
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

    public function action_payment()
    {
        $this->objects['financialrecords']->action_payment();
    }
    
    public function action_finishpayment()
    {
        $this->objects['financialrecords']->action_finishpayment();
    }
}