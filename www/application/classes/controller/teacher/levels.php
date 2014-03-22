<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Levels extends Controller_Teacher_App {

    public function before() 
    {
        parent::before();
        $this->objects['levels']->set_breadcrumb_parent('students');
        $this->objects['levels']->set_breadcrumb_current('Grade Levels', 
            $this->request->param('id')); 
        $this->objects['levels']->set_breadcrumb();
    }
    
    public function action_list()
    {
        $this->objects['levels']->set_sidebar_path('layouts/sidebars/teacher/students');
        $this->objects['levels']->set_sidebar_index('levels');
        $this->objects['levels']->action_list();
    }
}