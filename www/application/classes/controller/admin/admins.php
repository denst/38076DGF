<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Admins extends Controller_Admin_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['admins']->set_users_breadcrumb('admins');
    }
    
    public function action_tab()
    {
        $this->objects['admins']->action_tab();
    }

    public function action_view()
    {
        $this->objects['admins']->action_view();
    }
    
    public function action_create() 
    {
        $this->objects['admins']->action_create();
    }

    public function action_edit() 
    {
        $this->objects['admins']->action_edit();
    }
    
    public function action_delete() 
    {
        $this->objects['admins']->action_delete();
    }
}