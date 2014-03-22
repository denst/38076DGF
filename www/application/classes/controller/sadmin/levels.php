<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Levels extends Controller_Sadmin_App {
    
    private $slider_names = array('list' => 'Grade Levels', 
        'edit' => 'Edit Grade Levels', 'create' => 'Create Grade Levels',
        'unassignedstudents' => 'Unassigned Students');
    
    public function before() 
    {
        parent::before();
        $this->objects['levels']->set_sidebar_path('layouts/sidebars/sadmin/settings');
        $this->objects['levels']->set_sidebar_index('grade_levels');
        $this->objects['levels']->set_settings_breadcrumb('levels', $this->slider_names);
    }
    
    public function action_list()
    {        
        $this->objects['levels']->action_list();
    }

    public function action_create()
    {
        $this->objects['levels']->action_create();
    }

    public function action_edit()
    {
        $this->objects['levels']->set_breadcrumb_parent('levels');
        $this->objects['levels']->set_breadcrumb();
        $this->objects['levels']->action_edit();
    }
   
    public function action_delete()
    {
        $this->objects['levels']->action_delete();
    }
    
    public function action_unassignedstudents()
    {
        $this->objects['levels']->action_unassignedstudents();
    }
   
    public function action_autoassigned()
    {
        $this->objects['levels']->action_autoassigned();
    }    

    public function action_promotingdetaining()
    {
        $this->objects['levels']->action_promotingdetaining();
    }
}