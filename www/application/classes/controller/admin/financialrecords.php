<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Financialrecords extends Controller_Admin_App {
        
    public function before() 
    {
        parent::before();
        $this->objects['financialrecords']->set_records_breadcrumb('financialrecords', 'students',
                'Financial Records');
    }
    
    /*
     * Show list financial records
     */
    public function action_list()
    {
        $this->objects['financialrecords']->action_list();
    }

    /*
     * Paid/not paid for financial recor++d
     */
    public function action_paid()
    {
        $this->objects['financialrecords']->action_paid();
    }
    
    /*
     * Finish paid for year
     */
    public function action_finishpayment()
    {
        $this->objects['financialrecords']->action_finishpayment();
    }
}