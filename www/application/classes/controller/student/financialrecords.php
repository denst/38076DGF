<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_Financialrecords extends Controller_Student_App {

    public function before() 
    {
        parent::before();
        $this->objects['financialrecords']->set_breadcrumb_current('Finance', 
            $this->request->param('id'));
        $this->objects['financialrecords']->set_breadcrumb();
    }
    
    public function action_list()
    {
        $this->objects['financialrecords']->action_list();
    }
}