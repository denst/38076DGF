<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_DisciplinaryTeachers extends Controller_Sadmin_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['disciplinaryteachers']->set_records_breadcrumb('disciplinaryteachers', 'teachers');
    }
    
    public function action_list() 
    {
        $this->objects['disciplinaryteachers']->set_sidebar_index('list');
        $this->objects['disciplinaryteachers']->action_list();
    }
    
    public function action_create() 
    {
        $this->objects['disciplinaryteachers']->action_create();
    }
    
    public function action_edit() 
    {
        $this->objects['disciplinaryteachers']->action_edit();
    }
    
    public function action_delete() 
    {
        $this->objects['disciplinaryteachers']->action_delete();
    }
}
  