<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_AchievementTeachers extends Controller_Sadmin_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['achievementteachers']->set_records_breadcrumb('achievementteachers', 'teachers');
    }
    
    public function action_list() 
    {
        $this->objects['achievementteachers']->set_sidebar_index('list');
        $this->objects['achievementteachers']->action_list();
    }
    
    public function action_create() 
    {
        $this->objects['achievementteachers']->action_create();
    }
    
    public function action_edit() 
    {
        $this->objects['achievementteachers']->action_edit();
    }
    
    public function action_delete() 
    {
        $this->objects['achievementteachers']->action_delete();
    }

}
  