<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Students extends Controller_Admin_App {
        
    public function before() 
    {
        parent::before();
        $this->objects['students']->set_users_breadcrumb('students');
    }

    public function action_slider() 
    {
        $this->objects['students']->action_slider();
    }
    
    public function action_tab() 
    {
        $this->objects['students']->action_tab();
    }
        
    public function action_dropout() 
    {
        $this->objects['students']->action_dropout();
    }
    
    public function action_changedropout() 
    {
        $this->objects['students']->action_changedropout();
    }
    
    public function action_create() 
    {
        $this->objects['students']->action_create();
    }
    
    public function action_edit() 
    {
        $this->objects['students']->action_edit();
    }
    
    public function action_delete() 
    {
        $this->objects['students']->action_delete();
    }
    
    public function action_view() 
    {
        $this->objects['students']->action_view();
    }
}