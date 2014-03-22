<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Subjects extends Controller_Sadmin_App {

    private $slider_names = array('edit' => 'Edit Subject', 
        'create' => 'Create Subject');
    
    public function before() 
    {
        parent::before();
        $this->objects['subjects']->set_settings_breadcrumb('subjects', $this->slider_names);
    }
    
    public function action_index()
    {
        $this->objects['subjects']->action_index();
    }
    
    public function action_create()
    {
        $this->objects['subjects']->action_create();
    }

    public function action_edit()
    {
        $this->objects['subjects']->action_edit();
    }
    
    public function action_delete() 
    {
        $this->objects['subjects']->action_delete();
    }

    public function action_changesubjects()
    {
        $this->objects['subjects']->action_changesubjects();
    }
}