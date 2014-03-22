<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Dashboard extends Controller_Admin_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['dashboard']->set_breadcrumb();
    }
    
    public function action_index()
    {
        $this->objects['dashboard']->set_financial_debtors();
        $this->objects['dashboard']->set_academic_debtors();
        $this->objects['dashboard']->action_index();
    }
    
    public function action_approve()
    {
        $this->objects['dashboard']->action_approve();
    }
    
    public function action_change_password()
    {
        $this->objects['dashboard']->action_change_password();
    }
    
    public function action_academic_period()
    {
        $this->objects['dashboard']->action_academic_period();
    }
}