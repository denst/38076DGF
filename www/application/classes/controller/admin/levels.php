<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Levels extends Controller_Admin_App {
    
    private $slider_names = array('list' => 'Grade Levels', 
        'edit' => 'Edit Grade Levels', 'create' => 'Create Grade Levels',
        'unassignedstudents' => 'Unassigned Students');
    
    public function before() 
    {
        parent::before();
        $this->objects['levels']->set_fullscreen();
        $this->objects['levels']->set_settings_breadcrumb('levels', $this->slider_names);
    }
    
    public function action_list()
    {
        $this->objects['levels']->unset_sidebar_path();
//        $this->objects['levels']->set_fullscreen();
        $this->objects['levels']->action_list();
    }

    public function action_create()
    {
        $this->objects['levels']->action_create();
    }

    public function action_edit()
    {
        $this->objects['levels']->action_edit();
    }
   
    public function action_delete()
    {
        $this->objects['levels']->action_delete();
    }
    
    public function action_unassignedstudents()
    {
//        $this->objects['levels']->set_fullscreen();
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